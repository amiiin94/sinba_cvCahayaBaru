<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id'   => 'required|exists:suppliers,id',
            'date'          => 'required|string',
            'total_amount'  => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required'    => 'Supplier harus dipilih',
            'supplier_id.exists'      => 'Supplier yang dipilih tidak valid',
            'date.required'           => 'Tanggal harus diisi',
            'total_amount.required'   => 'Total jumlah harus diisi',
            'total_amount.numeric'    => 'Total jumlah harus berupa angka',
        ];
    }
}
