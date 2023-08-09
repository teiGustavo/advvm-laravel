<?php

namespace App\Http\Controllers;

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
            "lastDay" => self::getLastDayOfMonth(session('datePrefix', ''))
        ]);
    }

    public function getMonthFullName(string $month): string
    {
        return match ($month) {
            'Jan', '1' => 'Janeiro',
            'Feb', 'Fev', '2' => 'Fevereiro',
            'Mar', '3' => 'Marco',
            'Apr', 'Abr', '4' => 'Abril',
            'May', 'Mai', '5' => 'Maio',
            'Jun', '6' => 'Junho',
            'Jul', '7' => 'Julho',
            'Aug', 'Ago', '8' => 'Agosto',
            'Sep', 'Set', '9' => 'Setembro',
            'Oct', 'Out', '10' => 'Outubro',
            'Nov', '11' => 'Novembro',
            'Dec', 'Dez', '12' => 'Dezembro'
        };
    }

    public static function getLastDayOfMonth(string $month): string
    {
        return date("t", strtotime($month));
    }

    public function selectMonth(Request $request): Response
    {
        $monthWithYear = $request->date;
        $month = date("M", strtotime($monthWithYear));
        $lastDay = self::getLastDayOfMonth($month);

        session()->put('dateMin', "$monthWithYear-01");
        session()->put('dateMax', "$monthWithYear-$lastDay");
        session()->put('month', $month);

        return response()->json(session('month'));
    }

    public function endCreateReport(): RedirectResponse
    {

        if (session()->exists('month')) {
            session()->pull('month');
        }

        return redirect()->route('admin.createReport');
    }

    public function store(Request $request): Response
    {
        $cases = ['Saldo Anterior', 'Oferta', 'Ofertas', 'Dízimo', 'Dizimo', 'Dízimos', 'Dizimos'];

        $report = new Report;

        $report->data_report = $request->date;
        $report->historico = ucwords($request->report);
        $report->valor = $request->value;

        if (in_array($report->historico, $cases)) {
            $report->tipo = "Entrada";
        } else {
            $report->tipo = "Saída";
        }

        $report->save();

        return response()->json($report);
    }
}
