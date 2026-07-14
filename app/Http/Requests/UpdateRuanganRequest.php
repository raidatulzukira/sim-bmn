<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRuanganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    public function rules(): array
    {
        $ruangan = $this->route('ruangan');
        $ruanganId = $ruangan ? $ruangan->id : null;

        return [
            'nama_ruangan' => ['required', 'string', 'max:255', Rule::unique('ruangan')->ignore($ruanganId)],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}
