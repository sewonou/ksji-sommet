<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getConfiguration('Prénom', "Vos prénoms ...")
            )
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration('Nom', "Votre nom ...")
            )
            ->add(
                'country',
                EntityType::class,
                $this->getConfiguration('Pays', "Votre pays ...", [
                    'class' => Country::class,
                    'placeholder' => "Choisir votre pays ...",
                    'choice_label' => 'name'
                ])
            )
            ->add(
                'gender',
                ChoiceType::class,
                $this->getConfiguration('Sexe', "Votre sexe ..", [
                    'choices'  => [
                        'Masculin' => 'M',
                        'Féminin' => 'F',
                    ],
                    'placeholder' => 'Choisir votre genre ...',
                ])
            )
            ->add(
                'board',
                TextType::class,
                $this->getConfiguration('Grande commanderie / auxilliairie', "Votre grande commanderie o auxiliarie d'appartenance")
            )
            ->add(
                'local',
                TextType::class,
                $this->getConfiguration('Commanderie Local / auxilliairie', "Votre commanderie ou auxiliarie d'appartenance")
            )
            ->add(
                'category',
                ChoiceType::class,
                $this->getConfiguration('Catégorie de participant', "Votre catégorie de participant", [
                    'choices'  => [
                        'Délégué' => 'Delegué',
                        'Observateur' => 'Observateur',
                    ],
                    'placeholder' => 'Choisir Votre catégorie ...',
                ])
            )
            ->add(
                'address',
                TextType::class,
                $this->getConfiguration('Adresse', "Votre adresse ..")
            )
            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration('E-mail', "Votre adresse email ...")
            )
            ->add(
                'hash',
                PasswordType::class,
                $this->getConfiguration('Mot de passe', "Votre mot de passe ...")
            )
            ->add(
                'imageFile',
                FileType::class,
                $this->getConfiguration('Photo', "Votre photo ...")
            )
            ->add(
                'phone',
                TextType::class,
                $this->getConfiguration('Contact', "Votre numérp de téléphone ..")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
