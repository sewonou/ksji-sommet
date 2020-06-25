<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\ContentRepository;
use App\Repository\DayRepository;
use App\Repository\FaqRepository;
use App\Repository\GalleryRepository;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param GalleryRepository $galleryRepository
     * @param CategoryRepository $categoryRepository
     * @param ContentRepository $contentRepository
     * @param DayRepository $dayRepository
     * @param FaqRepository $faqRepository
     * @param HotelRepository $hotelRepository
     * @return Response
     */
    public function index(GalleryRepository $galleryRepository,CategoryRepository $categoryRepository, ContentRepository $contentRepository, DayRepository $dayRepository,FaqRepository $faqRepository, HotelRepository $hotelRepository)
    {
        $about = $categoryRepository->findOneBy(['title' => 'ABOUT']);


        return $this->render('home/index.html.twig', [
            'abouts' => $contentRepository->findBy(['category' => $about]),
            'faqs' => $faqRepository->findAll(),
            'days' => $dayRepository->findAll(),
            'hotels' => $hotelRepository->findAll(),
            'galleries' => $galleryRepository->findAll()
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
