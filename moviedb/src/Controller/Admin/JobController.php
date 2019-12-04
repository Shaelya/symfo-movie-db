<?php

namespace App\Controller\Admin;

use App\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\JobType;

class JobController extends AbstractController
{
    /**
     * @Route("/admin/job", name="admin_job")
     */
    public function index()
    {

        // On veut afficher tous les départements, on va les chercher dans la base de données
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findAll();

        // On crée le formulaire
        $form = $this->createForm(JobType::class);

        return $this->render('admin/job/index.html.twig', [
            'jobs' => $jobs,
            'formJob' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/job/new", name="admin_job_new", methods={"POST"})
     */
    public function new(Request $request)
    {
        // Création d'un nouvel objet Job
        $job = new Job();

        // On crée un formulaire DepartmentType relié à $job
        $form = $this->createForm(JobType::class, $job);

        // On relie les infos reçues en POST avec le formulaire, donc avec l'objet $job
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
        }

        // On redirige vers la page admin des jobs
        return $this->redirectToRoute('admin_job');
    }


    /**
     * @Route("/admin/job/{job}/edit", name="admin_job_edit")
     */
    public function edit(Request $request, Job $job)
    {
        // On obtient l'objet $job grâce à la route (et donc au ParamConverter)
        $form = $this->createForm(JobType::class, $job);

        // On relie les données reçues en POST avec le formulaire
        $form->handleRequest($request);

        // Il est nécessaire d'enregistrer les données
        // Seulement si le formulaire a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
        }

        return $this->render('admin/job/edit.html.twig', [
            'formJob' => $form->createView(),
            'job' => $job, 
        ]);
    }

    /**
     * @Route("/admin/job/delete", name="admin_job_delete", methods={"POST"})
     */
    public function delete(Request $request)
    {
        $id = $request->request->get('job_id');
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        //Récupération du jeton dans la requête
        $token = $request->request->get('_token');
        // Vérification du jeton CSRF (il permet de vérifier que les infos reçues viennent bien d'un formulaire de Symfony)
        if ($this->isCsrfTokenValid('delete-job', $token)){
            $em = $this->getDoctrine()->getManager();
            // la méthode remove de l'entityManager permet de supprimer l'objet de la BDD
            $em->remove($job);
            $em->flush();

            $this->addFlash('success', 'Le Job a bien été supprimé !');
        } else {
            $this->addFlash('danger', 'Votre formulaire est invalide, veuillez recommencer !');
        }


        //Une fois fini, on redirige vers la liste des departments
        return $this->redirectToRoute('admin_job');
    }
}
