<?php

namespace App\Jobs;

use App\Imports\MultipleTableImport;
use App\Models\ImportLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProcessExcelImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $importLog;

    public function __construct(ImportLog $importLog)
    {
        $this->importLog = $importLog;
    }

    public function handle()
    {
        $this->importLog->update([
            'status' => 'processing',
            'message' => 'Import started'
        ]);

        try {
            Excel::import(
                new MultipleTableImport($this->importLog),
                storage_path('app/' . $this->importLog->file_path)
            );

            $this->importLog->update([
                'status' => 'completed',
                'message' => 'Import completed successfully',
                'completed_at' => now()
            ]);

        } catch (\Exception $e) {
            $this->importLog->update([
                'status' => 'failed',
                'message' => 'Error: ' . $e->getMessage()
            ]);

            // Optionally send notification about failed import
        }
    }

    public function failed(\Throwable $exception)
    {
        $this->importLog->update([
            'status' => 'failed',
            'message' => 'Job failed: ' . $exception->getMessage()
        ]);
    }
}
