<?php

namespace App\Form;

use App\Entity\Inscription;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;

class InscripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
 

    {
        $builder
            ->add('nom', TextType::class, [
                'mapped' => false, 
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Étudiant' => 'etudiant',
                    'Professeur' => 'professeur',
                ],
                'mapped' => false,
            ])
            ->add('niveau', TextType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('matiere', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'groups' => ['professor_required'],
                        'message' => 'La matière est requise pour les professeurs.',
                    ]),
                ],
            ])
            ->add('dateInscription', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('Status', ChoiceType::class, [
                'choices' => [
                    'Actif' => 'actif',
                    'Inactif' => 'inactif',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
