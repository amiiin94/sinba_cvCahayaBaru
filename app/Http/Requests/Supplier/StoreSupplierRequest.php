<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'phone' => 'required|string|max:25',
            'shopname' => 'required|string|max:50',
            'type' => 'required|string|max:25',
            'account_holder' => 'max:50',
            'account_number' => 'max:25',
            'bank_name' => 'max:25',
            'address' => 'required|string|max:100',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'photo.image' => 'Foto harus berupa gambar.',
            'photo.file' => 'Foto harus berupa file.',
            'photo.max' => 'Ukuran foto tidak boleh lebih dari 1 MB.',
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 50 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 25 karakter.',
            'shopname.required' => 'Nama toko wajib diisi.',
            'shopname.string' => 'Nama toko harus berupa teks.',
            'shopname.max' => 'Nama toko tidak boleh lebih dari 50 karakter.',
            'type.required' => 'Jenis usaha wajib diisi.',
            'type.string' => 'Jenis usaha harus berupa teks.',
            'type.max' => 'Jenis usaha tidak boleh lebih dari 25 karakter.',
            'account_holder.max' => 'Nama pemegang rekening tidak boleh lebih dari 50 karakter.',
            'account_number.max' => 'Nomor rekening tidak boleh lebih dari 25 karakter.',
            'bank_name.max' => 'Nama bank tidak boleh lebih dari 25 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat harus berupa teks.',
            'address.max' => 'Alamat tidak boleh lebih dari 100 karakter.',
        ];
    }
}
