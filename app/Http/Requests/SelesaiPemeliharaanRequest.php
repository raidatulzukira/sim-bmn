<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelesaiPemeliharaanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    public function rules(): array
    {
        return [
            'nota_teknisi' => ['required', 'array', 'min:1'],
            'nota_teknisi.*' => ['file', 'mimes:jpeg,png,jpg,pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nota_teknisi.required' => 'Minimal 1 nota teknisi / bukti servis wajib diunggah.',
            'nota_teknisi.array' => 'Format nota teknisi tidak valid.',
            'nota_teknisi.min' => 'Minimal 1 nota teknisi / bukti servis wajib diunggah.',
            'nota_teknisi.*.mimes' => 'File harus berupa gambar (JPEG/PNG) atau dokumen PDF.',
            'nota_teknisi.*.max' => 'Ukuran setiap file maksimal 5MB.',
        ];
    }
}
