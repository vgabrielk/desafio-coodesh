<?php

namespace App\Console\Commands;

use App\Http\Services\Import\ImportService;
use App\Http\Services\Import\ProcessProductsService;
use App\Jobs\ImportProductsJob;
use Illuminate\Console\Command;

class ImportProductsCommand extends Command
{
    protected $signature = 'products:import';
    protected $description = 'Import products from a file';

    protected ProcessProductsService $processProductsService;
    protected ImportService $importService;

    public function __construct()
    {
        parent::__construct();
        $this->processProductsService = app(ProcessProductsService::class);
        $this->importService = app(ImportService::class);
    }

    public function handle(): void
    {
        ImportProductsJob::dispatch($this->processProductsService, $this->importService);
        $this->info('Import finished successfully!');
    }
}
