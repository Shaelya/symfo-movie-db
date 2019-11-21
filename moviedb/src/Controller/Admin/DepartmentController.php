<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/admin/department", name="admin_department")
     */
    public function index()
    {
        return $this->render('admin/department/index.html.twig', [
            'controller_name' => 'DepartmentController',
        ]);
    }
}
