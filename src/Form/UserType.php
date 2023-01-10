<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label'=>'Login'
            ])
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'Administrateur'=>'ROLE_ADMIN'
            ],
            'expanded' => true,
            'multiple' => true,
            'label' => 'Rôles'

        ])
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'label'=>'Mot de passe',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer un mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit comporter au moins {{limit}} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
            ->add('nom', TextType::class, [
                'label'=>'Nom'
            ])
            ->add('prenom',TextType::class, [
                'label'=>'Prenom'
            ])
            ->add('email', EmailType::class, [
                'label'=>'Email'
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
