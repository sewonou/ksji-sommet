<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,
                $this->getConfiguration('Dénommination', "Saisir la dénommination de l'hotel ..."))
            ->add('introduction', TextType::class,
                $this->getConfiguration('Introduction', "Sasir un description introductive de l'hotel"))
            ->add('rating', IntegerType::class, $this->getConfiguration('Note sur 5', 'Veuillez indiquer une note entre  0 et 5', [
                'attr'=>[
                    'min' => 0,
                    'max' => 5,
                    'step' => 1
                ]
            ]))
            ->add('price', IntegerType::class, $this->getConfiguration('Prix', 'Veuillez indiquer le prix de la chambre'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
