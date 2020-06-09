<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCountryController extends AbstractController
{
    /**
     * @Route("/admin/countries", name="admin_country")
     * @param ObjectManager $manager
     * @param CountryRepository $repo
     * @param Request $request
     * @return Response
     */
    public function index(ObjectManager $manager, CountryRepository $repo, Request $request):Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Le pays {$country->getName()} a bien été enregistrer");
            $manager->persist($country);
            $manager->flush();
            return $this->redirectToRoute('admin_country');
        }
        return $this->render('admin/country/index.html.twig', [
            'form' => $form->createView(),
            'countries' => $repo->findAll(),
            'country' => $country,
        ]);
    }

    /**
     * @Route("/admin/countries/{id}/edit", name="admin_country_edit")
     * @param Country $country
     * @param ObjectManager $manager
     * @param CountryRepository $repo
     * @param Request $request
     * @return Response
     */
    public function edit(Country $country,ObjectManager $manager, CountryRepository $repo, Request $request):Response
    {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', "Le pays {$country->getName()} a bien été Modifier");
            $manager->persist($country);
            $manager->flush();
            return $this->redirectToRoute('admin_country');
        }
        return $this->render('admin/country/edit.html.twig', [
            'form' => $form->createView(),
            'countries' => $repo->findAll(),
            'country' => $country,
        ]);
    }

    /**
     * @Route("/admin/countries/{id}/delete", name="admin_country_delete")
     * @param Country $country
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Country $country, ObjectManager $manager):Response
    {
        $this->addFlash('success', "Le pays {$country->getName()} a bien été Supprimer");
        $manager->remove($country);
        $manager->flush();
        return $this->redirectToRoute('admin_country');
    }
}
