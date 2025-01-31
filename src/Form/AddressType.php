<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'Numéro',
                'required' => false
            ])
            ->add('street', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '255',
                ],
                'constraints' => [
                ]
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code Postal',
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[0-9]{5}$/',
                        'message' => 'Le code postal doit contenir exactement 5 chiffres.',
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville:',
                'required' => false,
                'attr' => [
                    'data-action' => 'address-input',
                ]
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
