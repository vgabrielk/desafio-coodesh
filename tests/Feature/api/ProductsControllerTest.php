<?php

namespace Tests\Feature\api;

use Tests\TestCase;

class ProductsControllerTest extends TestCase
{
    public function test_product_get(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'from',
            'next_page_url',
            'prev_page_url',
            'to',
            'last_page',
            'path',
            'total',
            'data' => [
                '*' => [
                    'id',
                    'code',
                    'status',
                    'imported_t',
                    'url',
                    'creator',
                    'created_t',
                    'last_modified_t',
                    'product_name',
                    'quantity',
                    'brands',
                    'categories',
                    'labels',
                    'cities',
                    'purchase_places',
                    'stores',
                    'ingredients_text',
                    'traces',
                    'serving_size',
                    'serving_quantity',
                    'nutriscore_score',
                    'nutriscore_grade',
                    'main_category',
                    'image_url',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);

    }

    public function test_product_update(): void
    {
        $updatedProductData = [
            'product_name' => 'Updated Product Name',
            'quantity' => '1kg',
            'brands' => 'Updated Brand Name',
            'categories' => 'Updated Category1, Updated Category2',
            'labels' => 'Updated Label1, Updated Label2',
            'cities' => 'Updated City1, Updated City2',
            'purchase_places' => 'Updated Store1, Updated Store2',
            'stores' => 'Updated Store1, Updated Store2',
            'ingredients_text' => 'Water, Sugar, Updated Ingredient',
            'traces' => 'Contains dairy',
            'serving_size' => '200g',
            'serving_quantity' => '4',
            'nutriscore_score' => '60',
            'nutriscore_grade' => 'A',
            'main_category' => 'Food',
            'image_url' => 'https://example.com/updated-product-image.jpg',
            'imported_t' => '2025-03-17T12:00:00',
            'created_t' => '2025-03-17T12:00:00',
            'url' => 'https://example.com/updated-product-image.jpg',
            'creator' => 'admin',
            'last_modified_t' => '2025-03-17T12:00:00',
            'code' => '0000000000031',
            'status' => 'published',
        ];
        $response = $this->putJson('/api/products/0000000000031', $updatedProductData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'code' => "0000000000031",
            'product_name' => 'Updated Product Name',
            'quantity' => '1kg',
        ]);
    }

    public function test_product_delete(): void
    {
        $response = $this->deleteJson('/api/products/0000000000031');
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'code' => "0000000000031",
            'status' => 'trash',
        ]);
    }
}
