<?php

namespace App\Commands;

use Domain\Stock\Models\OldStock;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Support\Csv;

class ImportSahamLamaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-saham-lama-command';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting');

        $importCount = $this->import(resource_path('stocks/tipe-a.csv'), 'A');
        $importCount += $this->import(resource_path('stocks/tipe-b.csv'), 'B');

        $this->info('Berhasil di-import: '.$importCount);
        $this->info('Done');
    }

    private function import(string $filePath, string $type): int
    {
        $importCount = 0;
        $csvReader = new Csv($filePath);
        $csvReader->row(function ($row) use (&$importCount, $type) {
            $date = Carbon::now()->setTime(0, 0);
            $dateStr = str_replace(' ', '', $row['TANGGAL']);

            if (! empty($dateStr)) {
                $carbon = Carbon::createFromFormat('d-m-Y', $dateStr);

                if ($carbon) {
                    $date = $carbon->setTime(0, 0);
                }
            }

            $kelompok = trim($row['KELOMPOK']);

            if ($kelompok === 'Sumberejo I' || $kelompok === 'Sumberejo II') {
                $kelompok = 'Sumberejo';
            }

            OldStock::query()->create([
                'id' => Str::uuid(),
                'no_seri' => $row['NOMOR_SERI'],
                'tipe_seri' => $type,
                'nama_registrasi' => $row['NAMA_PEMILIK_SAHAM'],
                'kelompok' => $kelompok,
                'created_at' => $date,
            ]);

            $importCount++;
        });

        return $importCount;
    }
}
