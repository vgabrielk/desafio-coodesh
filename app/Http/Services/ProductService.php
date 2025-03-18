<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Http\Enums\ProductStatus;

class ProductService
{
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(array $data, String $code)
    {
       return Product::where('code', $code)->update($data);
    }

    public function getAllProducts()
    {
        return Product::all();
    }

    public function getPaginatedProducts()
    {
        return Product::paginate();
    }

    public function getProductByCode(string $code)
    {
        return Product::where('code', $code)->first();
    }

    public function getProduct(Product $product)
    {
        return $product;
    }


    public function deleteProduct(String $code)
    {
        $product = Product::where('code', $code)->first();
        $product->status = ProductStatus::TRASH->value;
        $product->save();
        return $product;
    }
}
