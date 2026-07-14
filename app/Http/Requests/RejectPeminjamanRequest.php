<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectPeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'kasubag_tu';
    }

    public function rules(): array
    {
        return [
            'catatan_penolakan' => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_penolakan.required' => 'Catatan penolakan wajib diisi.',
            'catatan_penolakan.min' => 'Catatan penolakan minimal 5 karakter.',
        ];
    }
}
