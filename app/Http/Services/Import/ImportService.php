<?php

namespace  App\Http\Services\Import;

use App\Models\Import;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportService
{
    public static function getLastImport(): string
    {
        $lastImport = Import::latest('imported_at')->first();
        $datetime = new \DateTime($lastImport->imported_at,new \DateTimeZone('UTC'));
        $datetime->sub(new \DateInterval('PT3H'));
        return $datetime->format('H:i:s') ?? 'No imports found';
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
        return explode("\n", trim($response->body()));
    }

    public function processFile(string $file): array
    {
        $fileUrl = "https://challenges.coode.sh/food/data/json/{$file}";
        $response = Http::get($fileUrl);
        $tempFilePath = storage_path("app/temp/{$file}");

        file_put_contents($tempFilePath, $response->body());
        $gzFile = gzopen($tempFilePath, 'rb');

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
                Log::error("Error:" . json_last_error_msg());
                $buffer = '';
            }
        }

        gzclose($gzFile);
        unlink($tempFilePath);

        return $products;
    }

    private function isValidJson($decodedData): bool
    {
        return json_last_error() === JSON_ERROR_NONE && is_array($decodedData);
    }
}
