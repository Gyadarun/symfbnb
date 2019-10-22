<?php

namespace App\Form;

use App\Entity\Ad;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
    /**
     * DRY for Ad formbuilder
     *
     * @param [type] $label
     * @param [type] $placeholder
     * @return void
     */
    private function getConfiguration($label, $placeholder)
    {
        return [ 
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration("Titre", "Tappez un titre pour votre annonce"))
            ->add('slug', TextType::class, $this->getConfiguration("Adresse web", "Tappez l'adresse"))
            ->add('coverImage', UrlType::class, $this->getConfiguration("URL de l'image", "Donnez l'adresse de l'image"))
            ->add('introduction', TextType::class, $this->getConfiguration("Introduction", "Donnez une description globale de l'annonce"))
            ->add('content', TextareaType::class, $this->getConfiguration("Description détaillée", "Tappez une description qui donne envie de venir chez vous !" ))
            ->add('rooms', IntegerType::class, $this->getConfiguration("Nombre de chambres", "Le nombre de chambres disponibles"))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix par nuit", "Indiquez le prix que vous voulez par nuit"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
