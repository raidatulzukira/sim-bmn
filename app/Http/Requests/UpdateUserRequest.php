<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->role === 'operator';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Parameter name from Route::resource('pengguna')
        $user = $this->route('pengguna');
        $userId = $user ? $user->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:operator,kasubag_tu,pegawai'],
            'nip' => ['nullable', 'string', 'max:50'],
            'no_wa' => ['nullable', 'string', 'regex:/^(08|\+62)\d{8,13}$/'],
        ];
    }
}
