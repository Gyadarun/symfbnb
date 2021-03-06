<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegitrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                 TextType::class, 
                 $this->getConfiguration("Prénom", "Votre prénom")
                 )
            ->add(
                'lastName',
                 TextType::class, 
                 $this->getConfiguration("Nom", "Votre nom de famille")
                 )
            ->add(
                 'email',
                 EmailType::class,
                 $this->getConfiguration("Email", "Votre adresse mail")
                 )
            ->add(
                'picture',
                 UrlType::class,
                 $this->getConfiguration("Photo de profil", "URL de votre photo")
                )
            ->add(
                'hash',
                PasswordType::class,
                $this->getConfiguration("Password", "Votre password")
                )
            ->add(
                'passwordConfirm',
                PasswordType::class,
                $this->getConfiguration("Confirmation du password", "Veuillez confirmer votre password")
                )
            ->add(
                'introduction',
                TextType::class,
                $this->getConfiguration("Introduction", "Une brève introduction de vous même")
                )
            ->add(
                'description',
                TextareaType::class,
                $this->getConfiguration("Description", "C'est le moment de vous présenter en détail")
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
