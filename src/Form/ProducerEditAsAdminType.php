<?php

namespace App\Form;

use App\Entity\Producer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProducerEditAsAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('brandName', TextType::class, [
            'label' => 'Nom',
            'required' => true
        ])
        ->add('contactEmail', EmailType::class, [
            'label' => 'Adresse email de contact',
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
        ->add('description', TextareaType::class, [
            'label' => 'Description du producteur',
            'required' => true
        ])
        ->add('phone', TelType::class, [
            'label' => 'Téléphone',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^0[0-9]{9}$/',
                    'message' => 'Le numéro de téléphone doit commencer par un 0 et contenir 10 chiffres.',
                ])
            ]
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
        ->add('address', AddressType::class, [
            ])
        ->add('submit', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => [
                'class' => 'btn btn-color mt-4'
            ]
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
            'data_class' => Producer::class,
        ]);
    }
}
