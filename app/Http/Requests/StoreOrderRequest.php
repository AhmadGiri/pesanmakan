<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Customer tidak perlu login untuk membuat pesanan
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'table_number' => 'required|integer|min:1',
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama pemesan wajib diisi.',
            'customer_name.string' => 'Nama pemesan harus berupa teks.',
            'customer_name.max' => 'Nama pemesan maksimal 255 karakter.',

            'table_number.required' => 'Nomor meja wajib diisi.',
            'table_number.integer' => 'Nomor meja harus berupa angka.',
            'table_number.min' => 'Nomor meja minimal 1.',

            'items.required' => 'Silakan pilih minimal satu menu.',
            'items.array' => 'Format menu tidak valid.',
            'items.*.integer' => 'Jumlah menu harus berupa angka.',
            'items.*.min' => 'Jumlah menu tidak boleh kurang dari 0.',
        ];
    }
}
