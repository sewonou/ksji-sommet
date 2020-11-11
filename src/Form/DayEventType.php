<?php

namespace App\Form;

use App\Entity\Day;
use App\Entity\DayEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayEventType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hour', TimeType::class,
                $this->getConfiguration('Heure', "Choisir l'heure de l'activité", [
                    'widget' => 'single_text',
                    'input' => 'datetime',
                ]))
            ->add('title', TextType::class,
                $this->getConfiguration('Titre', "Saisir le titre de l'activité"))
            ->add('speaker', TextType::class,
                $this->getConfiguration('Orateur', "Saisir le nom complet de l'orateur"))
            ->add('day', EntityType::class,
                $this->getConfiguration('Jour', "le jour de l'activité", [
                    'class' => Day::class,
                    'choice_label' => 'info',
                ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DayEvent::class,
        ]);
    }
}
