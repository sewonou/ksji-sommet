<?php

namespace App\Controller;

use App\Entity\DayEvent;
use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Form\RegistrationType;
use App\Repository\CategoryRepository;
use App\Repository\ContentRepository;
use App\Repository\DayRepository;
use App\Repository\FaqRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CategoryRepository $categoryRepository
     * @param ContentRepository $contentRepository
     * @param DayRepository $dayRepository
     * @param FaqRepository $faqRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository, ContentRepository $contentRepository, DayRepository $dayRepository,FaqRepository $faqRepository)
    {
        $about = $categoryRepository->findOneBy(['title' => 'ABOUT']);


        return $this->render('home/index.html.twig', [
            'abouts' => $contentRepository->findBy(['category' => $about]),
            'faqs' => $faqRepository->findAll(),
            'days' => $dayRepository->findAll(),
        ]);
    }

    /**
     * @Route("/i", name="home_i")
     */
    public function index0():Response
    {
        return $this->render('home/index.html.twig', [

        ]);
    }
}
