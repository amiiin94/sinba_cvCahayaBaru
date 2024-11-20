@extends('layouts.tabler')

@section('content')

    <div class="page-body">

        @if (!$purchases)
            <x-empty title="Pembelian tidak ditemukan"
                message="Try adjusting your search or filter to find what you're looking for."
                button_label="{{ __('Tambah pembelian bahan pertama') }}" button_route="{{ route('purchases.create') }}" />
        @else
            <div class="container-xl">
                <div class="d-flex justify-content-end mt-3 mb-3">
                    <a class="btn btn-primary" href="{{ route('purchases.purchaseReport') }}">
                        Expor Pembelian
                    </a>
                </div>
                @livewire('tables.purchase-table')
        @endif
    </div>
@endsection
