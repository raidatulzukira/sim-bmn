<?php

namespace App\Http\Requests\Pegawai;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'pegawai';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'aset_id' => [
                'required', 
                'exists:aset_bmn,id',
                function ($attribute, $value, $fail) {
                    $aset = \App\Models\AsetBmn::find($value);
                    if ($aset && $aset->status !== 'tersedia') {
                        $fail('Aset yang dipilih sedang tidak tersedia.');
                    }
                }
            ],
            'estimasi_waktu_pinjam' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after_or_equal:estimasi_waktu_pinjam'],
            'keperluan' => ['required', 'string', 'max:1000'],
        ];
    }
}
