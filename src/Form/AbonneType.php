<?php

namespace App\Form;

use App\Entity\Abonne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;



class AbonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
// Récupérer la variable abonné passé en paramètre pour construire le formulaire
$abonne = $options["data"]; // $abonne est un objet de la classe App\Entity\Abonne

        $builder
            ->add('pseudo')
            ->add('roles', ChoiceType::class, [
                    "choices" => [
                        "Directeur" => "ROLE_ADMIN",
                        "Bibliothécaire" => "ROLE_BIBLIO", 
                        "Lecteur" => "ROLE_LECTEUR"
                    ],
                    "multiple" => true,   // doit être true, parce que 'roles' est un array et donc peut avoir plusieurs valeurs
                    "expanded" => true  //pour afficher sous forme de cases à cocher
                    

            ])
            ->add('password', TextType::class, [
                "mapped" => false,
                "constraints" => [
                    new Regex ([
                        "pattern" => "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{6,10})$/",
                        "message" => "Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre, 1 caractères spécial parmi -+!*$@%_ et doit faire entre 6 et 10 caractères"
                    ])
                    ],
                    "help" => "Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre, 1 caractères spécial parmi -+!*$@%_ et doit faire entre 6 et 10 caractères",
                    "required" => $abonne->getId() ? false : true
            ])
            ->add('prenom')
            ->add('nom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonne::class,
        ]);
    }
}
