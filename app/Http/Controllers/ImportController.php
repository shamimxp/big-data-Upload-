<?php

namespace App\Http\Controllers;

use App\Imports\MultipleTableImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            ini_set('memory_limit', '1000M');
            set_time_limit(600); // 10 minutes
            Excel::import(new MultipleTableImport(), $request->file('file'));
            return back()->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

    }
}
