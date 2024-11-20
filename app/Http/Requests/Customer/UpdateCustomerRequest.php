<?php

namespace App\Http\Requests\Customer;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'photo' => [
                'image',
                'file',
                'max:1024'
            ],
            'name' => [
                'required',
                'string',
                'max:50'
            ],
            'email' => [
                'required',
                'email',
                'max:50'
            ],
            'phone' => [
                'required',
                'string',
                'max:25'
            ],
            'account_holder' => [
                'max:50'
            ],
            'account_number' => [
                'max:25'
            ],
            'bank_name' => [
                'max:25'
            ],
            'address' => [
                'required',
                'string',
                'max:100'
            ],
        ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'Nama pelanggan wajib diisi.',
        'name.max' => 'Nama pelanggan tidak boleh lebih dari 50 karakter.',
        
        'email.required' => 'Email pelanggan wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.max' => 'Email tidak boleh lebih dari 50 karakter.',
        'email.unique' => 'Email sudah terdaftar untuk pelanggan lain.',
        
        'phone.required' => 'Nomor telepon wajib diisi.',
        'phone.max' => 'Nomor telepon tidak boleh lebih dari 25 karakter.',
        
        'bank_name.required' => 'Bank wajib dipilih.',
        
        'account_holder.max' => 'Nama pemegang rekening tidak boleh lebih dari 50 karakter.',
        'account_number.max' => 'Nomor rekening tidak boleh lebih dari 25 karakter.',
        
        'address.required' => 'Alamat pelanggan wajib diisi.',
        'address.max' => 'Alamat tidak boleh lebih dari 100 karakter.'
    ];
}
}
