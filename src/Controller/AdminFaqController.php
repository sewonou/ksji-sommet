<?php

namespace App\Controller;

use App\Entity\Faq;
use App\Form\FaqType;
use App\Repository\FaqRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFaqController extends AbstractController
{
    /**
     * @Route("/admin/faqs", name="admin_faq")
     * @param ObjectManager $manager
     * @param FaqRepository $repo
     * @param Request $request
     * @return Response
     */
    public function add(ObjectManager $manager,FaqRepository $repo, Request $request):Response
    {
        $faq = new Faq();
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user =$this->getUser();
            $faq->setAuthor($user);
            $this->addFlash('success', "La Question {$faq->getQuestion()} a bien été ajouter");
            $manager->persist($faq);
            $manager->flush();
            return $this->redirectToRoute('admin_faq');
        }
        return $this->render('admin/faq/index.html.twig', [
            'form' => $form->createView(),
            'faqs' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/faqs/{id}/edit", name="admin_faq_edit")
     * @param Faq $faq
     * @param ObjectManager $manager
     * @param FaqRepository $repo
     * @param Request $request
     * @return Response
     */
    public function edit(Faq $faq,ObjectManager $manager, FaqRepository $repo, Request $request):Response
    {
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user =$this->getUser();
            $faq->setAuthor($user);
            $this->addFlash('success', "La question {$faq->getQuestion()} a bien été Modifier");
            $manager->persist($faq);
            $manager->flush();
            return $this->redirectToRoute('admin_faq');
        }
        return $this->render('admin/faq/edit.html.twig', [
            'form' => $form->createView(),
            'faqs' => $repo->findAll(),
            'faq' => $faq,
        ]);
    }

    /**
     * @Route("/admin/faqs/{id}/delete", name="admin_faq_delete")
     * @param Faq $faq
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Faq $faq, ObjectManager $manager):Response
    {
        $this->addFlash('success', "La Question {$faq->getQuestion()} a bien été Supprimer");
        $manager->remove($faq);
        $manager->flush();
        return $this->redirectToRoute('admin_faq');
    }
}
