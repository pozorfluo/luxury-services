<?php

namespace App\Controller;

use App\Entity\AdminNote;
use App\Form\AdminNoteType;
use App\Repository\AdminNoteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\FileUpload;
use App\Service\DevLog;

/**
 * @Route("/admin/note")
 */
class AdminNoteController extends AbstractController
{
    /**
     * @Route("/", name="admin_note_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(AdminNoteRepository $adminNoteRepository): Response
    {
        $devLog = new DevLog();
        $devLog->log('admin_note_index',['mlskdf', 2, 'sqfd', ['poiop' => 'popopo']] );
        $devLog->log('admin_note_index', $adminNoteRepository );

        return $this->render('admin_note/index.html.twig', [
            'admin_notes' => $adminNoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_note_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request, FileUpload $fileUpload): Response
    {
        $adminNote = new AdminNote();
        $form = $this->createForm(AdminNoteType::class, $adminNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /**
             * @var UploadedFile $file
             */
            $file = $form->get('file')->getData();

            if ($file) {
                $filename = $fileUpload->save(
                    $file,
                    $this->getParameter('admin_notes_dir')
                );
                $adminNote->setFiles([$filename]);
                $this->addFlash(
                    'notice',
                    $filename . ' saved !'
                );
            }

            $entityManager->persist($adminNote);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Note created !'
            );

            return $this->redirectToRoute('admin_note_index');
        }

        return $this->render('admin_note/new.html.twig', [
            'admin_note' => $adminNote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_note_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(AdminNote $adminNote): Response
    {
        return $this->render('admin_note/show.html.twig', [
            'admin_note' => $adminNote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_note_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        AdminNote $adminNote,
        FileUpload $fileUpload
    ): Response {
        $form = $this->createForm(AdminNoteType::class, $adminNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /**
             * @var UploadedFile $file
             */
            $file = $form->get('file')->getData();

            if ($file) {
                $filename = $fileUpload->save(
                    $file,
                    $this->getParameter('admin_notes_dir')
                );
                $adminNote->setFiles([$filename]);
                $this->addFlash(
                    'notice',
                    $filename . ' saved !'
                );
            }
            $adminNote->setUpdatedAt(new DateTime());
            $entityManager->persist($adminNote);
            $entityManager->flush();


            return $this->redirectToRoute('admin_note_index');
        }

        return $this->render('admin_note/edit.html.twig', [
            'admin_note' => $adminNote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_note_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(
        Request $request,
        AdminNote $adminNote,
        FileUpload $fileUpload
    ): Response {
        if ($this->isCsrfTokenValid(
            'delete' . $adminNote->getId(),
            $request->request->get('_token')
        )) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adminNote);
            $entityManager->flush();


            foreach ($adminNote->getFiles() as $filename) {
                $fileUpload->deleteSaved(
                    $filename,
                    $this->getParameter('admin_notes_dir')
                );
                $this->addFlash(
                    'notice',
                    $filename . ' deleted !'
                );
            }
        }

        return $this->redirectToRoute('admin_note_index');
    }


    /**
     * todo Restrict access to admin.
     * see https://symfonycasts.com/screencast/symfony-uploads/downloading-private-files#play
     * 
     * @Route("/download/{filename}", name="admin_note_download", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function download(string $filename): Response
    {
        // return $fileUpload->streamSaved(
        //     $filename,
        //     $this->getParameter('admin_notes_dir'),
        //     false
        // );
        return $this->file(
            rtrim($this->getParameter('admin_notes_dir'), '/\\')
                . DIRECTORY_SEPARATOR
                . $filename,
            $filename,
            ResponseHeaderBag::DISPOSITION_INLINE
        );
    }
}
