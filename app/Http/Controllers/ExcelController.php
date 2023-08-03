<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Arr;

class ExcelController extends Controller
{
    public function index(): View
    {
        $data_reports = Report::select('data_report')->distinct()->get();
        $years = [];

        foreach ($data_reports as $key => $data_report) {
            $years[$key] = date('Y', strtotime($data_report->data_report));
        }

        return view('admin.excel', [
            'title' => 'Excel',
            'years' => array_unique($years)
        ]);
    }

    public function selectMonth(Request $request): JsonResponse
    {
        $year = $request->only('year');

        $data_reports = Report::select('data_report')->whereYear('data_report', $year)
            ->distinct()->orderBy('data_report', 'ASC')->get();
        $months = [];

        foreach ($data_reports as $key => $data_report) {
            $month = date('M', strtotime($data_report->data_report));

            $months[$key] = match ($month) {
                'Jan' => 'Janeiro',
                'Feb' => 'Fevereiro',
                'Mar' => 'Marco',
                'Apr' => 'Abril',
                'May' => 'Maio',
                'Jun' => 'Junho',
                'Jul' => 'Julho',
                'Aug' => 'Agosto',
                'Nov' => 'Novembro',
                'Sep' => 'Setembro',
                'Oct' => 'Outubro',
                'Dec' => 'Dezembro'
            };
        }

        return response()->json($months, 200);
    }
}
