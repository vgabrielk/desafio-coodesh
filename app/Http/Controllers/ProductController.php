<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->getPaginatedProducts();
    }

    public function store(ProductRequest $request)
    {
        return $this->service->createProduct($request->validated());
    }

    public function show(String $code)
    {
        return $this->service->getProductByCode($code);
    }

    public function update(ProductRequest $request, String $code)
    {
        return $this->service->updateProduct($request->validated(), $code);
    }

    public function destroy(String $code)
    {
        return $this->service->deleteProduct($code);
    }
}
