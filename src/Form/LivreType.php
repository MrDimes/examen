<?php

namespace App\Form;

use App\Entity\Livre;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                "constraints" => [
                    new NotBlank([ "message" => "Le titre ne peut être vide" ])
                ]
            ])
            ->add('auteur', TextType::class, [
                "constraints" => [
                    new NotBlank([ "message" => "Merci de renseigner un auteur" ])
                ]
            ])
            ->add('avis', TextType::class, [
                'required'=> false,
            ])
            ->add('note', IntegerType::class, [
                'required'=> false,
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
