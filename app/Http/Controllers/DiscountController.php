<?php

namespace App\Http\Controllers;

use App\Services\Clothing\ClothingService;
use App\Services\Discount\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class DiscountController extends ApiController
{
    /**
     * @var DiscountService
     */
    private DiscountService $discountService;

    /**
     * @var ClothingService
     */
    private ClothingService $clothingService;

    /**
     * DiscountController constructor.
     * 
     * @param DiscountService $discountService
     * @param ClothingService $clothingService
     */
    public function __construct(DiscountService $discountService, ClothingService $clothingService)
    {
        $this->discountService = $discountService;
        $this->clothingService = $clothingService;
    }

    /**
     * Calculate discounts for the provided clothing items.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function calculate(Request $request): JsonResponse
    {
        // Get clothing items by their IDs from the request.
        $clothings = $this->calculateByIds($request);

        // Calculate discounts for the clothing items.
        $result = $this->discountService->calculate($clothings);

        // Return the calculated discounts.
        return $this->success($result);
    }

    /**
     * Retrieve clothing items by their IDs from the request.
     * 
     * @param Request $request
     * @return \Illuminate\Support\Collection|JsonResponse
     */
    private function calculateByIds(Request $request): Collection|JsonResponse
    {
        // Validate the request to ensure 'ids' is an array.
        $request->validate([
            'ids' => 'array|required',
        ]);

        // Retrieve clothing items matching the provided IDs.
        // Commenting out as same ID can be order multiple times to avoid we will loop through IDs down below
        // $clothings = collect($this->clothingService->getAllClothes())->whereIn('id', $request->ids);

        $clothings = collect();

        foreach ($request->ids as $id) {
            if ($clothing = $this->clothingService->findById($id))
                $clothings->push($clothing);
        }

        // If no clothing items are found, return a 404 error response.
        if ($clothings->isEmpty()) {
            return $this->error(trans('clothing.not-found'), Response::HTTP_NOT_FOUND);
        }

        return $clothings;
    }

    /**
     * Validate clothing items directly from the request and calculate discounts.
     * 
     * This method is a placeholder and not fully implemented and just for an alternative way.
     * 
     * @param Request $request
     * @return array|null
     */
    private function calculateByItems(Request $request): ?array
    {
        // Validate the 'clothes' array in the request.
        $items = $request->validate([
            'clothes' => 'required|array',
            'clothes.*.price' => 'required|numeric',
            'clothes.*.size' => 'required|string|in:Small,Medium,Large',
        ]);

        // Placeholder implementation.
        // Not a foolproof solution; refer to `calculateByIds` for a more robust approach.
        return $items;
    }
}
