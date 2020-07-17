<?php

namespace App\Controller;

use App\Entity\AdminNote;
use App\Form\AdminNoteType;
use App\Repository\AdminNoteRepository;
use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/admin/note")
 */
class AdminNoteController extends AbstractController
{
    use FileUploadTrait;
    /**
     * @Route("/", name="admin_note_index", methods={"GET"})
     */
    public function index(AdminNoteRepository $adminNoteRepository): Response
    {
        return $this->render('admin_note/index.html.twig', [
            'admin_notes' => $adminNoteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_note_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        ParameterBagInterface $parameterBag,
        SluggerInterface $slugger
    ): Response {
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
                $filename = $this->saveUpload(
                    $file,
                    $this->getParameter('admin_notes_dir'),
                    $slugger
                );
                $adminNote->setFiles([$filename]);
            }

            $now = new DateTime();
            $adminNote->setCreatedAt($now)
                ->setUpdatedAt($now);

            $entityManager->persist($adminNote);
            $entityManager->flush();

            $this->addFlash(
                'notice',
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
     */
    public function show(AdminNote $adminNote): Response
    {
        return $this->render('admin_note/show.html.twig', [
            'admin_note' => $adminNote,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AdminNote $adminNote): Response
    {
        $form = $this->createForm(AdminNoteType::class, $adminNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_note_index');
        }

        return $this->render('admin_note/edit.html.twig', [
            'admin_note' => $adminNote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_note_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AdminNote $adminNote): Response
    {
        if ($this->isCsrfTokenValid(
            'delete' . $adminNote->getId(),
            $request->request->get('_token')
        )) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adminNote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_note_index');
    }
}


/**
 * todo Restrict access to admin.
 * see https://symfonycasts.com/screencast/symfony-uploads/downloading-private-files#play
 * 
 * @Route("/{id}", name="admin_note_download", methods={"GET"})
 */
    // public function download(AdminNote $adminNote): Response
    // {
    // }
