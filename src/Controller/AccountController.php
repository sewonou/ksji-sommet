<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Entity\Participant;
use App\Entity\User;
use App\Form\ParticipantType;
use App\Form\RegistrationType;
use App\Repository\CountryRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index():Response
    {
        return $this->render('account/index.html.twig', [

        ]);
    }

    /**
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils):Response
    {
        $errors  = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $errors !== null,
            'username' => $username,
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/registration", name="registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, CountryRepository $repo):Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $participant->setActive(false);
            $hash = $encoder->encodePassword($participant, $participant->getHash());
            $country = $repo->findOneBy(['name'=>$participant->getCountry()]);
            if($hash === $country->getPassword()){
                $this->addFlash(
                    'success',
                    "Vous avez été enregistrer avec succès. un mail de confirmation vous sera envoyé."
                );
                $participant->setHash($hash);
                $manager->persist($participant);
                $manager->flush();
                return $this->redirectToRoute('home');

            }else{
                $this->addFlash(
                    'danger',
                    "Votre mot de passe est incorrect contacter votre président de commanderie."
                );
            }

        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/booking/{id}", name="account_booking")
     * @param Hotel $hotel
     * @return Response
     */
    public function booking(Hotel $hotel):Response
    {
        return $this->redirectToRoute('home');
    }
}
