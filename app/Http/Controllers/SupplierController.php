<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use Str;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::where("user_id", auth()->id())->count();

        return view('suppliers.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {
        $image = "";
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store("supliers", "public");
        }

        Supplier::create([
            "user_id" => auth()->id(),
            "uuid" => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Suplier baru berhasil ditambahkan!');
    }

    public function show($uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();
        $supplier->loadMissing('purchases')->get();

        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }

    public function edit($uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();
        return view('suppliers.edit', [
            'supplier' => $supplier
        ]);
    }

    public function update(UpdateSupplierRequest $request, $uuid)
    {
        $supplier = Supplier::where("uuid", $uuid)->firstOrFail();

        /**
         * Handle upload image with Storage.
         */
        $image = $supplier->photo;
        if ($request->hasFile('photo')) {

            // Delete Old Photo
            if ($supplier->photo) {
                unlink(public_path('storage/') . $supplier->photo);
            }

            $image = $request->file('photo')->store("supliers", "public");
        }

        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $image,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Suplier berhasil diedit!');
    }

    public function destroy($uuid)
{
    $supplier = Supplier::where("uuid", $uuid)->firstOrFail();

    // Check if the supplier is linked to any purchase records
    if ($supplier->purchases()->exists()) {
        return redirect()
            ->route('suppliers.index')
            ->with('error', 'Tidak dapat menghapus suplier ini karena terkait dengan catatan pembelian yang sudah ada.');
    }

    /**
     * Delete photo if exists.
     */
    if ($supplier->photo) {
        unlink(public_path('storage/suppliers/') . $supplier->photo);
    }

    $supplier->delete();

    return redirect()
        ->route('suppliers.index')
        ->with('success', 'Suplier berhasil dihapus');
}

}
