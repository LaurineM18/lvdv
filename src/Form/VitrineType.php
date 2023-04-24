<?php

namespace App\Form;

use App\Entity\Theme;
use App\Entity\Format;
use App\Entity\Vitrine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class VitrineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                'label' => 'Nom de la vitrine ',
                'attr' => [
                    'class' => 'input'
                ]
            ])

            ->add('New', CheckboxType::class, [
                'label' => 'Nouveauté ? ',
                'attr' => [
                    'class' => 'checkbox'
                ],
                'required' => false
            ])
            ->add('Price', MoneyType::class, [
                'label' => 'Prix ',
                'attr' => [
                    'class' => 'input'
                ]
            ])
            ->add('Available', CheckboxType::class, [
                'label' => 'Disponible ? ',
                'attr' => [
                    'class' => 'checkbox'
                ],
                'required' => false
            ])
            ->add('Description',  TextareaType::class, [
                'label' => 'Description ',
                'attr' => [
                    'class' => 'input'
                ],
                'required' => false
            ])
            ->add('Format',  EntityType::class, [
                'class' => Format::class,
                'label' => 'Format ',
                'attr' => [
                    'class' => 'input'
                ],
                'multiple' => false,
                'expanded' => false,
                'required' => true
            ])
            ->add('Theme',  EntityType::class, [
                'class' => Theme::class,
                'label' => 'Thème ',
                'attr' => [
                    'class' => 'input'
                ],
                'multiple' => false,
                'expanded' => false,
                'required' => true
            ])
            ->add('images',  FileType::class, [
                'label' => 'Insérer des images ',
                'attr' => [
                    'class' => 'input'
                ],
                'mapped' => false,
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vitrine::class,
        ]);
    }
}
