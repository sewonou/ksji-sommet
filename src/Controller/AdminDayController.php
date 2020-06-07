<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDayController extends AbstractController
{
    /**
     * @Route("/admin/day", name="admin_day")
     */
    public function index()
    {
        return $this->render('admin_day/index.html.twig', [
            'controller_name' => 'AdminDayController',
        ]);
    }
}
