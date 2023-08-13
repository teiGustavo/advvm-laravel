<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReportsRequest extends FormRequest
{
    protected $redirect  = '';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'data_report' => ['required', 'date'],
            'historico' => ['required'],
            'tipo' => ['required'],
            'valor' => ['required'],
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Erros na validacao',
            'data'      => $validator->errors()
        ]));

    }

    public function messages(): array
    {
        return [
            'data_report.required' => 'A data do lancamento e obrigatoria',
            'historico.required' => 'A descricao do lancamento e obrigatoria',
            'tipo.required' => 'O tipo de lancamento e obrigatorio',
            'valor.required' => 'O valor do lancamento e obrigatorio',
        ];
    }
}
