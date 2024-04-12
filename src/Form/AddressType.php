<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Name your address'
            ]
        ])
        ->add('firstname', TextType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Enter Your Firstname'
            ]
        ])
        ->add('lastname', TextType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Enter Your Lastname'
            ]
        ])
        ->add('company', TextType::class, [
            'label'=> false,
            'required'=> false,
            'attr'=> [
                'placeholder'=> '(Facultatif) Street 650, Kalaban-Coura ACI'
            ]
        ])
        ->add('address', TextType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Street 650, Kalaban-Coura ACI'
            ]
        ])
        ->add('postal', TextType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> '(Facultatif)'
            ]
        ])
        ->add('city', TextType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Selectionnner Vôtre Ville'
            ]
        ])
        ->add('country', CountryType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Selectionner Votre Pays'
            ]
        ])
        ->add('phone', TelType::class, [
            'label'=> false,
            'attr'=> [
                'placeholder'=> 'Your Phone Number'
            ]
        ])
        ->add('isPrimary', CheckboxType::class, [
            'label'=> 'Make this address primary',
            'required'=> false
        ])
        ->add('submit', SubmitType::class,[
            'label'=> 'Save my address'
        ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
