<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'unit'])->get();

        $customers = Customer::all()->sortBy('name');

        $carts = Cart::content();

        return view('pos.index', [
            'products' => $products,
            'customers' => $customers,
            'carts' => $carts,
        ]);
    }

    public function addCartItem(Request $request)
{
    // Validate the incoming request data
    $rules = [
        'id' => 'required|numeric|exists:products,id',
        'name' => 'required|string',
        'selling_price' => 'required|numeric',
    ];

    $validatedData = $request->validate($rules);

    // Retrieve the product from the database
    $product = Product::find($validatedData['id']);

    // Check if the product quantity is greater than 0
    if ($product->quantity <= 0) {
        return redirect()
            ->back()
            ->with('error', 'Produk tidak dapat ditambahkan ke keranjang karena stok habis.');
    }

    // Add the product to the cart
    Cart::add(
        $validatedData['id'],
        $validatedData['name'],
        1, // quantity added to the cart
        $validatedData['selling_price'],
        1,
        (array)$options = null
    );

    return redirect()
        ->back()
        ->with('success', 'Produk telah dimasukkan ke dalam keranjang!');
}


    public function updateCartItem(Request $request, $rowId)
    {
        $rules = [
            'qty' => 'required|numeric',
            'product_id' => 'numeric'
        ];
        
        $validatedData = $request->validate($rules);
        if ($validatedData['qty'] > Product::where('id', intval($validatedData['product_id']))->value('quantity')) {
            return redirect()
            ->back()
            ->with('error', 'Jumlah produk tidak tersedia pada stok.');
        }
        

        Cart::update($rowId, $validatedData['qty']);

        return redirect()
            ->back()
            ->with('success', 'Produk telah diubah pada keranjang!');
    }

    public function deleteCartItem(String $rowId)
    {
        Cart::remove($rowId);

        return redirect()
            ->back()
            ->with('success', 'Produk telah dihapus dalam keranjang!');
    }
}
