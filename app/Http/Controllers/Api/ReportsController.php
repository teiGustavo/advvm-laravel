<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportsRequest;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Report::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportsRequest $request)
    {
        $validated = $request->validated();

        $report = new Report;

        $report->data_report = $validated['data_report'];
        $report->historico = $validated['historico'];
        $report->tipo = $validated['tipo'];
        $report->valor = $validated['valor'];

        $report->save();

        return response()->json($report);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = Report::find($id);

        if (empty($report)) {
            return response()->json("O relatorio com esse ID nao existe!", 404);
        }

        return response()->json($report);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportsRequest $request, string $id)
    {
        $validated = $request->validated();

        $report = Report::find($id);

        $report->data_report = $validated['data_report'];
        $report->historico = $validated['historico'];
        $report->tipo = $validated['tipo'];
        $report->valor = $validated['valor'];

        $report->save();

        return response()->json($report);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Report::destroy($id);

        return response()->json(Report::find($id));
    }
}
