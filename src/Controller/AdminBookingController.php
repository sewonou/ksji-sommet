<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking", name="admin_booking")
     * @param BookingRepository $repo
     * @return Response
     */
    public function index(BookingRepository $repo):Response
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repo->findAll(),
        ]);
    }

    /**
     *  @Route("/admin/booking/{id}/delete", name="admin_booking_delete")
     * @param Booking $booking
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager):Response
    {
        $this->addFlash('success', "La réservation  de  {$booking->getBooker()->getFullName()} du {$booking->getBooker()->getCountry()->getName()} a bien été Supprimer");
        $manager->remove($booking);
        $manager->flush();
        return $this->redirectToRoute('admin_day');
    }
}
