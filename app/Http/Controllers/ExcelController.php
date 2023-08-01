<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExcelController extends Controller
{
    public function index(): View
    {
        $reports = Report::whereYear('data_report', '2023')->limit(10)->get();

        return view('admin.excel', [
            'title' => 'Excel',
            'reports' => $reports
        ]);
    }
}
