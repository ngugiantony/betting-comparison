<?php

namespace App\Http\Controllers;

use App\Imports\LargeFileImport;
use App\Models\ImportLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SportsImportController extends Controller
{
      public function showForm()
    {
        return view('admin.import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:20480',
        ]);

        $path = $request->file('file')->store('imports', 'local');

        set_time_limit(0);
Excel::import(new LargeFileImport, storage_path("app/{$path}"));

        return back()->with('success', 'File uploaded! Import is processing in the background.');
    }

    
}