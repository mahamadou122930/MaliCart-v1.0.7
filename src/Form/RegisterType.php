<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'empty_data' => '',
            'label'=> 'Firstname',
            'invalid_message'=> 'Please enter your first name!'
        ])
        ->add('lastname', TextType::class, [
            'empty_data' => '',
            'label'=> 'Lastname',
            'invalid_message'=> 'Please enter your last name!'
        ])
        ->add('email', EmailType::class, [
            'empty_data' => '',
            'label'=> 'E-mail Address',
            'invalid_message'=> 'Please enter valid email address!'
        ])
        ->add('phoneNumber', TelType::class, [
            'empty_data' => '',
            'label'=> 'Phone Number',
            'invalid_message'=> 'Please enter your phone number!'
        ])
        ->add('password', RepeatedType::class, [
            'empty_data' => '',
            'type' => PasswordType::class,
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => [
                'label' => 'Password','empty_data' => '',
                'mapped'=> false,
                // 'invalid_message'=>'Le mot de passe et la confirmation doivent être identique',
                'required'=> true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 63,
                    ]),
                    ]
   

            ],
            'second_options' => [
                'label' => 'Repeat Password','empty_data' => '',
                'mapped'=> false,
                // 'invalid_message'=>'Le mot de passe et la confirmation doivent être identique',
                'required'=> true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 63,
                    ]),
                    ]
            ],
        ])
    ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
