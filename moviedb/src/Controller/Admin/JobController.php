<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    /**
     * @Route("/admin/job", name="admin_job")
     */
    public function index()
    {
        return $this->render('admin/job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }
}
