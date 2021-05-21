<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                "label" => "Titre du livre",
                "constraints" => [
                    new length([
                        "min" => 4,
                        "minMessage" => "Le titre doit avoir au moins 4 caractères",
                        "max" => 50,
                        "maxMessage" => "Le titre doit pas dépasser 50 caractères"
                    ]),

                    new NotBlank([
                        "message" => "Le titre ne peut être vide"

                    ])

                ]
            ])
            ->add('auteur', TextType::class)

            ->add('categorie', EntityType::class, [
                "class" => Categorie::class,
                "choice_label" => "titre", // la propriété de la classe Categorie qui va être affichée dans le select
                "required" => false
            ])

            ->add("enregistrer", SubmitType::class, [
                "attr" => [
                    "class" => "btn btn-secondary"
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
