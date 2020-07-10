<?php

namespace App\Controller;


use App\Entity\JobSector;
use App\Form\JobSectorType;
use App\Repository\JobSectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/job/sector")
 */
class JobSectorController extends AbstractController
{
    /**
     * @Route("/", name="job_sector_index", methods={"GET"})
     */
    public function index(JobSectorRepository $jobSectorRepository): Response
    {
        return $this->render('job_sector/index.html.twig', [
            'job_sectors' => $jobSectorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="job_sector_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jobSector = new JobSector();
        $form = $this->createForm(JobSectorType::class, $jobSector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jobSector);
            $entityManager->flush();

            return $this->redirectToRoute('job_sector_index');
        }

        return $this->render('job_sector/new.html.twig', [
            'job_sector' => $jobSector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_sector_show", methods={"GET"})
     */
    public function show(JobSector $jobSector): Response
    {
        return $this->render('job_sector/show.html.twig', [
            'job_sector' => $jobSector,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="job_sector_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JobSector $jobSector): Response
    {
        $form = $this->createForm(JobSectorType::class, $jobSector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_sector_index');
        }

        return $this->render('job_sector/edit.html.twig', [
            'job_sector' => $jobSector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_sector_delete", methods={"DELETE"})
     */
    public function delete(Request $request, JobSector $jobSector): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobSector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jobSector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_sector_index');
    }
}
