<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_image'     => 'nullable|image|file|max:2048',
            'name'              => [
                'required',
                'string',
                Rule::unique('products')->ignore($this->route('product')) // Ignore current product's name
            ],
            'category_id'       => 'required|integer',
            'unit_id'           => 'required|integer',
            'quantity'          => 'required|integer',
            'buying_price'      => 'required|integer',
            'selling_price'     => 'required|integer',
            'quantity_alert'    => 'required|integer',
            'tax'               => 'nullable|numeric',
            'tax_type'          => 'nullable|integer',
            'notes'             => 'nullable|max:1000'
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'              => 'Nama produk wajib diisi.',
            'name.string'                => 'Nama produk harus berupa teks.',
            'name.unique'                => 'Nama produk sudah terdaftar.',
            'category_id.required'       => 'Kategori produk wajib dipilih.',
            'category_id.integer'        => 'Kategori produk harus berupa angka.',
            'unit_id.required'           => 'Satuan produk wajib dipilih.',
            'unit_id.integer'            => 'Satuan produk harus berupa angka.',
            'quantity.required'          => 'Jumlah produk wajib diisi.',
            'quantity.integer'           => 'Jumlah produk harus berupa angka.',
            'buying_price.required'      => 'Harga beli produk wajib diisi.',
            'buying_price.integer'       => 'Harga beli produk harus berupa angka.',
            'selling_price.required'     => 'Harga jual produk wajib diisi.',
            'selling_price.integer'      => 'Harga jual produk harus berupa angka.',
            'quantity_alert.required'    => 'Jumlah produk untuk peringatan wajib diisi.',
            'quantity_alert.integer'     => 'Jumlah produk untuk peringatan harus berupa angka.',
            'tax.numeric'                => 'Pajak harus berupa angka.',
            'tax_type.integer'           => 'Tipe pajak harus berupa angka.',
            'notes.max'                  => 'Catatan tidak boleh lebih dari 1000 karakter.',
            'product_image.image'        => 'File gambar produk harus berupa gambar.',
            'product_image.file'         => 'File produk harus berupa file.',
            'product_image.max'          => 'Ukuran gambar produk maksimal 2MB.'
        ];
    }
}
