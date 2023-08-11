<?php

namespace App\Http\Controllers;

use App\Helpers\Excel;
use App\Helpers\Helpers;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\Response;

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

    public function getMonths(Request $request): JsonResponse
    {
        $year = $request['year'];

        $data_reports = Report::select('data_report')->whereYear('data_report', $year)
            ->distinct()->orderBy('data_report', 'ASC')->get();
        $months = [];

        foreach ($data_reports as $key => $data_report) {
            $month = date('M', strtotime($data_report->data_report));

            $months[$key] = Helpers::getMonthFullName($month);
        }

        return response()->json(array_unique($months));
    }

    public function generate(Request $request): Response
    {
        $year = $request->string('year', '2023');
        $month = $request->string('month');

        $fileName = Excel::generate($year, $month);

        return response()->json($fileName);
    }

    public function download(string $fileName): Response
    {
        return response()->download(storage_path("app/public/spreadsheets/$fileName"));
    }
}
