@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            {{ __('Detail Pembelian') }}
                        </h3>
                    </div>

                    <div class="card-actions btn-actions">
                        {{-- - {{ URL::previous() }} - --}}
                        <a href="{{ route('purchases.index') }}" class="btn-action">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M18 6l-12 12"></path>
                                <path d="M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1">Nama</label>
                            <div class="form-control form-control-solid">{{ $purchase->supplier->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1">Email</label>
                            <div class="form-control form-control-solid">{{ $purchase->supplier->email }}</div>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1">Telepon</label>
                            <div class="form-control form-control-solid">{{ $purchase->supplier->phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1">Tanggal</label>
                            <div class="form-control form-control-solid">{{ $purchase->date }}</div>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1">No Pembelian</label>
                            <div class="form-control">{{ $purchase->purchase_no }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1">Total</label>
                            <div class="form-control form-control-solid">
                                {{ Number::currency($purchase->total_amount, 'IDR', 'Rp') }}</div>
                        </div>
                    </div>
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1">Dibuat Oleh</label>
                            <div class="form-control form-control-solid">{{ $purchase->createdBy->name ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1">Diupdate Oleh</label>
                            <div class="form-control form-control-solid">{{ $purchase->updatedBy->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small mb-1">Alamat</label>
                        <div class="form-control form-control-solid">{{ $purchase->supplier->address }}</div>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="align-middle text-center">No.</th>
                                        <th scope="col" class="align-middle text-center">Foto</th>
                                        <th scope="col" class="align-middle text-center">Nama Produk</th>
                                        <th scope="col" class="align-middle text-center">Kode Produk</th>
                                        <th scope="col" class="align-middle text-center">Stok Saat Ini</th>
                                        <th scope="col" class="align-middle text-center">Stok yang Dibeli</th>
                                        <th scope="col" class="align-middle text-center">Harga</th>
                                        <th scope="col" class="align-middle text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->details as $item)
                                        <tr>
                                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                                            <td class="align-middle justify-content-center text-center">
                                                <div style="max-height: 80px; max-width: 80px;">
                                                    <img class="img-fluid"
                                                        src="{{ $item->product->product_image ? asset('storage/' . $item->product->product_image) : asset('assets/img/products/default.webp') }}">
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ $item->product->name }}
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-indigo-lt">
                                                    {{ $item->product->code }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-primary-lt">
                                                    {{ $item->product->quantity }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="badge bg-primary-lt">
                                                    {{ $item->quantity }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ Number::currency($item->total / $item->quantity, 'IDR', 'Rp') }}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ Number::currency($item->total, 'IDR', 'Rp') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- created by --}}
                                    <tr>
                                        <td class="align-middle text-end" colspan="7">
                                            Dibuat Oleh
                                        </td>
                                        <td class="align-middle text-center">
                                            {{ $purchase->user->name }}
                                        </td>
                                    </tr>

                                    {{-- <tr>
                                    <td class="align-middle text-end" colspan="7">
                                        Persentase Pajak
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ number_format($purchase->tax_percentage, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle text-end" colspan="7">
                                        Jumlah Pajak
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ number_format($purchase->tax_amount, 2) }}
                                    </td>
                                </tr> --}}

                                    <tr>
                                        <td class="align-middle text-end" colspan="7">
                                            Status
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($purchase->status->value == 1)
                                                <span class="badge bg-success-lt">
                                                    Disetujui
                                                </span>
                                            @elseif ($purchase->status->value == 0)
                                                <span class="badge bg-warning-lt">
                                                    Tertunda
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    @if ($purchase->status === \App\Enums\PurchaseStatus::PENDING)
                        <form action="{{ route('purchases.update', $purchase->uuid) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $purchase->id }}">

                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Apakah Anda yakin ingin menyetujui pembelian ini?')">
                                {{ __('Setujui Pembelian') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
