<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Formulaire pour ajouter un produit.
 */
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
        ->add('categorie', EntityType::class, [
            'class' => Categorie::class,
        ]);
    }

    /**
     * Configure les options du formulaire.
     *
     * @param OptionsResolver $resolver Le résolveur d'options.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}