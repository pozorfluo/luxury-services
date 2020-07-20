<?php

namespace App\Controller;

use App\Entity\AdminNote;
use App\Entity\Profile;
use App\Form\ProfileType;
use DateTime;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    use FileUploadTrait;
    /**
     * @Route("/list", name="profile_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(ProfileRepository $profileRepository): Response
    {
        return $this->render('profile/index.html.twig', [
            'profiles' => $profileRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="profile_show_user", methods={"GET"})
     */
    public function showUser(ProfileRepository $profileRepository): Response
    {
        return $this->render('profile/index.html.twig', [
            'profiles' => $profileRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="profile_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $profile = new Profile();
        $profile->setAdminNote(new AdminNote());

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $now = new DateTime();
            $profile->setUpdatedAt($now);

            $entityManager->persist($profile);
            $entityManager->flush();

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Profile $profile): Response
    {
        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profile_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        Profile $profile,
        SluggerInterface $slugger
    ): Response {
        // $formData = [
        //     'profile' => $profile,
        //     'adminNote' => $adminNote
        // ]

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // dd($form);
            $adminNote = $profile->getAdminNote();
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('adminNote')->get('file')->getData();

            if ($file) {
                $filename = $this->saveUpload(
                    $file,
                    $this->getParameter('admin_notes_dir'),
                    $slugger
                );
                $adminNote->setFiles([$filename]);
                $this->addFlash(
                    'notice',
                    $filename . ' saved !'
                );
            }

            $now = new DateTime();
            $profile->setUpdatedAt($now);
            $adminNote->setUpdatedAt($now);

            $entityManager->flush();

            return $this->redirectToRoute('profile_index');
        }

        // dd($profile->getAdminNote());
        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_delete", methods={"DELETE"})
     *  @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Profile $profile): Response
    {
        if ($this->isCsrfTokenValid('delete' . $profile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_index');
    }
}
