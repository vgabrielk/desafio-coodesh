<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Http\Enums\ProductStatus;
use Illuminate\Http\JsonResponse;

class ProductService
{
    public function updateProduct(array $data, string $code): JsonResponse
    {
        $product = $this->findOrFail($code);
        return $product instanceof JsonResponse ? $product : (tap($product)->update($data)
            ? response()->json(['message' => 'Update product success'])
            : response()->json(['message' => 'Failed to update product'], 500));
    }
    public function getPaginatedProducts()
    {
        return Product::paginate();
    }

    public function getProductByCode(string $code)
    {
        return $this->findOrFail($code);
    }
    public function deleteProduct(string $code): JsonResponse
    {
        $product = $this->findOrFail($code);
        $product->status = ProductStatus::TRASH->value;
        $product->save();

        return response()->json(['message' => 'Deleted product success']);
    }

    private function findOrFail(string $code)
    {
        return Product::where('code', $code)->first()
            ?? response()->json(['message' => 'Product not found'], 404);
    }
}
