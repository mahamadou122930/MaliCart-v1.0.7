<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'required'=> false,
            'label'=> false,
            'empty_data' => '',
            'attr'=> [
                'placeholder'=> 'John Doe'
            ]
        ])
        ->add('email', EmailType::class, [
            'empty_data'=> '',
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'johndoe@email.com'
            ]
        ])
        ->add('message', TextareaType::class, [
            'required'=> true,
            'label'=> false,
            'empty_data'=> '',
            'attr'=> [
                'placeholder'=> 'Please describe in detail your request'
            ]
        ])
        ->add('phone', TelType::class, [
            'required'=> true,
            'label'=> false,
            'empty_data'=> '',
            'attr'=> [
                'placeholder'=> '+1 (212) 00 000 000'
            ]
        ])
        ->add('subject', TelType::class, [
            'required'=> true,
            'label'=> false,
            'empty_data'=> '',
            'attr'=> [
                'placeholder'=> 'Provide short title of your request'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
