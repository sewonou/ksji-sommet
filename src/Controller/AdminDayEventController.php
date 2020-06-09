<?php

namespace App\Controller;

use App\Entity\DayEvent;
use App\Form\DayEventType;
use App\Repository\DayEventRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDayEventController extends AbstractController
{
    /**
     * @Route("/admin/days/events", name="admin_day_event")
     * @param ObjectManager $manager
     * @param Request $request
     * @param DayEventRepository $repo
     * @return Response
     */
    public function index(ObjectManager $manager, Request $request, DayEventRepository $repo):Response
    {
        $dayEvent = new DayEvent();
        $form = $this->createForm(DayEventType::class, $dayEvent);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Vous avez bien enregistrer l'évenement {$dayEvent->getTitle()} ");
            $author = $this->getUser();
            $dayEvent->setAuthor($author);
            $manager->persist($dayEvent);
            $manager->flush();
            return $this->redirectToRoute('admin_day_event');
        }
        return $this->render('admin/day_event/index.html.twig', [
            'form' => $form->createView(),
            'dayEvents' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/days/events/{id}/edit ", name="admin_day_event_edit")
     * @param DayEvent $dayEvent
     * @param ObjectManager $manager
     * @param Request $request
     * @param DayEventRepository $repo
     * @return Response
     */
    public function edit(DayEvent $dayEvent,ObjectManager $manager, Request $request, DayEventRepository $repo):Response
    {
        $form = $this->createForm(DayEventType::class, $dayEvent);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $author = $this->getUser();
            $dayEvent->setAuthor($author);
            $this->addFlash('success', "Vous avez bien modifier l'évenement {$dayEvent->getTitle()} ");
            $manager->persist($dayEvent);
            $manager->flush();
            return $this->redirectToRoute('admin_day_event');
        }
        return $this->render('admin/day_event/index.html.twig', [
            'form' => $form->createView(),
            'dayEvents' => $repo->findAll(),
            'dayEvent' => $dayEvent,
        ]);
    }

    /**
     * @Route("/admin/days/events/{id}/delete", name="admin_day_event_delete")
     * @param ObjectManager $manager
     * @param DayEvent $dayEvent
     * @return Response
     */
    public function delete(ObjectManager $manager, DayEvent $dayEvent):Response
    {
        $this->addFlash('success', "Vous avez bien supprimer l'évenement {$dayEvent->getTitle()} ");
        $manager->remove($dayEvent);
        $manager->flush();
        return $this->redirectToRoute('admin_day_event');
    }
}
