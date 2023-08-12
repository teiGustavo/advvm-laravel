<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{
    public function index(): View
    {
        return view('admin.reports', [
            'title' => 'Lançamentos'
        ]);
    }

    public function createReport(): View
    {
        return view("admin.create", [
            "title" => "Cadastro",
            "lastDay" => Helpers::getLastDayOfMonth(session('datePrefix', ''))
        ]);
    }

    public function selectMonth(Request $request): Response
    {
        $monthWithYear = $request->string('date');
        $month = date("M", strtotime($monthWithYear));
        $lastDay = Helpers::getLastDayOfMonth($month);

        session()->put('dateMin', "$monthWithYear-01");
        session()->put('dateMax', "$monthWithYear-$lastDay");
        session()->put('month', $month);

        return response()->json($month);
    }

    public function endCreateReport(): RedirectResponse
    {

        if (session()->exists('month')) {
            session()->pull('month');
            session()->pull('saldoAnterior');
        }

        return redirect()->route('admin.createReport');
    }

    public function store(Request $request): Response
    {
        $cases = ['Saldo Anterior', 'Oferta', 'Ofertas', 'Dízimo', 'Dizimo', 'Dízimos', 'Dizimos'];

        $report = new Report;

        $report->data_report = $request->string('date');
        $report->historico = ucwords($request->string('report'));
        $report->valor = $request->string('value');

        if (in_array($report->historico, $cases)) {
            $report->tipo = "Entrada";
        } else {
            $report->tipo = "Saída";
        }

        if ($report->historico == "Saldo Anterior") {
            session()->pull('saldoAnterior');
        }

        $report->save();

        return response()->json($report);
    }
}
