<?php

namespace App\Services\Discount;

use App\Interfaces\DiscountRule;
use Illuminate\Support\Collection;

class ItemCountDiscountRule implements DiscountRule
{
    /**
     * @var int The threshold of items required to apply the discount.
     */
    private int $threshold;

    /**
     * @var float The discount percentage to be applied.
     */
    private float $discountPercentage;

    /**
     * ItemCountDiscountRule constructor.
     * 
     * @param int $threshold The minimum number of items to qualify for the discount.
     * @param float $discountPercentage The percentage discount to apply if the threshold is met.
     */
    public function __construct(int $threshold = 2, float $discountPercentage = 5)
    {
        $this->threshold = $threshold;
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * Apply the item count discount rule to the given collection of clothing items.
     * 
     * @param Collection $clothings The collection of clothing items.
     * @param float $totalPrice The total price of the clothing items.
     * @return array An array containing the calculated discount amount and discount percentage.
     */
    public function apply(Collection $clothings, float $totalPrice): array
    {
        // Check if the number of items exceeds the threshold to apply the discount.
        if ($clothings->count() > $this->threshold) {
            $discountAmount = $totalPrice * ($this->discountPercentage / 100);
            return [$discountAmount, $this->discountPercentage];
        }

        // Return zero discount if the threshold is not met.
        return [0, 0];
    }
}
