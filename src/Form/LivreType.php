<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('annee_edition')
            ->add('nombre_pages')
            ->add('code_isbn')
            ->add('genres', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => function(Genre $genre){
                    return "{$genre->getNom()} (id {$genre->getId()})";
                },
                'multiple' => true, 
                'expanded' => true
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => function(Auteur $auteur){
                    return "{$auteur->getNom()} (id {$auteur->getId()})";
                },
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
