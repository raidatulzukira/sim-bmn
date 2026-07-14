<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServisRutinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    public function rules(): array
    {
        return [
            'aset_id' => [
                'required', 
                // Operator can only service assets that are NOT in 'servis' and NOT 'dipinjam'
                Rule::exists('aset_bmn', 'id')->where('status', 'tersedia')
            ],
            'deskripsi_kerusakan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'aset_id.exists' => 'Aset tidak tersedia untuk diservis (mungkin sedang dipinjam atau sudah diservis).',
        ];
    }
}
