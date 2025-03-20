<?php

namespace App\Http\Services\Import;

use App\Models\Import;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class ImportService
{
    public static function getLastImport(): string
    {
        $lastImport = Import::latest('imported_at')->first();
        if (!$lastImport) {
            return 'No imports found';
        }

        $datetime = new \DateTime($lastImport->imported_at, new \DateTimeZone('UTC'));
        return $datetime->format('H:i:s');
    }
    public static function createImport($file, $processedCount): void
    {
        Import::create([
            'filename' => $file,
            'processed_count' => $processedCount,
            'imported_at' => now(),
        ]);
    }
    public static function getFilesFromSource(): array
    {
        $url = 'https://challenges.coode.sh/food/data/json/index.txt';
        $response = Http::timeout(60)->get($url);
        if (!$response->successful()) {
            Log::error("Failed to retrieve file list from source.");
            throw new Exception("Failed to retrieve file list from source.");
        }

        return explode("\n", trim($response->body()));
    }

    public function processFile(string $file): array
    {
        try {
            $fileUrl = "https://challenges.coode.sh/food/data/json/{$file}";
            echo "Downloading the file: {$file}\n";

            $response = Http::get($fileUrl);
            if (!$response->successful()) {
                Log::error("Error in download file: {$file}");
                throw new Exception("Error in download file: {$file}");
            }

            $tempFilePath = storage_path("app/temp/{$file}");
            file_put_contents($tempFilePath, $response->body());
            echo "Temporary saved: {$file}\n";

            $gzFile = gzopen($tempFilePath, 'rb');
            if (!$gzFile) {
                Log::error("Error openning file GZ: {$file}");
                throw new Exception("Error openning file GZ: {$file}");
            }

            $products = [];
            $buffer = '';
            $batchSize = 100;

            while (!gzeof($gzFile) && count($products) < $batchSize) {
                $buffer .= gzgets($gzFile, 4096);
                $decodedData = json_decode($buffer, true);

                if ($this->isValidJson($decodedData)) {
                    $products[] = $decodedData;
                    $buffer = '';
                } elseif (json_last_error() !== JSON_ERROR_CTRL_CHAR) {
                    Log::error("JSON Error in archive {$file}: " . json_last_error_msg());
                    $buffer = '';
                }
            }

            gzclose($gzFile);
            unlink($tempFilePath);

            echo "Finished procces for file: {$file}\n";

            return $products;

        } catch (Exception $e) {
            Log::error("Error processing file {$file}: " . $e->getMessage());
            return [];
        }
    }

    private function isValidJson($decodedData): bool
    {
        return json_last_error() === JSON_ERROR_NONE && is_array($decodedData);
    }
}
