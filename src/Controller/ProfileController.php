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
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @Route("/new", name="profile_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Redirect users who already have a profile to edit form
        if ($user->getProfile() instanceof Profile) {
            return $this->redirectToRoute('profile_edit');
        }

        $profile = new Profile();
        $profile->setAdminNote(new AdminNote());

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $now = new DateTime();
            $profile->setUpdatedAt($now);

            $profile->setUser($user);

            $entityManager->persist($profile);
            $entityManager->flush();

            return $this->redirectToRoute('profile_show_user');
        }

        return $this->render('profile/new.html.twig', [
            'profile' => $profile,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="profile_show_user", methods={"GET"})
     */
    public function showUser(): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // if the user is anonymous, redirect to login form
        if (!$user instanceof UserInterface) {
            return $this->redirectToRoute('app_login');
        }

        $profile = $user->getProfile();
        if (!isset($profile)) {
            $profile = new Profile();
            return $this->redirectToRoute('profile_new');
        }
        $this->denyAccessUnlessGranted('view', $profile);

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }
    /**
     * @Route("/{id}", name="profile_show", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function show(Profile $profile): Response
    {
        /** @var \App\Entity\User */
        $user = $this->getUser();

        $this->denyAccessUnlessGranted('view', $profile);

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    // private function editForm(
    //     Request $request,
    //     Profile $profile,
    //     SluggerInterface $slugger
    // ) : Response
    // {
    //     $form = $this->createForm(ProfileType::class, $profile);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         // dd($form);
    //         $adminNote = $profile->getAdminNote();
    //         /**
    //          * @var UploadedFile $file
    //          */
    //         $file = $form->get('adminNote')->get('file')->getData();

    //         if ($file) {
    //             $filename = $this->saveUpload(
    //                 $file,
    //                 $this->getParameter('admin_notes_dir'),
    //                 $slugger
    //             );
    //             $adminNote->setFiles([$filename]);
    //             $this->addFlash(
    //                 'notice',
    //                 $filename . ' saved !'
    //             );
    //         }

    //         $now = new DateTime();
    //         $profile->setUpdatedAt($now);
    //         $adminNote->setUpdatedAt($now);

    //         $entityManager->flush();

    //         return $this->redirectToRoute('profile_index');
    //     }

    //     return $this->render('profile/edit.html.twig', [
    //         'profile' => $profile,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/edit", name="profile_edit_user", methods={"GET","POST"}, priority=2)
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function editUser(
        Request $request,
        SluggerInterface $slugger
    ):Response {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // if the user is anonymous, redirect to login form
        if (!$user instanceof UserInterface) {
            return $this->redirectToRoute('app_login');
        }

        $profile = $user->getProfile();

        if (!isset($profile)) {
            $profile = new Profile();
            return $this->redirectToRoute('profile_new');
        }

        $this->denyAccessUnlessGranted('edit', $profile);

        return $this->edit($request, $profile, $slugger);
    }

    /**
     * @Route("/{id}/edit", name="profile_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
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
        // return $this->editForm($request, $profile, $slugger);
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
