<?php

namespace App\Services\Discount;

use App\Interfaces\DiscountRule;
use Illuminate\Support\Collection;

class TotalCostDiscountRule implements DiscountRule
{
    /**
     * @var float The cost threshold to qualify for the discount.
     */
    private float $threshold;

    /**
     * @var float The percentage discount to apply if the total price exceeds the threshold.
     */
    private float $discountPercentage;

    /**
     * TotalCostDiscountRule constructor.
     * 
     * @param float $threshold The minimum total cost to qualify for the discount. Default is 100.
     * @param float $discountPercentage The percentage discount to apply. Default is 10%.
     */
    public function __construct(float $threshold = 100, float $discountPercentage = 10)
    {
        $this->threshold = $threshold;
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * Apply the total cost discount rule to the given clothing items and total price.
     * 
     * @param Collection $clothings The collection of clothing items.
     * @param float $totalPrice The total price of the clothing items.
     * @return array An array containing the calculated discount amount and discount percentage.
     */
    public function apply(Collection $clothings, float $totalPrice): array
    {
        // Apply discount if the total price exceeds the threshold.
        if ($totalPrice > $this->threshold) {
            $discountAmount = $totalPrice * ($this->discountPercentage / 100);
            return [$discountAmount, $this->discountPercentage];
        }

        // Return zero discount if the total price does not meet the threshold.
        return [0, 0];
    }
}
