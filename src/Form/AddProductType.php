<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom du produit',
            'required' => true
        ])
        ->add('prix', MoneyType::class, [
            'label' => 'Prix du produit',
            'required' => true
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description du produit',
            'required' => true,
            'constraints' => [
                new Assert\Length([
                    'max' => 300,
                    'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('imageFile', VichImageType::class, [
            'required' => false,
            'download_uri' => false,
            'image_uri' => true,
            'asset_helper' => true,
            'label' => 'Image',
            'constraints' => [
                new Assert\File([
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ],
                    'mimeTypesMessage' => 'Veuillez télécharger une image valide (formats autorisés : .jpg, .png, .webp).',
                ]),
            ],               
        ])
        ->add('categorie', EntityType::class, [
            'class' => Categorie::class,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}