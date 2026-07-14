<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAsetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    public function rules(): array
    {
        // Parameter name from route is 'aset'
        $aset = $this->route('aset');
        $asetId = $aset ? $aset->id : null;

        return [
            'kode_aset' => ['required', 'string', 'max:50', Rule::unique('aset_bmn')->ignore($asetId)],
            'nama_aset' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:100'],
            'spesifikasi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'ruangan_id' => ['required', 'exists:ruangan,id'],
            'status' => ['required', 'in:tersedia,dipinjam,servis'],
        ];
    }
}
