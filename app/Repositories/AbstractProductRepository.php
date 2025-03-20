<?php

declare(strict_types=1);

namespace App\Repositories;


use App\Http\Enums\ProductStatus;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractProductRepository implements ProductRepositoryInterface
{
    protected static $model;

    public static function loadModel():Model
    {
        return app(static::$model);
    }

    public static function all():Collection
    {
        return self::loadModel()::all();
    }

    public static function find(string $code)
    {
        $product = self::loadModel()::query()->where('code', $code)->first();

        if ($product) {
            return $product;
        }

        return 'Product not found';
    }

    public static function create(array $attributes = []): Model|\Illuminate\Database\Eloquent\Builder
    {
        return self::loadModel()::query()->create($attributes);
    }

    public static function delete(string $code): array
    {
        $product = self::loadModel()::query()->where('code', $code)->first();
        if($product->status == ProductStatus::TRASH->value) return ['message' => 'Product was removed from trash'];
        if ($product) {
            $product->status = ProductStatus::TRASH->value;
            $product->save();

            return [
                'message' => 'Product successfully moved to trash',
                'product' => $product
            ];
        }

        return [
            'message' => 'Product not found for deletion',
            'product' => null,
        ];
    }

    public static function update(string $code, array $attributes = []): array
    {
        $product = self::loadModel()::query()->where('code', $code)->first();

        if ($product) {
            $product->update($attributes);

            return [
                'message' => 'Product updated successfully',
                'product' => $product
            ];
        }
        return [
            'message' => 'Product not found for update',
            'product' => null
        ];
    }



    public function paginate(Request $request, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return self::loadModel()::query()->paginate($perPage);
    }

}
