<?php

namespace App\Form;



use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Abonne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
/* use Symfony\Component\Validator\Constraints\DateTime; */
use DateTime;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_emprunt', DateType::class, [
                "widget" => "single_text",
                "label" => "Emprunté le"
                // "empty_data" => new DateTime("now")  //ne change rien pour un DataType
                // "data" => new DateTime("now")  //à ne pas utiliser si le EmpruntType est utilisé pour les modifications
            ])
            ->add('date_retour', DateType::class, [
                "widget" => "single_text",
                "label" => "Rendu le",
                "required" => false
            ])
            ->add('livre', Entitytype::class, [
                "class" => Livre::class,
                "choice_label" => "titre",
                "placeholder" => "Choisissez un livre..."
            ])
            ->add('abonne', Entitytype::class, [
                "class" => Abonne::class,
                "choice_label" => "pseudo",
                "placeholder" => "Choisissez un abonné..."
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
