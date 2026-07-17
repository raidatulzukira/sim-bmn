<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLaporanKerusakanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'pegawai';
    }

    public function rules(): array
    {
        return [
            // Ensure aset is not already in 'servis'
            'aset_id' => [
                'required', 
                Rule::exists('aset_bmn', 'id')->whereNot('status', 'servis')
            ],
            'deskripsi_kerusakan' => ['required', 'string', 'min:5'],
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'aset_id.required' => 'Aset wajib dipilih.',
            'aset_id.exists' => 'Aset yang dipilih sedang dalam perbaikan (servis) atau tidak valid.',
            'deskripsi_kerusakan.required' => 'Deskripsi kerusakan wajib diisi agar teknisi mengetahui kendalanya.',
            'foto.required' => 'Foto kerusakan wajib dilampirkan.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
