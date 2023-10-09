<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Emprunteur;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmprunteurProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('emprunteur', EmprunteurType::class, [
                // @fixme trouver le sélecteur de l'encadré pour supprimer la bordure

                // sélecteur du titre de l'encadré
                // 'label_attr' => [
                //     'class' => 'd-none',
                // ],
                // ou
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}