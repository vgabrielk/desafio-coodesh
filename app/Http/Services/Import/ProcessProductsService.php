<?php

namespace App\Http\Services\Import;

use App\Models\Product;

class ProcessProductsService
{
    public function processProducts(array $products)
    {
        $dataToUpsert = [];
        foreach ($products as $productData) {
            $cleanedCode = str_replace(['\\', '"'], '', $productData['code']);

            $dataToUpsert[] = [
                'code' => $cleanedCode,
                'product_name' => $productData['product_name'],
                'status' => $productData['status'] ?? 'trash',
                'imported_t' => now(),
                'url' => $productData['url'],
                'creator' => $productData['creator'],
                'created_t' => isset($productData['created_t']) ? date('Y-m-d H:i:s', $productData['created_t']) : null,
                'last_modified_t' => isset($productData['last_modified_t']) ? date('Y-m-d H:i:s', $productData['last_modified_t']) : null,
                'quantity' => $productData['quantity'] ?? 0,
                'brands' => $productData['brands'],
                'categories' => $productData['categories'],
                'labels' => $productData['labels'],
                'cities' => $productData['cities'],
                'purchase_places' => $productData['purchase_places'],
                'stores' => $productData['stores'],
                'ingredients_text' => $productData['ingredients_text'],
                'traces' => $productData['traces'],
                'serving_size' => $productData['serving_size'],
                'serving_quantity' => $productData['serving_quantity'] ?? 0,
                'nutriscore_score' => $productData['nutriscore_score'],
                'nutriscore_grade' => $productData['nutriscore_grade'],
                'main_category' => $productData['main_category'],
                'image_url' => $productData['image_url'],
            ];
        }

        $uniqueBy = ['code'];

        $updateColumns = [
            'product_name', 'status', 'imported_t', 'url', 'creator', 'created_t', 'last_modified_t',
            'quantity', 'brands', 'categories', 'labels', 'cities', 'purchase_places', 'stores',
            'ingredients_text', 'traces', 'serving_size', 'serving_quantity', 'nutriscore_score',
            'nutriscore_grade', 'main_category', 'image_url',
        ];

        return Product::upsert($dataToUpsert, $uniqueBy, $updateColumns);
    }
}
