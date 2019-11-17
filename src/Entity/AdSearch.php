<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class AdSearch
{
    /**
     * @var int|null
     * @Assert\Type("integer", message="Cette valeur n'est pas valide !")
     * @Assert\LessThan(propertyPath="maxPrice", message="Cette valeur doit être inférieur au prix maximum !")
     */
    private $minPrice;

    /**
     * @var int|null
     * @Assert\Type("integer", message="Cette valeur n'est pas valide !")
     * @Assert\GreaterThan(propertyPath="minPrice", message="Cette valeur doit être supérieur au prix minimum!")
     */
    private $maxPrice;

    /**
     * Get the value of minPrice
     *
     * @return  int|null
     */ 
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Set the value of minPrice
     *
     * @param  int|null  $minPrice
     *
     * @return  self
     */ 
    public function setMinPrice($minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * Get the value of maxPrice
     *
     * @return  int|null
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set the value of maxPrice
     *
     * @param  int|null  $maxPrice
     *
     * @return  self
     */ 
    public function setMaxPrice($maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }
}
