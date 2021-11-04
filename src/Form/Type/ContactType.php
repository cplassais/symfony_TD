<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


//use Symfony\Component\Form\CamelCaseFieldType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('Nom', TextType::class)
        ->add('Prenom', TextType::class)
        ->add('Email', EmailType::class)
        ->add('Message', TextareaType::class,['attr' => ['rows' => 6 ]])
        ->add('Civilite',ChoiceType::class,['choices' => ['Homme' => 'Homme','Femme' => 'Femme',],'expanded' => true])
        ->add('save', SubmitType::class)
        ;
    }
}