<?php

namespace App\Form;

use App\Entity\Emploi;
use App\Entity\Salles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour')
            ->add('hr_deb', null, [
                'widget' => 'single_text',
            ])
            ->add('hr_fin', null, [
                'widget' => 'single_text',
            ])
            ->add('salle', EntityType::class, [
                'class' => Salles::class,
                'choice_label' => function (Salles $salle) {
                    return $salle->getNom();
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emploi::class,
        ]);
    }
}
