<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\ContentRepository;
use App\Repository\DayRepository;
use App\Repository\FaqRepository;
use App\Repository\GalleryRepository;
use App\Repository\HotelRepository;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param GalleryRepository $galleryRepository
     * @param CategoryRepository $categoryRepository
     * @param ContentRepository $contentRepository
     * @param DayRepository $dayRepository
     * @param FaqRepository $faqRepository
     * @param HotelRepository $hotelRepository
     * @param MailerInterface $mailer
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function index(GalleryRepository $galleryRepository,CategoryRepository $categoryRepository, ContentRepository $contentRepository, DayRepository $dayRepository,FaqRepository $faqRepository, HotelRepository $hotelRepository, MailerInterface $mailer, Request $request, EntityManagerInterface $manager)
    {
        $about = $categoryRepository->findOneBy(['title' => 'ABOUT']);
        $contact = new Contact();
        $my_mail = 'info@soa2021.ksjitogo.org';
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $date = new \DateTime();
            $email = (new Email())
                ->from($contact->getEmail())
                ->to($my_mail)
                ->cc($contact->getEmail())
                ->subject('SOMMET OUEST AFRICAIN 2021 :'.$contact->getSubject())
                ->html('
                              <h1 style="color: #9f191f;">'.$contact->getSubject().'</h1>
                              <h2 style=" color: #0c0c0c">Emetteur : '.$contact->getName().'</h2>
                              <h2 style="color: #0c0c0c">Email: '.$contact->getEmail().'</h2>
                              <p style="font-size: 24px;font-style:italic ">'.$contact->getMessage().'</p>
                              <p style="font-size: 14px;font-style:italic">Mail envoyer à partir de soa2021.ksjitogo.org le : '.date_format($date, 'd-m-Y H:i:s').'</p>
                              ');

            $mailer->send($email);
            $manager->persist($contact);
            $manager->flush();
            $this->addFlash('success', "Message envoyer avec succès, consulter votre email");
            return  $this->redirectToRoute('home');
        }
        return $this->render('home/index.html.twig', [
            'abouts' => $contentRepository->findBy(['category' => $about]),
            'faqs' => $faqRepository->findAll(),
            'days' => $dayRepository->findAll(),
            'hotels' => $hotelRepository->findAll(),
            'galleries' => $galleryRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/i", name="home_i")
     */
    public function index0():Response
    {
        return $this->render('home/index.html.twig', [

        ]);
    }
}
