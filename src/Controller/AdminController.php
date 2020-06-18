<?php

namespace App\Controller;

use App\Service\StatService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param StatService $stat
     * @return Response
     */
    public function index(StatService $stat)
    {
        return $this->render('admin/home/index.html.twig', [
            'stat' => $stat,
        ]);
    }

    /**
     * @Route("admin/login", name="admin_account_login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils):Response
    {
        $errors  = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('admin/account/login.html.twig', [
            'hasError' => $errors !== null,
            'username' => $username,
        ]);
    }

    /**
     * @Route("admin/logout", name="admin_account_logout")
     */
    public function logout()
    {

    }
}
