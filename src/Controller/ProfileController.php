<?php

namespace App\Controller;

use App\Entity\AdminNote;
use App\Entity\Profile;
use App\Form\ProfileType;
use DateTime;
use App\Repository\ProfileRepository;
use App\Service\DevLog;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\FileUpload;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;


/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
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

            $profile->setUser($user);

            $this->setProfileWithFormFiles($profile, $form);

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
        if (!($user instanceof UserInterface)) {
            return $this->redirectToRoute('app_login');
        }

        $profile = $user->getProfile();
        if (!isset($profile)) {
            $profile = new Profile();
            return $this->redirectToRoute('profile_new');
        }

        return $this->show($profile);
    }

    /**
     * @Route("/{id}", name="profile_show", methods={"GET"})
     */
    public function show(Profile $profile): Response
    {
        // * @IsGranted("VIEW", subject="profile")
        $this->denyAccessUnlessGranted('view', $profile);

        return $this->render('profile/show.html.twig', [
            'profile' => $profile,
        ]);
    }

    /**
     * @Route("/edit", name="profile_edit_user", methods={"GET","POST"}, priority=2)
     */
    public function editUser(Request $request): Response
    {
        $user = $this->getUser();

        // if the user is anonymous, redirect to login form
        if (!($user instanceof UserInterface)) {
            return $this->redirectToRoute('app_login');
        }

        $profile = $user->getProfile();

        // Redirect users who do not have a profile to create form
        if (!isset($profile)) {
            $profile = new Profile();
            return $this->redirectToRoute('profile_new');
        }

        return $this->edit($request, $profile);
    }

    /**
     * @Route("/{id}/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Profile $profile
    ): Response {
        $this->denyAccessUnlessGranted('edit', $profile);

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $now = new DateTime();
            $profile->setUpdatedAt($now);

            if ($this->isGranted('ROLE_ADMIN')) {
                $adminNote = $profile->getAdminNote();
                // dd($form->get('adminNote'));
                $path = $this->getParameter('admin_notes_dir');
                $adminNote->setFiles([$this->retrieveUpload(
                    $form->get('adminNote'),
                    'file',
                    $path
                )]);
                $adminNote->setUpdatedAt($now);
            }

            $this->setProfileWithFormFiles($profile, $form);

            $entityManager->flush();

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('profile/edit.html.twig', [
            'profile' => $profile,
            'adminNote' =>   $profile->getAdminNote() ?? new AdminNote(),
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="profile_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Profile $profile): Response
    {
        // $this->denyAccessUnlessGranted('delete', $profile);

        if ($this->isCsrfTokenValid(
            'delete' . $profile->getId(),
            $request->request->get('_token')
        )) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_new');
    }

    /**
     * @Route("/download/{userId}/{filename}", name="profile_download", methods={"GET"})
     */
    public function download(string $userId, string $filename): Response
    {
        $this->denyAccessUnlessGranted('view', $this->getUser()->getProfile());

        return $this->file(
            rtrim($this->getParameter('users_dir'), '/\\')
                . DIRECTORY_SEPARATOR
                . $userId
                . DIRECTORY_SEPARATOR
                . $filename,
            $filename,
            ResponseHeaderBag::DISPOSITION_INLINE
        );
    }

    private function retrieveUpload(
        FormInterface $form,
        string $field,
        string $path
    ): string {
        $fileUpload = new FileUpload(new AsciiSlugger());
        /** @var UploadedFile $file*/
        $file = $form->get($field)->getData();

        $filename = '';
        if ($file) {
            $filename = $fileUpload->save(
                $file,
                $path
            );

            $this->addFlash(
                'notice',
                $filename . ' saved !'
            );
        }

        return $filename;
    }

    private function setProfileWithFormFiles(Profile $profile, FormInterface $form)
    {
        $path = $this->getParameter('users_dir')
            . DIRECTORY_SEPARATOR
            . $profile->getUser()->getId();

        $profile->setPicture(
            $this->retrieveUpload($form, 'picture', $path)
        );
        $profile->setCurriculumVitae(
            $this->retrieveUpload($form, 'curriculumVitae', $path)
        );
        $profile->setPassportScan(
            $this->retrieveUpload($form, 'passportScan', $path)
        );
        if ($profile->getPassportScan() !== '') {
            $profile->setHasPassport(true);
        }
    }
}
