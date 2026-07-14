<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRuanganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    public function rules(): array
    {
        return [
            'nama_ruangan' => ['required', 'string', 'max:255', 'unique:ruangan,nama_ruangan'],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
