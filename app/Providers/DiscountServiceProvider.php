<?php

namespace App\Providers;

use App\Services\Discount\DiscountService;
use App\Services\Discount\ItemCountDiscountRule;
use App\Services\Discount\LargeSizeDiscountRule;
use App\Services\Discount\TotalCostDiscountRule;
use Illuminate\Support\ServiceProvider;

class DiscountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DiscountService::class, function ($app) {
            // Fetch from configuration
            $discountConfig = config('discounts');

            // OR Fetch from database
            // $discountConfig = Some DB Query

            return new DiscountService([
                new TotalCostDiscountRule(
                    $discountConfig['total_cost']['threshold'],
                    $discountConfig['total_cost']['percentage']
                ),
                new ItemCountDiscountRule(
                    $discountConfig['item_count']['threshold'],
                    $discountConfig['item_count']['percentage']
                ),
                new LargeSizeDiscountRule(
                    $discountConfig['large_size']['size'],
                    $discountConfig['large_size']['percentage']
                ),
            ]);
        });
    }
}
