<?php

namespace App\Form;

use App\Entity\Theme;
use App\Entity\Format;
use App\Data\SearchData;
use Doctrine\ORM\EntityRepository;
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
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC');
            },
            'label' => 'Thèmes ',
            'multiple' => true,
            'expanded' => true,
            'required' => false
        ])
        ->add('format',  EntityType::class, [
            'class' => Format::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('f')
                    ->orderBy('f.name', 'ASC');
            },
            'label' => 'Format ',
            'attr' => [
                'class' => 'input'
            ],
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