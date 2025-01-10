<?php

namespace Tests\Unit;

use App\Enums\ClothingSizeEnums;
use App\Services\Clothing\ClothingService;
use App\Services\Discount\DiscountService;
use App\Services\Discount\ItemCountDiscountRule;
use App\Services\Discount\LargeSizeDiscountRule;
use App\Services\Discount\TotalCostDiscountRule;
use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    public function test_discount_calculation()
    {
        // Mock clothing items data
        $clothings = collect([
            (object) ['id' => 1, 'name' => 'Shirt', 'size' => ClothingSizeEnums::MEDIUM, 'price' => 400],
            (object) ['id' => 2, 'name' => 'Pants', 'size' => ClothingSizeEnums::LARGE, 'price' => 400],
            (object) ['id' => 3, 'name' => 'Jacket', 'size' => ClothingSizeEnums::LARGE, 'price' => 200],
        ]);

        // Initialize the DiscountService with rules
        $service = new DiscountService([
            new TotalCostDiscountRule(100, 10), // 10% if total > 100
            new ItemCountDiscountRule(2, 5),   // 5% if items > 2
            new LargeSizeDiscountRule(ClothingSizeEnums::LARGE, 3), // 3% for size LARGE
        ]);

        // Calculate the discounts
        $result = $service->calculate($clothings);

        // Assert the results
        $this->assertEquals(1000, $result['original_cost'], "Orignal Cost"); // Total price = 400 + 400 + 200 = 1000
        $this->assertEquals(820, $result['discounted_cost'], "Discounted Cost"); // Discounts applied: 820
        $this->assertEquals('18%', $result['applied_discount'], "Total Discount in %"); // Total discount = 18%
    }

    public function test_discount_with_no_eligible_items()
    {
        // Mock clothing items data
        $clothings = collect([
            (object) ['id' => 1, 'name' => 'Shirt', 'size' => ClothingSizeEnums::SMALL, 'price' => 50],
            (object) ['id' => 2, 'name' => 'Pants', 'size' => ClothingSizeEnums::SMALL, 'price' => 40],
        ]);

        // Initialize the DiscountService with rules
        $service = new DiscountService([
            new TotalCostDiscountRule(100, 10), // 10% if total > 100
            new ItemCountDiscountRule(2, 5),   // 5% if items > 2
            new LargeSizeDiscountRule(ClothingSizeEnums::LARGE, 3), // 3% for size LARGE
        ]);

        // Calculate the discounts
        $result = $service->calculate($clothings);

        // Assert the results
        $this->assertEquals(90, $result['original_cost'], "Original Cost"); // Total price = 50 + 40 = 90
        $this->assertEquals(90, $result['discounted_cost'], "Discounted Cost"); // No discounts applied
        $this->assertEquals('0%', $result['applied_discount'], "Total Discount in %"); // No discount applied
    }

    public function test_discount_with_one_item_eligible()
    {
        // Mock clothing items data
        $clothings = collect([
            (object) ['id' => 1, 'name' => 'Shirt', 'size' => ClothingSizeEnums::MEDIUM, 'price' => 120],
        ]);

        // Initialize the DiscountService with rules
        $service = new DiscountService([
            new TotalCostDiscountRule(100, 10), // 10% if total > 100
            new ItemCountDiscountRule(2, 5),   // 5% if items > 2
            new LargeSizeDiscountRule(ClothingSizeEnums::LARGE, 3), // 3% for size LARGE
        ]);

        // Calculate the discounts
        $result = $service->calculate($clothings);

        // Assert the results
        $this->assertEquals(120, $result['original_cost'], "Original Cost"); // Total price = 120
        $this->assertEquals(108, $result['discounted_cost'], "Discounted Cost"); // Discount = 10%
        $this->assertEquals('10%', $result['applied_discount'], "Total Discount in %"); // 10% discount applied
    }

    public function test_discount_with_no_clothing_items()
    {
        // Empty collection
        $clothings = collect([]);

        // Initialize the DiscountService with rules
        $service = new DiscountService([
            new TotalCostDiscountRule(100, 10), // 10% if total > 100
            new ItemCountDiscountRule(2, 5),    // 5% if items > 2
            new LargeSizeDiscountRule(ClothingSizeEnums::LARGE, 3), // 3% for size LARGE
        ]);

        // Calculate the discounts
        $result = $service->calculate($clothings);

        // Assert the results
        $this->assertEquals(0, $result['original_cost'], "Original Cost"); // No items, no cost
        $this->assertEquals(0, $result['discounted_cost'], "Discounted Cost"); // No items, no discount
        $this->assertEquals('0%', $result['applied_discount'], "Total Discount in %"); // No discount applied
    }
}
