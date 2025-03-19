<?php

namespace App\Http\Controllers;

use App\Http\Services\Database\DatabaseStatusService;
use App\Http\Services\Import\ImportService;
use Illuminate\Http\JsonResponse;

class ProjectStatusController extends Controller
{
    protected DatabaseStatusService $dataBaseStatusService;
    protected ImportService $importService;
    public function __construct(DatabaseStatusService $service, ImportService $importService)
    {
        $this->dataBaseStatusService = $service;
        $this->importService = $importService;
    }
    public function getProjectStatus() : JsonResponse
    {
        $databaseStatus = $this->dataBaseStatusService->projectStatus();
        $lastImport = $this->importService->getLastImport();
        return response()->json([
            'database' => $databaseStatus,
            'last_import' => $lastImport
        ]);
    }
}
