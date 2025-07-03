<?php

namespace App\Http\Controllers;

use App\Imports\MultipleTableImport;
use App\Jobs\ProcessExcelImport;
use App\Models\ImportLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

//    public function import(Request $request)
//    {
//        $request->validate([
//            'file' => 'required|mimes:xlsx,xls'
//        ]);
//
//        try {
//            ini_set('memory_limit', '1000M');
//            set_time_limit(600); // 10 minutes
//            Excel::import(new MultipleTableImport(), $request->file('file'));
//            return back()->with('success', 'Data imported successfully!');
//        } catch (\Exception $e) {
//            return back()->with('error', 'Error: ' . $e->getMessage());
//        }
//
//    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:102400' // 100MB max
        ]);

        try {
            // Store the file
            $path = $request->file('file')->store('imports');

            // Create import log
            $importLog = ImportLog::create([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_path' => $path,
                'user_id' => 1,
                'status' => 'pending'
            ]);

            // Dispatch the job
            ProcessExcelImport::dispatch($importLog)->onQueue('imports');

            return back();

//            // Return proper JSON response
//            return response()->json([
//                'success' => true,
//                'message' => 'File uploaded successfully! The import is processing in the background.',
//                'import_id' => $importLog->id
//            ]);
//
        } catch (\Exception $e) {
            // Return JSON error response
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($importId)
    {
        try {
            $importLog = ImportLog::findOrFail($importId);

            return response()->json([
                'status' => $importLog->status,
                'processed' => $importLog->processed_rows,
                'total' => $importLog->total_rows,
                'message' => $importLog->message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Import log not found'
            ], 404);
        }
    }

}
