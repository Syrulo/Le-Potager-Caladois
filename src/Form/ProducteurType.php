<?php

namespace App\Form;

use App\Entity\Producteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProducteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [ 
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '180',
                ],
                'label' => 'Adresse email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180]),
                ]
            ])
            ->add('tel', TelType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '10',
                    'maxlenght' => '10',
                    'pattern' => '[0][0-9]{9}',
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 10, 'max' => 10]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '255',
                ],
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [ 
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 255])                
                ],
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '80',
                ],
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [ 
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 80])                
                ],
            ])
            ->add('code_postal', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '5',
                    'maxlenght' => '5',
                    'pattern' => '[0-9]{5}',
                ],
                'label' => 'Code Postal',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5, 'max' => 5]),
                ],
            ])
            ->add('Enregistrer', SubmitType::class,[
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producteur::class,
        ]);
    }
}
