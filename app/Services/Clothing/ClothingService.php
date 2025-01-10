<?php

namespace App\Services\Clothing;

use CompareClub\Repository\Clothing\Clothing;
use CompareClub\Repository\Clothing\ClothingRepository;
use Illuminate\Support\Collection;

class ClothingService
{
    /**
     * @var ClothingRepository
     */
    private ClothingRepository $repository;

    /**
     * ClothingService constructor.
     * 
     * @param ClothingRepository $repository
     */
    public function __construct(ClothingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve all clothing items.
     * 
     * @return Collection
     */
    public function getAllClothes(): Collection
    {
        return collect($this->repository->getAllClothes());
    }

    /**
     * Add a new clothing item.
     * 
     * @param array $data
     * @return Clothing
     */
    public function addClothing(array $data): Clothing
    {
        $clothing = new Clothing(
            0, // ID will be auto-assigned in the repository
            $data['brand'],
            $data['type'],
            $data['size'],
            $data['colour'],
            $data['price'],
            $data['gender']
        );

        $newId = $this->repository->add($clothing);

        // Return the newly added clothing item by its ID.
        return $this->findById($newId);
    }

    /**
     * Update an existing clothing item.
     * 
     * @param int $id
     * @param array $data
     * @return Clothing
     */
    public function updateClothing(int $id, array $data): Clothing
    {
        $clothing = new Clothing(
            $id,
            $data['brand'],
            $data['type'],
            $data['size'],
            $data['colour'],
            $data['price'],
            $data['gender']
        );

        $this->repository->update($clothing);

        // Return the updated clothing item.
        return $this->findById($id);
    }

    /**
     * Find a clothing item by its ID.
     * 
     * @param int $id
     * @return Clothing|null
     */
    public function findById(int $id): Clothing|null
    {
        $clothes = $this->repository->getAllClothes();

        $clothing = collect($clothes)->firstWhere('id', $id);

        return $clothing;
    }
}
