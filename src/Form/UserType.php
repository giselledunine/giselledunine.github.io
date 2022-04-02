<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
