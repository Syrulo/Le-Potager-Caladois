<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => 'Adresse email',
            'attr' => [
                'class' => 'form-control',
                'minlength' => '2',
                'maxlength' => '180',
            ],
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Length(['min' => 2, 'max' => 180]),
            ]
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les mots de passe ne correspondent pas.',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmez le mot de passe'],
            'constraints' => [
                new Assert\NotBlank()
            ]
            ]);
        // ->add('submit', SubmitType::class, [
        //     'attr' => [
        //         'class' => 'btn btn-primary mt-4'
        //     ]
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
