<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
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
     * @param ParticipantRepository $repository
     * @return Response
     */
    public function index(StatService $stat, ParticipantRepository $repository)
    {
        return $this->render('admin/home/index.html.twig', [
            'stat' => $stat,
            'knights' => $repository->findBy(['gender'=>'M'],['id'=>'DESC'], 10,null),
            'ladies' => $repository->findBy(['gender'=>'F'],['id'=>'DESC'], 10,null),
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
