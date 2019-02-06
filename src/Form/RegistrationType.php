<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                $this->getConfig("Prénom", "Veuillez saisir votre prénom")
            )
            ->add(
                'lastName',
                TextType::class,
                $this->getConfig("Nom de famille", "Veuillez saisir votre nom de famille")
            )
            ->add(
                'email',
                EmailType::class,
                $this->getConfig("Email", "Veuillez saisir votre adresse email")
            )
            ->add(
                'hash',
                PasswordType::class,
                $this->getConfig("Mot de passe", "Veuillez saisir un mot de passe")
            )
            ->add(
                'confirmPassword',
                PasswordType::class,
                $this->getConfig("Confirmation de mot de passe", "Veuillez saisir un mot de passe")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
