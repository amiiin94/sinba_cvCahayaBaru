<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StoreProductRequest extends FormRequest
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
            'product_image'     => 'image|file|max:2048',
            'name'              => 'required|string',
            'category_id'       => 'required|numberic',
            'unit_id'           => 'required|numeric',
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
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'product_image.image'    => 'File harus berupa gambar',
            'product_image.file'     => 'File yang diunggah tidak valid',
            'product_image.max'      => 'Ukuran gambar tidak boleh lebih dari 2MB',

            'name.required'          => 'Nama produk wajib diisi',
            'name.string'            => 'Nama produk harus berupa teks',

            'category_id.required'   => 'Kategori produk wajib dipilih',
            'category_id.integer'    => 'Kategori yang dipilih tidak valid',

            'unit_id.required'       => 'Unit produk wajib dipilih',
            'unit_id.integer'        => 'Unit yang dipilih tidak valid',

            'quantity.required'      => 'Jumlah produk wajib diisi',
            'quantity.integer'       => 'Jumlah harus berupa angka bulat',

            'buying_price.required'  => 'Harga beli produk wajib diisi',
            'buying_price.integer'   => 'Harga beli harus berupa angka bulat',

            'selling_price.required' => 'Harga jual produk wajib diisi',
            'selling_price.integer'  => 'Harga jual harus berupa angka bulat',

            'quantity_alert.required'=> 'Peringatan jumlah produk wajib diisi',
            'quantity_alert.integer' => 'Peringatan jumlah harus berupa angka bulat',

            'tax.numeric'            => 'Pajak harus berupa angka',
            'tax_type.integer'       => 'Tipe pajak yang dipilih tidak valid',

            'notes.max'              => 'Catatan tidak boleh lebih dari 1000 karakter'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->name, '-'),
            'code' => IdGenerator::generate([
                'table' => 'products',
                'field' => 'code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
        ]);
    }
}
