<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDayEventController extends AbstractController
{
    /**
     * @Route("/admin/day/event", name="admin_day_event")
     */
    public function index()
    {
        return $this->render('admin_day_event/index.html.twig', [
            'controller_name' => 'AdminDayEventController',
        ]);
    }
}
