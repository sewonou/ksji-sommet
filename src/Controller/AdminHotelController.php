<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHotelController extends AbstractController
{
    /**
     * @Route("/admin/hotels", name="admin_hotel")
     * @param HotelRepository $repository
     * @return Response
     */
    public function index(HotelRepository $repository)
    {
        return $this->render('admin/hotel/index.html.twig', [
            'hotels' =>$repository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/hotels/add", name="admin_hotel_add")
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function add(ObjectManager $manager, Request $request): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Le participant  {$hotel->getName()} a bien été ajouter");
            $manager->persist($hotel);
            $manager->flush();
            return $this->redirectToRoute('admin_hotel');
        }
        return $this->render('admin/hotel/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/hotels/{id}/edit", name="admin_hotel_edit")
     * @param Hotel $hotel
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Hotel $hotel, ObjectManager $manager, Request $request): Response
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Le participant  {$hotel->getName()} a bien été modifier");
            $manager->persist($hotel);
            $manager->flush();
            return $this->redirectToRoute('admin_hotel');
        }
        return $this->render('admin/hotel/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/hotels/{id}/delete", name="admin_hotel_delete")
     * @param Hotel $hotel
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Hotel $hotel, ObjectManager $manager): Response
    {
        $this->addFlash('success', "Le participant {$hotel->getName()} a bien été Supprimer");
        $manager->remove($hotel);
        $manager->flush();
        return $this->redirectToRoute('admin_hotel');
    }
}
