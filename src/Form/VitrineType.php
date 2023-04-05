<?php

namespace App\Form;

use App\Entity\Vitrine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('Description',  TextType::class, [
                'label' => 'Description ',
                'attr' => [
                    'class' => 'input'
                ],
                'required' => false
            ])
            ->add('Image',  FileType::class, [
                'label' => 'Image ',
                'attr' => [
                    'class' => 'input'
                ],
                'required' => false,
                'data_class' => null
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
