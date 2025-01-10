<?php

namespace Tests\Unit;

use App\Enums\ClothingSizeEnums;
use App\Enums\GenderEnums;
use Illuminate\Http\Response;
use Tests\TestCase;

/**
 * Unit tests for clothing-related API endpoints.
 */
class ClothingTest extends TestCase
{
    /**
     * Test that the application returns a successful response for the root URL.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test that a POST request to '/clothing' returns a 404 response.
     * 
     * @return void
     */
    public function test_the_application_returns_a_not_found_response(): void
    {
        $response = $this->post('/clothing', [
            'brand' => 'Nike',
            'type' => 'T-Shirt',
            'size' => 'XXL'
        ]);

        $response->assertNotFound();
    }

    /**
     * Test that a POST request to '/api/clothing' returns a validation error response.
     * 
     * @return void
     */
    public function test_the_application_returns_a_validation_error_response(): void
    {
        $response = $this->post('/api/clothing', [
            'brand' => 'Nike',
            'type' => 'T-Shirt',
            'size' => 'XXL'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['gender'], 'data');
    }

    /**
     * Test that a successful POST request to '/api/clothing' returns a success response.
     * 
     * @return void
     */
    public function test_the_application_returns_a_success_response(): void
    {
        $response = $this->post('/api/clothing', [
            'brand' => 'Nike',
            'type' => 'T-Shirt',
            'size' => ClothingSizeEnums::LARGE,
            'colour' => 'Green',
            'price' => 150,
            'gender' => GenderEnums::MALE
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => trans('clothing.created')
        ]);
    }

    /**
     * Test that fetching a clothing item by ID returns the correct structure.
     * 
     * @return void
     */
    public function test_the_application_returns_a_clothing_response(): void
    {
        $response = $this->get('/api/clothing/1');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'brand',
                'type',
                'size',
                'colour',
                'price',
                'gender'
            ]
        ]);
    }

    /**
     * Test adding clothing with an invalid size returns a validation error.
     * 
     * @return void
     */
    public function test_adding_clothing_with_invalid_size(): void
    {
        $response = $this->post('/api/clothing', [
            'brand' => 'Nike',
            'type' => 'T-Shirt',
            'size' => 'InvalidSize', // Invalid size
            'colour' => 'Red',
            'price' => 120,
            'gender' => GenderEnums::FEMALE
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['size'], 'data');
    }

    /**
     * Test updating a clothing item returns the correct response.
     * 
     * @return void
     */
    public function test_updating_a_clothing_item(): void
    {
        $response = $this->put('/api/clothing/1', [
            'brand' => 'Adidas-Updated',
            'type' => 'Hoodie',
            'size' => ClothingSizeEnums::MEDIUM,
            'colour' => 'Blue',
            'price' => 200,
            'gender' => GenderEnums::FEMALE
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => trans('clothing.updated'),
            'data' => [
                'brand' => 'Adidas-Updated'
            ]
        ]);
    }
}
