<?php

namespace App\Services\Discount;

use Illuminate\Support\Collection;

class DiscountService
{
    /**
     * @var array
     */
    private array $rules;

    /**
     * DiscountService constructor.
     * 
     * @param array $rules Discount rules to be applied.
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * Calculate the discount for a collection of clothing items.
     * 
     * @param Collection $clothings A collection of clothing items.
     * @return array The calculated discount details, including original cost, discounted cost, and applied discount.
     */
    public function calculate(Collection $clothings): array
    {
        $totalCost = $clothings->sum('price');
        $totalDiscount = 0;
        $totalDiscountPercent = 0;

        // Apply each discount rule to calculate the total discount.
        foreach ($this->rules as $rule) {
            [$discountedAmount, $discountedPercent] = $rule->apply($clothings, $totalCost);
            $totalDiscount += $discountedAmount;
            $totalDiscountPercent += $discountedPercent;
        }

        $finalCost = $totalCost - $totalDiscount;

        // Return the discount calculation details.
        return [
            'original_cost' => $totalCost,
            'discounted_cost' => $finalCost,
            'applied_discount' => "{$totalDiscountPercent}%",
        ];
    }
}
