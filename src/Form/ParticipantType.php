<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Hotel;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getConfiguration('First Names', "Vos prénoms ..."))
            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration('Last Name', "Votre nom ..."))
            ->add(
                'country',
                EntityType::class,
                $this->getConfiguration('Country', "Votre pays ...", [
                    'class' => Country::class,
                    'placeholder' => "Choisir votre pays ...",
                    'choice_label' => 'name'
                ]))
            ->add(
                'gender',
                ChoiceType::class,
                $this->getConfiguration('Sex', "Votre sexe ..", [
                    'choices'  => [
                        'Man' => 'M',
                        'Female' => 'F',
                    ],
                    'placeholder' => 'Choisir votre genre ...',
                ]))
            ->add(
                'board',
                TextType::class,
                $this->getConfiguration('Grand commandery / auxiliary', "Votre grande commanderie o auxiliarie d'appartenance"))
            ->add(
                'local',
                TextType::class,
                $this->getConfiguration('Local Commandery  / auxilliairy', "Votre commanderie ou auxiliarie d'appartenance"))
            ->add(
                'category',
                ChoiceType::class,
                $this->getConfiguration('Category of participant', "Votre catégorie de participant", [
                    'choices'  => [
                        'Delegate' => 'Délégué',
                        'Observer' => 'Observateur',
                    ],
                    'placeholder' => 'Choisir Votre catégorie ...',
                ]))
            ->add(
                'address',
                TextType::class,
                $this->getConfiguration('Address', "Votre adresse .."))
            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration('E-mail', "Votre adresse email ..."))
            ->add(
                'hash',
                PasswordType::class,
                $this->getConfiguration('Country password', "Le mot de passe  de votre pays..."))
            ->add(
                'imageFile',
                FileType::class,
                $this->getConfiguration('Picture in official uniform', "Votre photo en uniforme officiel..."))
            ->add(
                'phone',
                TextType::class,
                $this->getConfiguration('Contact', "Votre numérp de téléphone .."))
            ->add(
                'arrivalWay',
                ChoiceType::class,
                $this->getConfiguration('Arrival Way', "Votre moyen d'arrivé", [
                    'choices'  => [
                        'Aerial voice' => 'Avion',
                        'Earthly voice' => 'Voiture',
                        'Maritime voice' => 'Bateau',
                    ],
                    'placeholder' => 'Choisir Votre voix d\'arrivé ...',
                ]))
            ->add(
                'arrivalTime',
                DateTimeType::class,
                $this->getConfiguration('Arrival Date and Time', "Votre heure d'arrivé ..", [
                    'widget' => 'single_text'
                ]))
            ->add(
                'departureTime',
                DateTimeType::class,
                $this->getConfiguration('Departure Date and Time', "Votre numérp de téléphone ..", [
                    'widget' => 'single_text'
                ]))
            ->add(
                'hotel',
                EntityType::class,
                $this->getConfiguration('Hotel', "Sélectionner un hotel  ..", [
                    'class' => Hotel::class,
                    'placeholder' => "Sélectionner un hotel de résidence ...",
                    'choice_label' => 'name',
                    'required' => false,
                ]))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
