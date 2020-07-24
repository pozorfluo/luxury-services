<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\Application;
use App\Form\JobType;
use App\Repository\ApplicationRepository;
use DateTime;
use App\Repository\JobRepository;
use App\Repository\JobSectorRepository;
use App\Service\DevLog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/list", name="job_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(JobRepository $jobRepository): Response
    {
        return $this->render('job/index.html.twig', [
            'jobs' => $jobRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="job_offers", methods={"GET"})
     */
    public function jobOffers(
        JobRepository $jobRepository,
        JobSectorRepository $jobSectorRepository,
        ApplicationRepository $applicationRepository
    ): Response {

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // if the user is anonymous, redirect to login form
        if (!($user instanceof UserInterface)) {
            return $this->redirectToRoute('app_login');
        }


        $profile = $user->getProfile();
        $applications = [];
        if (isset($profile)) {
            // $applications = $profile->getApplications()->getValues();
            $applications = $applicationRepository->findAllByProfile(
               $profile
            );
        }


        $jobs = $jobRepository->findBy(['isActive' => true], null, 100);
        $jobSectors = $jobSectorRepository->findAll();


        $dev = new DevLog($applications, "before");

        return $this->render('job/job_offers.html.twig', [
            'jobs' => $jobs,
            'job_sectors' => $jobSectors,
            'applications' => $applications
        ]);
    }

    /**
     * @Route("/new", name="job_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $now = new DateTime();
            $job->setCreatedAt($now)
                ->setUpdatedAt($now);

            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/new.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_show", methods={"GET"})
     */
    public function show(Job $job): Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="job_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Job $job): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/edit.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /** 
     * @Route("/{id}", name="job_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Job $job): Response
    {
        if (
            $this->isCsrfTokenValid(
                'delete' . $job->getId(),
                $request->request->get('_token')
            )
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($job);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_index');
    }
}
