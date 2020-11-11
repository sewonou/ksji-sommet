<?php

namespace App\Controller;

use App\Entity\Content;
use App\Form\ContentType;
use App\Repository\ContentRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContentController extends AbstractController
{
    /**
     * @Route("/admin/contents", name="admin_content")
     * @param ObjectManager $manager
     * @param ContentRepository $repo
     * @param Request $request
     * @return Response
     */
    public function add(ObjectManager $manager, ContentRepository $repo, Request $request):Response
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user =$this->getUser();
            $content->setAuthor($user);
            $this->addFlash('success', "Le contenu {$content->getTitle()} a bien été ajouter");
            $manager->persist($content);
            $manager->flush();
            return $this->redirectToRoute('admin_content');
        }
        return $this->render('admin/content/index.html.twig', [
            'form' => $form->createView(),
            'contents' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/contents/{id}/edit", name="admin_content_edit")
     * @param Content $content
     * @param ObjectManager $manager
     * @param ContentRepository $repo
     * @param Request $request
     * @return Response
     */
    public function edit(Content $content,ObjectManager $manager, ContentRepository $repo, Request $request):Response
    {
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user =$this->getUser();
            $content->setAuthor($user);
            $this->addFlash('success', "Le contenu {$content->getTitle()} a bien été Modifier");
            $manager->persist($content);
            $manager->flush();
            return $this->redirectToRoute('admin_content');
        }
        return $this->render('admin/content/edit.html.twig', [
            'form' => $form->createView(),
            'contents' => $repo->findAll(),
            'content' => $content,
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/delete", name="admin_content_delete")
     * @param Content $content
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Content $content, ObjectManager $manager):Response
    {
        $this->addFlash('success', "Le Contenu  {$content->getTitle()} a bien été Supprimer");
        $manager->remove($content);
        $manager->flush();
        return $this->redirectToRoute('admin_content');
    }
}
