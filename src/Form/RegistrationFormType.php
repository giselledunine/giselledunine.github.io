<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\ChoiceList\ChoiceList;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Adresse mail',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            /*->add('imageFile', VichImageType::class)*/
            ->add('birthDate', DateType::class, [
                'label' => "Date d'anniversaire",
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse de domicile',
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
            ])
            ->add('alternanceJob', TextType::class, [
                'label' => 'Alternance',
            ])
            ->add('groupName', EntityType::class, [
                'class' => Group::class,
                'label' => 'Promotion',
                'choice_label' => 'name',
            ])
            ->add('imageFile', VichImageType::class)
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'En cochant vous accepté les Conditions Générales',
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devriez accepter les Conditions Générales',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
