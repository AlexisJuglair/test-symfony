<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => ['placeholder' => 'Entrez une description courte...',
                    'class' => 'form-control',
                    'rows' => 3,
                    'style' => 'resize: none;'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('longDescription', TextareaType::class, [
                'label' => 'Description longue',
                'attr' => ['placeholder' => 'Entrez une description longue...',
                    'class' => 'form-control',
                    'rows' => 10,
                    'style' => 'resize: none;'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix en euros',
                'attr' => ['placeholder' => 'Prix...',
                'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'currency' => ''
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Quantité',
                'attr' => ['placeholder' => 'Quantité...',
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'html5' => true
            ])
            ->add('visible', CheckboxType::class, [
                'label' => 'Visible',
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label me-2'],
                'required' => false
            ])
            ->add('mainPicture', TextType::class, [
                'label' => 'URL de l\'image',
                'attr' => ['placeholder' => 'URL de l\'image...',
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'placeholder' => '--Choisissez une catégorie--',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('qb')
                        ->orderBy('qb.name', 'ASC');
                },
                'choice_label' => function($category) {
                    return strtoupper($category);
                },
                
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
