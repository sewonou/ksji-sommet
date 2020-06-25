<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationType;
use App\Repository\ParticipantRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminParticipantController extends AbstractController
{
    /**
     * @Route("/admin/participants", name="admin_participant")
     * @param ParticipantRepository $repo
     * @return Response
     */
    public function index(ParticipantRepository $repo):Response
    {
        return $this->render('admin/participant/index.html.twig', [
            'participants' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/participants/bygender/{gender}", name="admin_participant_bygender")
     * @param ParticipantRepository $repo
     * @param string $gender
     * @return Response
     */
    public function byGender(ParticipantRepository $repo, string $gender):Response
    {
        return $this->render('admin/participant/index.html.twig', [
            'participants' => $repo->findBy(['gender'=>$gender]),
        ]);
    }

    /**
     * @Route("/admin/participants/bycountry/{country}", name="admin_participant_bycountry")
     * @param ParticipantRepository $repo
     * @param string $country
     * @return Response
     */
    public function byCountry(ParticipantRepository $repo, string  $country):Response
    {
        return $this->render('admin/participant/index.html.twig', [
            'participants' => $repo->findBy(['country'=>$country]),
        ]);
    }


    /**
     * @Route("/admin/participants/add", name="admin_participant_add")
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function add(ObjectManager $manager, Request $request): Response
    {
        $participant = new Participant();
        $form = $this->createForm(RegistrationType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', "Le participant  {$participant->getFullName()} a bien été ajouter");
            $manager->persist($participant);
            $manager->flush();
            return $this->redirectToRoute('admin_participant');
        }
        return $this->render('admin/participant/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/partiticpants/{id}/edit", name="admin_participant_edit")
     * @param Participant $participant
     * @param ObjectManager $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Participant $participant, ObjectManager $manager, Request $request): Response
    {
        $form = $this->createForm(RegistrationType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', "Le participant  {$participant->getFullName()} a bien été modifier");
            $manager->persist($participant);
            $manager->flush();
            return $this->redirectToRoute('admin_participant');
        }
        return $this->render('admin/participant/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/participants/{id}/delete", name="admin_participant_delete")
     * @param Participant $participant
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Participant $participant, ObjectManager $manager): Response
    {
        $this->addFlash('success', "Le participant {$participant->getFullName()} a bien été Supprimer");
        $manager->remove($participant);
        $manager->flush();
        return $this->redirectToRoute('admin_participant');
    }

}
