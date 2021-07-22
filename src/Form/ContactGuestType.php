<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactGuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("name", TextType::class, [
                'mapped'    =>  false,
                'attr' =>
                [
                    'class' => 'form-control',
                    'placeholder' => 'Votre nom',
                    'required' => true
                ]
            ])
            ->add('lastname', TextType::class, [
                'mapped'    =>  false,
                'attr' =>
                [
                    'class' => 'form-control',
                    'placeholder' => 'Votre prénom',
                    'required' => true
                ]
            ])
            ->add('email', EmailType::class, [
                'mapped'    =>  false,
                'attr' =>
                [
                    'class' => 'form-control',
                    'placeholder' => 'Votre Email',
                    'required' => true
                ]
            ])
            ->add('sujet', TextType::class, [
                'mapped'    => false,
                'attr' =>
                [
                    'class' => 'form-control',
                    'placeholder' => 'sujet de votre demande',
                    'required' => true
                ]
            ])
            ->add('content', TextareaType::class, [
                'mapped'    =>  false,
                'attr' =>
                [
                    'class' => 'form-control',
                    'placeholder' => 'En quoi pouvons nous vous aider ?',
                    'required' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => ContactGuestType::class,

        ]);
    }
}
