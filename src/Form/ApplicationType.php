<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
   /**
     * DRY for Ad formbuilder
     *
     * @param [string] $label
     * @param [string] $placeholder
     * @param [array] $options
     * @return void
     */
    protected function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge([ 
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
                ]
            ], $options);
    }
}