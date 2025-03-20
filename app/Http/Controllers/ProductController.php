<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public ProductRepository $productRepository;
    public function __construct(ProductRepository $repository)
    {
        $this->productRepository = $repository;
    }

    public function index(Request $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        return $this->productRepository->paginate($request);
    }
    public function show(String $code)
    {
        return $this->productRepository->find($code);
    }

    public function update(ProductRequest $request, String $code): array
    {
        return $this->productRepository->update($code, $request->validated());
    }

    public function destroy(String $code): array
    {
        return $this->productRepository->delete($code);
    }
}
