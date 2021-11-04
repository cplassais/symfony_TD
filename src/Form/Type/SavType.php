<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\OptionsResolver;


class SavType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Commande', NumberType::class)
            ->add('Email', EmailType::class)
            ->add('Motif',ChoiceType::class, [
                'choices' => [
                    'produit défectueux' => null,
                    'produit incomplet' => null,
                    'pièce cassée' => null,
                    'produit périmée' => null
                ],
            ])
            ->add('Message', TextareaType::class,['attr' => ['rows' => 6 ]])

            ->add('save', SubmitType::class)
        ;
    }
}