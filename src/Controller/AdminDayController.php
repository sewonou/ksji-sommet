<?php

namespace App\Controller;

use App\Entity\Day;
use App\Form\DayType;
use App\Repository\DayRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDayController extends AbstractController
{
    /**
     * @Route("/admin/days", name="admin_day")
     * @param ObjectManager $manager
     * @param Request $request
     * @param DayRepository $repo
     * @return Response
     */
    public function index(ObjectManager $manager, Request $request, DayRepository $repo):Response
    {
        $day = new Day();
        $form = $this->createForm(DayType::class, $day);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Le Jour {$day->getTitle()} a bien été ajouter");
            $manager->persist($day);
            $manager->flush();
            return $this->redirectToRoute('admin_day');
        }
        return $this->render('admin/day/index.html.twig', [
            'form' => $form->createView(),
            'days' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/days/{id}/edit", name="admin_day_edit")
     * @param Day $day
     * @param ObjectManager $manager
     * @param Request $request
     * @param DayRepository $repo
     * @return Response
     */
    public function edit(Day $day,ObjectManager $manager, Request $request, DayRepository $repo):Response
    {
        $form = $this->createForm(DayType::class, $day);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Le Jour {$day->getTitle()} a bien été modifier");
            $manager->persist($day);
            $manager->flush();
            return $this->redirectToRoute('admin_day');
        }
        return $this->render('admin/day/edit.html.twig', [
            'form' => $form->createView(),
            'days' => $repo->findAll(),
            'day' => $day,
        ]);
    }

    /**
     * @Route("/admin/days/{id}/delete", name="admin_day_delete")
     * @param Day $day
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Day $day, ObjectManager $manager):Response
    {
        $this->addFlash('success', "La catégorie {$day->getTitle()} a bien été Supprimer");
        $manager->remove($day);
        $manager->flush();
        return $this->redirectToRoute('admin_day');
    }
}
