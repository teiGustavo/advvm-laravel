<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportsRequest;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Helpers;

class ReportsController extends Controller
{
    public function index(): View
    {
        return view('admin.reports', [
            'title' => 'Lançamentos',
            'reports' => Report::paginate(5)
        ]);
    }

    public function find(Request $request)
    {
        $report = Report::find($request->route('id'));

        return response()->json($report);
    }

    public function edit(string $id)
    {
        return response()->json(Report::find($id));
    }

    public function update(ReportsRequest $request)
    {
        $id = $request->string('id');
        $validated = $request->validated();

        $report = Report::find($id);

        $report->data_report = $validated['data_report'];
        $report->historico = $validated['historico'];
        $report->tipo = $validated['tipo'];
        $report->valor = $validated['valor'];

        $report->save();

        return response()->json($report);
    }

    public function delete(Request $request)
    {
        Report::destroy($request->route('id'));

        return back();
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

    public function store(ReportsRequest $request): Response
    {
        $validated = $request->validated();

        $cases = ['Saldo Anterior', 'Oferta', 'Ofertas', 'Dízimo', 'Dizimo', 'Dízimos', 'Dizimos'];

        $report = new Report;

        $report->data_report = $validated['data_report'];
        $report->historico = ucwords($validated['historico']);
        $report->valor = $validated['valor'];

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
