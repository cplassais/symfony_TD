<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Brand;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('new', CheckboxType::class,['required'=>false])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label'=>'name',
                'required' => true
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'choice_label' => 'name',
                'expanded' => true,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
