<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    public function index(): View
    {
        return view('admin.reports', [
            'title' => 'Lançamentos'
        ]);
    }
}
