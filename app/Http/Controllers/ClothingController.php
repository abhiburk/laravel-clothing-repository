<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClothingRequest;
use App\Http\Requests\UpdateClothingRequest;
use App\Http\Resources\ClothingResource;
use App\Services\Clothing\ClothingService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClothingController extends ApiController
{
    /**
     * @var ClothingService
     */
    private ClothingService $clothingService;

    /**
     * ClothingController constructor.
     * 
     * @param ClothingService $clothingService
     */
    public function __construct(ClothingService $clothingService)
    {
        $this->clothingService = $clothingService;
    }

    /**
     * Fetch all clothing items.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $clothes = $this->clothingService->getAllClothes();

        // Return a collection of clothing resources with a success message.
        return $this->success(ClothingResource::collection($clothes), trans('clothing.ok'));
    }

    /**
     * Store a new clothing item.
     * 
     * @param StoreClothingRequest $request
     * @return JsonResponse
     */
    public function store(StoreClothingRequest $request): JsonResponse
    {
        $clothing = $this->clothingService->addClothing($request->all());

        // Return the newly created clothing resource with a success message.
        return $this->success(new ClothingResource($clothing), trans('clothing.created'));
    }

    /**
     * Update an existing clothing item.
     * 
     * @param UpdateClothingRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateClothingRequest $request, int $id): JsonResponse
    {
        $clothing = $this->clothingService->findById($id);
        if (!$clothing) {
            return $this->error(trans('clothing.not-found', ['id' => $id]), Response::HTTP_NOT_FOUND);
        }

        $clothing = $this->clothingService->updateClothing($id, $request->all());

        // Return the updated clothing resource with a success message.
        return $this->success(new ClothingResource($clothing), trans('clothing.updated'));
    }

    /**
     * Show details of a specific clothing item.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $clothing = $this->clothingService->findById($id);

        if (!$clothing) {
            return $this->error(trans('clothing.not-found'), Response::HTTP_NOT_FOUND);
        }

        // Return the clothing resource with a success message.
        return $this->success(new ClothingResource($clothing), trans('clothing.ok'));
    }
}
