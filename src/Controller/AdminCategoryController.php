<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="admin_category")
     * @param ObjectManager $manager
     * @param CategoryRepository $repo
     * @param Request $request
     * @return Response
     */
    public function add(ObjectManager $manager, CategoryRepository $repo, Request $request):Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "La catégorie {$category->getTitle()} a bien été ajouter");
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('admin/category/index.html.twig', [
            'form' => $form->createView(),
            'categories' => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/edit", name="admin_category_edit")
     * @param Category $category
     * @param ObjectManager $manager
     * @param CategoryRepository $repo
     * @param Request $request
     * @return Response
     */
    public function edit(Category $category,ObjectManager $manager, CategoryRepository $repo, Request $request):Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "La catégorie {$category->getTitle()} a bien été Modifier");
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView(),
            'categories' => $repo->findAll(),
            'category' => $category,
        ]);
    }

    /**
     * @Route("/admin/categories/{id}/delete", name="admin_category_delete")
     * @param Category $category
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Category $category, ObjectManager $manager):Response
    {
        $this->addFlash('success', "La catégorie {$category->getTitle()} a bien été Supprimer");
        $manager->remove($category);
        $manager->flush();
        return $this->redirectToRoute('admin_category');
    }
}
