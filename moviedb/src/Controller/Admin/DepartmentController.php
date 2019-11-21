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
    public function edit(Department $department)
    {
        // On obtient l'objet $department grâce à la route (et donc au ParamConverter)
        $form = $this->createForm(DepartmentType::class, $department);

        return $this->render('admin/department/edit.html.twig', [
            'formDepartment' => $form->createView(),
            'department' => $department, 
        ]);
    }
}
