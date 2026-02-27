<?php

namespace App\Imports;

use App\Models\SportOdd;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class LargeFileImport implements
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $rows): void
    {
        $data = [];

        foreach ($rows as $row) {
            // Skip completely empty rows
            if (empty(array_filter($row->toArray()))) {
                continue;
            }

            $data[] = [
                'bookmarker'          => 'unibet',
                'sport'          => $row['sport']           ?? null,
                'ligue'          => $row['ligue']           ?? null,
                'categorie'      => $row['category']       ?? null,
                'evenement'      => $row['event']       ?? null,
                'date'           => $row['date'] ?? null,
                'marche'         => $row['marche']          ?? null,  // Marché
                'market_outcome' => $row['market']   ?? null,  // Laravel Excel strips / and spaces
                'odds' => isset($row['odds']) ? (float) str_replace(',', '.', $row['odds']) : null,
                // 'liability'      => $row['liability'] ?? null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        if (!empty($data)) {
            // Insert in batches of 500 to avoid query size limits
            foreach (array_chunk($data, 500) as $chunk) {
                SportOdd::insert($chunk);
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }

   
}