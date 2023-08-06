<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
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
        return view("admin.create", ["title" => "Cadastro"]);
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

    public function selectMonth(Request $request): Response
    {
        session()->put('datePrefix', $request["date"]);

        $month = date("M", strtotime($request["date"]));

        session()->put('month', $month);


        return response()->json(session('month'));
    }
}
