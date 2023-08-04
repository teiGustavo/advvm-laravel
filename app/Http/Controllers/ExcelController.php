<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

    public function getMonthFullName(string $month): string
    {
        return match (substr($month, 0, 3)) {
            'Jan' => 'Janeiro',
            'Feb', 'Fev' => 'Fevereiro',
            'Mar' => 'Marco',
            'Apr', 'Abr' => 'Abril',
            'May', 'Mai' => 'Maio',
            'Jun' => 'Junho',
            'Jul' => 'Julho',
            'Aug', 'Ago' => 'Agosto',
            'Sep', 'Set' => 'Setembro',
            'Oct', 'Out' => 'Outubro',
            'Nov' => 'Novembro',
            'Dec', 'Dez' => 'Dezembro'
        };
    }

    public function getMonthDigits(string $month): string
    {
        return match (substr($month, 0, 3)) {
            'Jan' => 1,
            'Feb', 'Fev' => 2,
            'Mar' => 3,
            'Apr', 'Abr' => 4,
            'May', 'Mai' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Aug', 'Ago' => 8,
            'Sep', 'Set' => 9,
            'Oct', 'Out' => 10,
            'Nov' => 11,
            'Dec', 'Dez' => 12
        };
    }

    public function selectMonth(Request $request): JsonResponse
    {
        $year = $request->only('year');

        $data_reports = Report::select('data_report')->whereYear('data_report', $year)
            ->distinct()->orderBy('data_report', 'ASC')->get();
        $months = [];

        foreach ($data_reports as $key => $data_report) {
            $month = date('M', strtotime($data_report->data_report));

            $months[$key] = $this->getMonthFullName($month);
        }

        return response()->json($months);
    }

    public function download(Request $request): JsonResponse
    {
        $year = $request->string('year', '2023');
        $month = $this->getMonthDigits($request->string('month'));

        $reports = Report::whereMonth();

        return response()->json(["year" => $year, "month" => $month]);
    }
}
