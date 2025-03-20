<?php

namespace App\Repositories;

use App\Http\Services\Product\ProductFilterService;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductRepository extends AbstractProductRepository
{
    protected static $model = Product::class;

    public ProductFilterService $productFilterService;

    public function __construct(ProductFilterService $productFilterService)
    {
        $this->productFilterService = $productFilterService;
    }

    public function paginate(Request $request, int $perPage = 15): LengthAwarePaginator
    {
        $filters = $request->query();

        $query = $this->productFilterService->applyFilters(self::loadModel()::query(), $filters);

        return $query->paginate($perPage);
    }

}
