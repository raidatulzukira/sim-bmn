<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'pegawai';
    }

    public function rules(): array
    {
        return [
            // Ensure the asset exists and its status is 'tersedia'
            'aset_id' => ['required', 'exists:aset_bmn,id,status,tersedia'],
            'keperluan' => ['required', 'string'],
            'estimasi_waktu_pinjam' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after_or_equal:estimasi_waktu_pinjam'],
        ];
    }

    public function messages(): array
    {
        return [
            'aset_id.exists' => 'Aset yang dipilih tidak tersedia atau tidak valid.',
            'estimasi_waktu_pinjam.after_or_equal' => 'Estimasi waktu pinjam tidak boleh di masa lalu.',
            'tanggal_kembali_rencana.after_or_equal' => 'Tanggal rencana kembali harus setelah atau sama dengan tanggal pinjam.',
        ];
    }
}
