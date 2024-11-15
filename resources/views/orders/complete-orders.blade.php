@extends('layouts.tabler')

@section('content')
    <style>
        .export {
            display: flex;
            margin: auto;
        }

        .export a {
            display: flex;
            background-color: rgb(0, 84, 166);
            align-items: center;
            width: auto;
            padding: 10px;
            color: rgb(255, 255, 255);
            border-radius: 5px;
            margin-bottom: 20px;
            text-decoration: none;
            margin-right: 0;
            margin-left: auto;
        }

        .export a:hover {
            margin-right: 0;
            margin-left: auto;
            background-color: rgb(0, 84, 166);
        }
    </style>
    <div class="page-body">
        @if ($orders->isEmpty())
            <div class="empty">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <circle cx="12" cy="12" r="9" />
                        <line x1="9" y1="10" x2="9.01" y2="10" />
                        <line x1="15" y1="10" x2="15.01" y2="10" />
                        <path d="M9.5 15.25a3.5 3.5 0 0 1 5 0" />
                    </svg>
                </div>
                <p class="empty-title">
                    Penjualan tidak ditemukan
                </p>
                <p class="empty-subtitle text-muted">
                    Tidak ada hasil yang ditemukan. Cobalah ubah pencarian atau filter Anda untuk menemukan yang Anda cari.
                </p>

                <div class="empty-action">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 5l0 14"></path>
                            <path d="M5 12l14 0"></path>
                        </svg>
                        Tambah Penjualan Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="container-xl">
                <div class="export">
                    <a href="{{ route('orders.export') }}">
                        Eskpor ke Excel
                    </a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">
                                {{ __('Penjualan: ') }}
                                <x-status dot color="green" class="text-uppercase">
                                    {{ __('Complete') }}
                                </x-status>
                            </h3>
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('purchases.create') }}" class="btn btn-icon btn-outline-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">{{ __('No.') }}</th>
                                    <th scope="col" class="text-center">{{ __('Invoice No.') }}</th>
                                    <th scope="col" class="text-center">{{ __('Customer') }}</th>
                                    <th scope="col" class="text-center">{{ __('Tanggal') }}</th>
                                    {{-- <th scope="col" class="text-center">{{ __('Pembayaran') }}</th> --}}
                                    <th scope="col" class="text-center">{{ __('Total Harga') }}</th>
                                    <th scope="col" class="text-center">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $order->invoice_no }}</td>
                                        <td class="text-center">{{ $order->customer->name }}</td>
                                        <td class="text-center">{{ $order->order_date->format('d-m-Y') }}</td>
                                        {{-- <td class="text-center">{{ $order->payment_type }}</td> --}}
                                        <td class="text-center">{{ Number::currency($order->total, 'IDR', 'Rp') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('orders.show', $order->uuid) }}"
                                                class="btn btn-icon btn-outline-success">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-eye" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('order.downloadInvoice', $order->uuid) }}"
                                                class="btn btn-icon btn-outline-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-printer" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                    <path
                                                        d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        {{-- - - --}}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
