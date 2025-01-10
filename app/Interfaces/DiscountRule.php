<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

/**
 * Interface DiscountRule
 * 
 * Defines the contract for implementing discount rules that can be applied
 * to a collection of clothing items and their total price.
 */
interface DiscountRule
{
    /**
     * Applies the discount rule to the given clothing items and total price.
     * 
     * @param Collection $clothings A collection of clothing items.
     * @param float $totalPrice The total price of the clothing items.
     * @return array An array containing two elements:
     *               - float: The calculated discount amount.
     *               - float: The percentage of discount applied.
     */
    public function apply(Collection $clothings, float $totalPrice): array;
}
