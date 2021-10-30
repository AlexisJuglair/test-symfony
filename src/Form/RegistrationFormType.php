<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Email...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
                'label' => "Conditions générales",
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label me-2'],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir au minimum {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe',
                'attr' => ['placeholder' => 'Mot de passe...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('fullName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Adresse...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'required' => false
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Code postal...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Ville...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'required' => false
            ])
            ->add('country', TextType::class, [
                'label' => 'Pays',
                'attr' => ['placeholder' => 'Pays...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'required' => false
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Téléphone...', 
                    'class' => 'form-control'],
                'label_attr' => ['class' => 'form-label'],
                'required' => false
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
