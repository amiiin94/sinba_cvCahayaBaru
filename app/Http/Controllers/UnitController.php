<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use Str;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::where("user_id", auth()->id())->select(['id', 'name', 'slug', 'short_code'])
            ->get();

        return view('units.index', [
            'units' => $units,
        ]);
    }

    public function create()
    {
        return view('units.create');
    }

    public function show(Unit $unit)
    {
        $unit->loadMissing('products')->get();

        return view('units.show', [
            'unit' => $unit
        ]);
    }

    public function store(StoreUnitRequest $request)
    {
        Unit::create([
            "user_id" => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'short_code' => $request->short_code,
        ]);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit Berhasil dibuat!');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', [
            'unit' => $unit
        ]);
    }

    public function update(UpdateUnitRequest $request, $slug)
    {
        $unit = Unit::where(["user_id" => auth()->id(), "slug" => $slug])->firstOrFail();
        $unit->name = $request->name;
        $unit->slug = Str::slug($request->name);
        $unit->short_code = $request->short_code;
        $unit->save();

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit has been updated!');
    }

    public function destroy(Unit $unit)
{
    // Check if the unit is associated with any product
    if ($unit->products()->exists()) {
        return redirect()
            ->route('units.index')
            ->with('error', "Tidak dapat menghapus unit ini karena unit ini terkait dengan produk.");
    }

    // Proceed with deletion if no associated products
    $unit->delete();

    return redirect()
        ->route('units.index')
        ->with('success', 'Unit Berhasil Dihapus');
}
}
