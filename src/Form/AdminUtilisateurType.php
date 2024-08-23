<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Form\UtilisateurDetailsType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdminUtilisateurType extends AbstractType
{
    public function __construct(
        private Security $security
    ){
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $utilisateur = $event->getData();
            $form = $event->getForm();

            if ($utilisateur == $this->security->getUser()) {
                $form->add('utilisateurDetails', UtilisateurDetailsType::class);
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
            'data_class' => Utilisateur::class,
        ]);
    }
}