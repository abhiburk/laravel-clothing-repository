<?php

namespace App\Services\Discount;

use App\Enums\ClothingSizeEnums;
use App\Interfaces\DiscountRule;
use Illuminate\Support\Collection;

class LargeSizeDiscountRule implements DiscountRule
{
    /**
     * @var string The clothing size that qualifies for the discount.
     */
    private string $size;

    /**
     * @var float The discount percentage to be applied.
     */
    private float $discountPercentage;

    /**
     * LargeSizeDiscountRule constructor.
     * 
     * @param string $size The size of clothing items eligible for the discount. Default is LARGE.
     * @param float $discountPercentage The percentage discount to apply if the size matches.
     */
    public function __construct(string $size = ClothingSizeEnums::LARGE, float $discountPercentage = 3)
    {
        $this->size = $size;
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * Apply the large size discount rule to the given collection of clothing items.
     * 
     * @param Collection $clothings The collection of clothing items.
     * @param float $totalPrice The total price of the clothing items.
     * @return array An array containing the calculated discount amount and discount percentage.
     */
    public function apply(Collection $clothings, float $totalPrice): array
    {
        // Check if any clothing item matches the specified size.
        foreach ($clothings as $item) {

            if (isset($item->size) && $item->size === $this->size) {
                $discountAmount = $totalPrice * ($this->discountPercentage / 100);
                return [$discountAmount, $this->discountPercentage];
            }
        }

        // Return zero discount if no item matches the specified size.
        return [0, 0];
    }
}
