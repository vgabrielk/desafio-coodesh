<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Client\Request;
use Mockery;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected ProductRepository $repository;
    protected ProductController $controller;

    protected string $code = 'ABC1234';

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(ProductRepository::class);
        $this->controller = new ProductController($this->repository);
    }
    public function test_delete_calls_repository_method_alter_status_to_trash()
    {
        $this->repository->shouldReceive('delete')
            ->once()
            ->with($this->code)
            ->andReturn([
                'message' => 'Product successfully moved to trash',
                'product' => ['code' => $this->code]
            ]);

        $response = $this->controller->destroy($this->code);

        $this->assertEquals([
            'message' => 'Product successfully moved to trash',
            'product' => ['code' => $this->code]
        ], $response);
    }

    public function test_delete_returns_error_when_product_not_found()
    {
        $this->repository->shouldReceive('delete')
            ->once()
            ->with($this->code)
            ->andReturn([
                'message' => 'Product not found for deletion',
                'product' => null
            ]);

        $response = $this->controller->destroy($this->code);

        $this->assertEquals([
            'message' => 'Product not found for deletion',
            'product' => null
        ], $response);
    }


    public function test_update_calls_repository_method_and_returns_array()
    {
        $code = 'ABC123';
        $requestData = [
            'name' => 'Updated Product',
            'price' => 100,
            'description' => 'Updated description'
        ];

        $this->repository->shouldReceive('update')
            ->once()
            ->with($code, $requestData)
            ->andReturn([
                'message' => 'Product updated successfully',
                'product' => $requestData
            ]);

        $request = Mockery::mock(ProductRequest::class)->makePartial();
        $request->shouldReceive('validated')->andReturn($requestData);

        $response = $this->controller->update($request, $code);

        $this->assertIsArray($response);
        $this->assertEquals('Product updated successfully', $response['message']);
        $this->assertEquals($requestData, $response['product']);
    }

    public function test_update_returns_error_when_product_not_found()
    {
        $code = 'ABC123';
        $requestData = [
            'name' => 'Updated Product',
            'price' => 100,
            'description' => 'Updated description'
        ];

        $this->repository->shouldReceive('update')
            ->once()
            ->with($code, $requestData)
            ->andReturn([
                'message' => 'Product not found for update',
                'product' => null
            ]);

        $request = Mockery::mock(ProductRequest::class)->makePartial();
        $request->shouldReceive('validated')->andReturn($requestData);

        $response = $this->controller->update($request, $code);

        $this->assertIsArray($response);
        $this->assertEquals('Product not found for update', $response['message']);
        $this->assertNull($response['product']);
    }

    public function test_show_calls_repository_method_with_correct_code()
    {
        $this->repository->shouldReceive('find')
            ->once()
            ->with($this->code)
            ->andReturn(['code' => $this->code, 'name' => 'Product Name']);

        $response = $this->controller->show($this->code);

        $this->assertEquals(['code' => $this->code, 'name' => 'Product Name'], $response);
    }

    public function test_show_returns_error_when_product_not_found()
    {
        $this->repository->shouldReceive('find')
            ->once()
            ->with($this->code)
            ->andReturn('Product not found');

        $response = $this->controller->show($this->code);

        $this->assertEquals('Product not found', $response);
    }

}
