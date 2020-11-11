<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Repository\GalleryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGalleryController extends AbstractController
{
    /**
     * @Route("/admin/galleries", name="admin_gallery")
     * @param GalleryRepository $repository
     * @return Response
     */
    public function index(GalleryRepository $repository)
    {
        return $this->render('admin/gallery/index.html.twig', [
            'galleries' =>$repository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/galleries/add", name="admin_gallery_add")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function add(EntityManagerInterface $manager, Request $request): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $gallery->setAuthor($user);
            $this->addFlash('success', "Le participant  {$gallery->getId()} a bien été ajouter");
            $manager->persist($gallery);
            $manager->flush();
            return $this->redirectToRoute('admin_gallery');
        }
        return $this->render('admin/gallery/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/galleries/{id}/edit", name="admin_gallery_edit")
     * @param Gallery $gallery
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Gallery $gallery, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $gallery->setAuthor($user);
            $this->addFlash('success', "L'image  {$gallery->getId()} a bien été ajouter");
            $manager->persist($gallery);
            $manager->flush();
            return $this->redirectToRoute('admin_gallery');
        }
        return $this->render('admin/gallery/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/hotels/{id}/delete", name="admin_gallery_delete")
     * @param Gallery $gallery
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Gallery $gallery, EntityManagerInterface $manager): Response
    {
        $this->addFlash('success', "L'image {$gallery->getId()} a bien été Supprimer");
        $manager->remove($gallery);
        $manager->flush();
        return $this->redirectToRoute('admin_hotel');
    }
}
