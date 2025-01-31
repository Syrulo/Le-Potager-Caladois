<?php

namespace App\Form\Admin;

use App\Entity\Visitor;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VisitorEditAsAdminType extends AbstractType
{
    public function __construct(
        private Security $security
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $utilisateur = $event->getData();
            $form = $event->getForm();

            if ($utilisateur == $this->security->getUser()) {
                // dd($form);
                $form
                    ->add('firstname', TextType::class, [
                        'label' => 'Prénom',
                        'required' => false,
                        'attr' => [
                            'class' => 'form-control',
                            'minlength' => '2',
                            'maxlength' => '50',
                        ],
                        'constraints' => [
                            new Assert\Length(['min' => 2, 'max' => 50])
                        ]
                    ])
                    ->add('lastname', TextType::class, [
                        'label' => 'Nom',
                        'required' => false,
                        'attr' => [
                            'class' => 'form-control',
                            'minlength' => '2',
                            'maxlength' => '50',
                        ],
                        'constraints' => [
                            new Assert\Length(['min' => 2, 'max' => 50])
                        ]
                    ])
                    ->add('phone', TelType::class, [
                        'label' => 'Téléphone',
                        'required' => false,
                        'constraints' => [
                            new Assert\Regex([
                                'pattern' => '/^0[0-9]{9}$/',
                                'message' => 'Le numéro de téléphone doit commencer par un 0 et contenir 10 chiffres.',
                            ])
                        ]
                    ])
                    ->add('email', EmailType::class, [
                        'label' => 'Identifiant',
                        'attr' => [
                            'class' => 'form-control',
                            'minlength' => '2',
                            'maxlength' => '180',
                        ],
                        'constraints' => [
                            new Assert\Email(),
                            new Assert\Length(['min' => 2, 'max' => 180]),
                        ]
                    ])
                ;
            }

            if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')) {
                $form->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Administrateur' => 'ROLE_ADMIN',
                        'Utilisateur' => 'ROLE_USER'
                    ],
                    'label' => 'Rôles:',
                    'required' => true,
                    'mapped' => false,
                    'expanded' => false,
                ])
                    ->add('submit', SubmitType::class, [
                        'attr' => [
                            'class' => 'btn'
                        ]
                    ]);
            }
        });
    }
    /**
     * Configure les options du formulaire.
     *
     * @param OptionsResolver $resolver Le résolveur d'options.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visitor::class,
        ]);
    }
}
