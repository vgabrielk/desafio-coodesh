<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Http\Enums\ProductStatus;

class ProductService
{
    public function updateProduct(array $data, String $code): \Illuminate\Http\JsonResponse
    {
        Product::where('code', $code)->update($data);
        return response()->json(
            ['message' => 'Update product success'],
        );
    }

    public function getAllProducts(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::all();
    }

    public function getPaginatedProducts()
    {
        return Product::paginate();
    }

    public function getProductByCode(string $code)
    {
        $product = Product::where('code', $code)->first();
        if(!$product) return response()->json(['message' => 'Product not found'], 404);
        return $product;
    }

    public function getProduct(Product $product): Product
    {
        return $product;
    }


    public function deleteProduct(String $code): \Illuminate\Http\JsonResponse
    {
        $product = Product::where('code', $code)->first();
        if(!$product) return response()->json(['message' => 'Product not found'], 404);
        $product->status = ProductStatus::TRASH->value;
        $product->save();
        return response()->json(
            ['message' => 'Deleted product success'],
        );
    }
}
