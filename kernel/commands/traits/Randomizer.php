<?php

namespace Kernel\Commands\Traits;

trait Randomizer
{
    /**
     * Number of random item
     * 
     * @var int
     */ 
    protected $numberOfItem;

    /**
     * All numbers of items
     * which was shown
     * 
     * @var array
     */ 
    protected $numberOfItems = [];

    /**
     * Get random item from array and if exists
     * repeat this operation
     * 
     * @param array $items
     * 
     * @return array
     */ 
    protected function getRandomItem(array $items)
    {
        $this->numberOfItem = rand(0, count($items));

        if ($this->itemWasShown($this->numberOfItem)) {
            return $items[$this->numberOfItem];
        }

        $this->numberOfItem = rand(0, count($items));
        return $items[$this->numberOfItem];
    }

    /**
     * Check if the number of shown items
     * exists in array
     * 
     * @param integer $number
     * 
     * @return integer|bool 
     */ 
    protected function itemWasShown($number)
    {
        if (in_array($number, $this->numberOfItems)) {
            return false;
        }

        return $number;
    }
}