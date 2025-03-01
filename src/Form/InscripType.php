<?php

namespace App\Form;

use App\Entity\Inscription;


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
                'label' => 'Nom complet',
                'attr' => [
                    'class' => 'form-input', 
                    'placeholder' => 'Entrez votre nom complet',
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', 
                ],
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
                'label' => 'Adresse email',
                'attr' => [
                    'class' => 'form-input', 
                    'placeholder' => 'Entrez votre adresse email',
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', 
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-input', 
                    'placeholder' => 'Choisissez un mot de passe',
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', 
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Étudiant' => 'etudiant',
                    'Professeur' => 'professeur',
                ],
                'mapped' => false,
                'label' => 'Type d\'utilisateur',
                'placeholder' => 'Sélectionnez votre rôle',
                'attr' => [
                    'class' => 'form-input', 
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', 
                ],
            ])
            ->add('niveau', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Niveau d\'étude',
                'attr' => [
                    'class' => 'form-input', 
                    'placeholder' => 'Entrez votre niveau ',
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', 
                ],
            ])
            ->add('matiere', TextType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Matière',
                'attr' => [
                    'class' => 'form-input', 
                    'placeholder' => 'Entrez la matière',
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', // Style inline
                ],
                'constraints' => [
                    new NotBlank([
                        'groups' => ['professor_required'],
                        'message' => 'La matière est requise pour les professeurs.',
                    ]),
                ],
            ])
            ->add('dateInscription', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'inscription',
                'attr' => [
                    'class' => 'form-input', 
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', // Style inline
                ],
            ])
            ->add('Status', ChoiceType::class, [
                'choices' => [
                    'Actif' => 'actif',
                    'Inactif' => 'inactif',
                ],
                'label' => 'Statut',
                'placeholder' => 'Sélectionnez votre statut',
                'attr' => [
                    'class' => 'form-input', 
                    'style' => 'padding: 10px; border: 1px solid #ccc; border-radius: 5px; width: 100%;', 
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'form-button', 
                    'style' => 'background-color:rgba(0, 255, 34, 0.99); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;', 
                ],
            ]);
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
            'validation_groups' => ['Default', 'professor_required'], 
        ]);
    }

}
