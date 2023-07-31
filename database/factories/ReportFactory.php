<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typeReport = collect(['Entrada', 'Saída']);

        return [
            'data_report' => now(),
            'historico' => Str::random(10),
            'tipo' => $typeReport->random(),
            'valor' => 100.50
        ];
    }
}
