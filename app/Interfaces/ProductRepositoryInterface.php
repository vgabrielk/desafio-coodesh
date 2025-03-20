<?php

declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ProductRepositoryInterface
{
    public static function all(): Collection;

    public static function create(array $attributes);

    public static function find(string $code);

    public static function delete(string $code);
    public static function update(string $code, array $attributes);

    public static function loadModel(): Model;

    public function paginate(Request $request, int $perPage = 15);
}
