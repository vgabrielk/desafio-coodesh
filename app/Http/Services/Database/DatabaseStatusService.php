<?php

namespace App\Http\Services\Database;


use Illuminate\Support\Facades\DB;

class DatabaseStatusService
{
    public function projectStatus(): string
    {
        try{
            DB::connection()->getPdo();
            $databaseStatus = 'Connected';
        }
        catch(\Exception $exception){
            $databaseStatus = 'Not connected' . $exception->getMessage();
        }
        return $databaseStatus;
    }
}
