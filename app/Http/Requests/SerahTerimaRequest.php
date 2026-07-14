<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerahTerimaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    public function rules(): array
    {
        return [
            'foto_serah_terima' => ['required', 'image', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'foto_serah_terima.required' => 'Bukti foto serah terima wajib diunggah.',
            'foto_serah_terima.image' => 'File harus berupa gambar.',
            'foto_serah_terima.max' => 'Ukuran file maksimal 5MB.',
        ];
    }
}
