<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\User;
use App\Entity\Emprunteur;
use App\Form\EmprunteurProfileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_emprunt')
            ->add('date_retour')
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('emprunteur', EntityType::class, [
                'class' => Emprunteur::class,
                'choice_label' => function(Emprunteur $emprunteur) {
                    return "{$emprunteur->getNom()} {$emprunteur->getPrenom()}";
                },
                'multiple' => false,
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
