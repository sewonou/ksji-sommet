<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCountryController extends AbstractController
{
    /**
     * @Route("/admin/country", name="admin_country")
     */
    public function index()
    {
        return $this->render('admin_country/index.html.twig', [
            'controller_name' => 'AdminCountryController',
        ]);
    }
}
