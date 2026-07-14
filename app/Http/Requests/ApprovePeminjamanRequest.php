<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'kasubag_tu';
    }

    public function rules(): array
    {
        return [];
    }
}
