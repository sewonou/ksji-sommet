<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Content;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class,
                $this->getConfiguration('Catégorie', "Choisir catégorie ...", [
                    'placeholder' => 'Choisir la catégorie ...',
                    'class' => Category::class,
                    'choice_label' => 'title'
                ]))
            ->add('title', TextType::class,
                $this->getConfiguration('Titre', "Saisir le titre du contenu ..."))
            ->add('description', TextareaType::class,
                $this->getConfiguration('Description', "Saisir le titre du contenu ..."))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
