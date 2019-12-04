<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\DepartmentType;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/admin/department", name="admin_department")
     */
    public function index()
    {

        // On veut afficher tous les départements, on va les chercher dans la base de données
        $departments = $this->getDoctrine()->getRepository(Department::class)->findAll();

        // On crée le formulaire
        $form = $this->createForm(DepartmentType::class);

        return $this->render('admin/department/index.html.twig', [
            'departments' => $departments,
            'formDepartment' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/department/new", name="admin_department_new", methods={"POST"})
     */
    public function new(Request $request)
    {
        // Création d'un nouvel objet Department
        $department = new Department();

        // On crée un formulaire DepartmentType relié à $department
        $form = $this->createForm(DepartmentType::class, $department);

        // On relie les infos reçues en POST avec le formulaire, donc avec l'objet $department
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();
        }

        // On redirige vers la page admin des departements
        return $this->redirectToRoute('admin_department');
    }


    /**
     * @Route("/admin/department/{department}/edit", name="admin_department_edit")
     */
    public function edit(Request $request, Department $department)
    {
        // On obtient l'objet $department grâce à la route (et donc au ParamConverter)
        $form = $this->createForm(DepartmentType::class, $department);

        // On relie les données reçues en POST avec le formulaire
        $form->handleRequest($request);

        // Il est nécessaire d'enregistrer les données
        // Seulement si le formulaire a été envoyé et qu'il est valide
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();
        }

        return $this->render('admin/department/edit.html.twig', [
            'formDepartment' => $form->createView(),
            'department' => $department, 
        ]);
    }

    /**
     * @Route("/admin/department/delete", name="admin_department_delete", methods={"POST"})
     */
    public function delete(Request $request)
    {
        $id = $request->request->get('department_id');
        $department = $this->getDoctrine()->getRepository(Department::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        // la méthode remove de l'entityManager permet de supprimer l'objet de la BDD
        $em->remove($department);
        $em->flush();

        //Une fois fini, on redirige vers la liste des departments
        return $this->redirectToRoute('admin_department');
    }
}
