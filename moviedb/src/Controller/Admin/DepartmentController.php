<?php

namespace App\Controller\Admin;

use App\Entity\Department;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/admin/department", name="admin_department")
     */
    public function index()
    {

        $departments = $this->getDoctrine()->getRepository(Department::class)->findAll();

        return $this->render('admin/department/index.html.twig', [
            'departments' => $departments,
        ]);
    }
}
