<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Article;


class EditArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => `Nom de l'article`,
            'attr' => ['class' => 'form-control mb-3']
        ])

        ->add('title', TextType::class, [
            'label' => `Titre de l'article`,
            'attr' => ['class' => 'form-control mb-3']
        ])

        ->add('text', TextareaType::class, [
            'label' => 'Description',
            'attr' => ['class' => 'form-control mb-3']
        ])

        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'attr' => ['class' => 'form-control mb-3']
        ])

        ->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-outline-success'],
            'label' => 'Mettre à jour',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
