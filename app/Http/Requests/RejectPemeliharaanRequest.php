<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RejectPemeliharaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'kasubag_tu';
    }

    public function rules(): array
    {
        return [
            'catatan_validasi' => ['required', 'string', 'min:5'],
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_validasi.required' => 'Catatan validasi (alasan penolakan) wajib diisi.',
            'catatan_validasi.min' => 'Catatan penolakan minimal 5 karakter.',
        ];
    }
}
