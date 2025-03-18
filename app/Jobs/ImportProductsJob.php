<?php
namespace App\Jobs;

use App\Http\Services\Import\ImportService;
use App\Http\Services\Import\ProcessProductsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ProcessProductsService $processProductsService;
    protected ImportService $importService;

    public function __construct(ProcessProductsService $processProductsService, ImportService $importService)
    {
        $this->processProductsService = $processProductsService;
        $this->importService = resolve(ImportService::class);
    }

    public function handle(): void
    {
        $files = $this->importService->getFilesFromSource();

        foreach ($files as $file) {
            $products = $this->importService->processFile($file);
            if ($products) {
                $this->processProductsService->processProducts($products);
                $this->importService->createImport($file, count($products));
            }
        }
    }

}

