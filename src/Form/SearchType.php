<?php

namespace App\Form;

use App\Entity\Theme;
use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SearchType as TypeSearchType;

class SearchType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('q', TypeSearchType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'Recherche'
            ]
            ])
        ->add('new', CheckboxType::class, [
            'label' => 'Nouveautés',
            'required' => false,
        ])
        ->add('available', CheckboxType::class, [
            'label' => 'Disponible',
            'required' => false,
        ])
        ->add('theme',  EntityType::class, [
            'class' => Theme::class,
            'label' => 'Thèmes ',
            'multiple' => true,
            'expanded' => true,
            'required' => false
        ])
        ;
}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'crsf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}