<?php

namespace App\Http\Services\Product;

class ProductFilterService
{

    public static function applyFilters($query, $filters)
    {
        if (isset($filters['code'])) {
            $query->where('code', 'LIKE', '%' . $filters['code'] . '%');
        }

        if (isset($filters['creator'])) {
            $query->where('creator', 'LIKE', '%' . $filters['creator'] . '%');
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['product_name'])) {
            $query->where('product_name', 'LIKE', '%' . $filters['product_name'] . '%');
        }

        if (isset($filters['ingredients_text'])) {
            $query->where('ingredients_text', 'LIKE', '%' . $filters['ingredients_text'] . '%');
        }

        if (isset($filters['cities'])) {
            $query->where('cities', 'LIKE', '%' . $filters['cities'] . '%');
        }

        if (isset($filters['purchase_places'])) {
            $query->where('purchase_places', 'LIKE', '%' . $filters['purchase_places'] . '%');
        }

        if (isset($filters['stores'])) {
            $query->where('stores', 'LIKE', '%' . $filters['stores'] . '%');
        }

        if (isset($filters['main_category'])) {
            $query->where('main_category', $filters['main_category']);
        }

        if (isset($filters['traces'])) {
            $query->where('traces', 'LIKE', '%' . $filters['traces'] . '%');
        }

        if (isset($filters['image_url'])) {
            $query->where('image_url', 'LIKE', '%' . $filters['image_url'] . '%');
        }

        if (isset($filters['nutriscore_score'])) {
            $query->where('nutriscore_score', $filters['nutriscore_score']);
        }

        if (isset($filters['nutriscore_grade'])) {
            $query->where('nutriscore_grade', $filters['nutriscore_grade']);
        }

        if (isset($filters['imported_t'])) {
            $query->whereDate('imported_t', '=', $filters['imported_t']);
        }

        if (isset($filters['created_t'])) {
            $query->whereDate('created_t', '=', $filters['created_t']);
        }

        if (isset($filters['last_modified_t'])) {
            $query->whereDate('last_modified_t', '=', $filters['last_modified_t']);
        }

        if (isset($filters['quantity'])) {
            $query->where('quantity', $filters['quantity']);
        }

        return $query;
    }
}
