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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/admin/note")
 */
class AdminNoteController extends AbstractController
{
    use FileUploadTrait;
    /**
     * @Route("/", name="admin_note_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(AdminNoteRepository $adminNoteRepository): Response
    {
        return $this->render('admin_note/index.html.twig', [
            'admin_notes' => $adminNoteRepository->findAll(),
        ]);
    }
    /**
     * Used in dev template, not accessible as a route.
     */
    public function dumpRoutes(RouterInterface $router)
    {
        // $json = file_get_contents('https://jsonplaceholder.typicode.com/posts/1');
        // $json = json_decode($json, true);
        $routes = $router->getRouteCollection()->all();

        $parameterLessRoutes = [];
        foreach($routes as $name => $route)
        {
            // dump($route->__serialize()['compiled']->getPathVariables());
            // $compiledRoute = $route->__serialize()['compiled'];
            // if(isset($compiledRoute) && empty($compiledRoute->getPathVariables()))

            // if(!strpos($route->getPath(), '{' ))
            if(!preg_match('/{|_/m', $route->getPath()))
            {
                $parameterLessRoutes[] = $name;
            }
        }
        // dd($parameterLessRoutes);
        return $this->render('admin_note/routes.html.twig', [
            'routes' => $parameterLessRoutes,
            // 'routes' => array_keys($routes),
            // 'json' => $json
        ]);
    }
    /**
     * @Route("/new", name="admin_note_new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
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
                $this->addFlash(
                    'notice',
                    $filename . ' saved !'
                );
            }

            $now = new DateTime();
            $adminNote->setCreatedAt($now)
                ->setUpdatedAt($now);

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


            foreach ($adminNote->getFiles() as $filename) {
                $this->deleteSavedUpload(
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
     */
    public function download(string $filename): Response
    {
        // return $this->streamSavedUpload(
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
