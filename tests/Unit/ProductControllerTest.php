<?php

namespace Tests\Unit;

use App\Http\Controllers\ProductController;
use App\Http\Requests\ProductRequest;
use App\Http\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Mockery;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    protected ProductService $service;
    protected ProductController $controller;

    protected string $code = 'ABC1234';


    protected function setUp(): void
    {
        parent::setUp();

        $this->service = Mockery::mock(ProductService::class);
        $this->controller = new ProductController($this->service);
    }

    public function test_index_calls_service_method()
    {
        $this->service->shouldReceive('getPaginatedProducts')
            ->once()
            ->andReturn(['data' => 'paginated_products']);

        $response = $this->controller->index();

        $this->assertEquals(['data' => 'paginated_products'], $response);
    }

    public function test_show_calls_service_method_with_correct_code()
    {

        $this->service->shouldReceive('getProductByCode')
            ->once()
            ->with($this->code)
            ->andReturn(['code' => $this->code, 'name' => 'Product Name']);

        $response = $this->controller->show($this->code);

        $this->assertEquals(['code' => $this->code, 'name' => 'Product Name'], $response);
    }
    public function test_delete_calls_service_method_alter_status_to_trash()
    {
        $mockResponse = \Mockery::mock(JsonResponse::class);
        $mockResponse->shouldReceive('getData')->andReturn(['message' => 'Deleted product success']);

        $this->service->shouldReceive('deleteProduct')
            ->once()
            ->with($this->code)
            ->andReturn($mockResponse);


        $response = $this->controller->destroy($this->code);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(
            ['message' => 'Deleted product success'],
            $response->getData(true),
        );

    }

    public function test_update_calls_service_method_and_returns_json_response()
    {
        $requestData = [
            'name' => 'Updated Product',
            'price' => 199.99
        ];

        $mockResponse = \Mockery::mock(JsonResponse::class);
        $mockResponse->shouldReceive('getData')->andReturn(['message' => 'Update product success']);

        $this->service->shouldReceive('updateProduct')
            ->once()
            ->with($requestData, $this->code)
            ->andReturn($mockResponse);

        $request = \Mockery::mock(ProductRequest::class);
        $request->shouldReceive('validated')->andReturn($requestData);

        $response = $this->controller->update($request, $this->code);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(
            ['message' => 'Update product success'],
            $response->getData(true)
        );
    }

}
