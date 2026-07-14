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
            'kode_barang' => ['required', 'string', 'max:50'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis_bmn' => ['required', 'string', 'max:100'],
            'nup' => ['nullable', 'string', 'max:50'],
            'merk' => ['nullable', 'string', 'max:100'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'nama' => ['nullable', 'string', 'max:255'],
            'tanggal_perolehan' => ['required', 'date'],
            'nilai_perolehan_pertama' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'ruangan_id' => ['nullable', 'exists:ruangan,id'],
            'status' => ['nullable', 'in:tersedia,dipinjam,servis'],
        ];
    }
}
