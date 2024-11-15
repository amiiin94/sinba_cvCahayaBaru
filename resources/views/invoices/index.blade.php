<!DOCTYPE html>
<html lang="en">

<head>
    <title>Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- Pustaka CSS Eksternal -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/bootstrap.min.css') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Stylesheet Kustom -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/style.css') }}">
</head>

<body>

    <div class="invoice-16 invoice-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Detail Faktur -->
                    <div class="invoice-inner-9" id="invoice_wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <!-- Informasi Toko -->
                                <div class="col-lg-6 col-sm-6">
                                    <div class="logo">
                                        <h1>Name Store</h1>
                                    </div>
                                </div>
                                <!-- Informasi Faktur -->
                                <div class="col-lg-6 col-sm-6">
                                    <div class="invoice">
                                        <h1>Invoice # <span>123456</span></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Informasi Pelanggan dan Toko -->
                        <div class="invoice-info">
                            <div class="row">
                                <div class="col-sm-6 mb-50">
                                    <h4 class="inv-title-1">Tanggal Faktur:</h4>
                                    <p>{{ Carbon\Carbon::now()->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 mb-50">
                                    <h4 class="inv-title-1">Pelanggan</h4>
                                    <p>{{ $customer->name }}</p>
                                    <p>{{ $customer->phone }}</p>
                                    <p>{{ $customer->email }}</p>
                                    <p>{{ $customer->address }}</p>
                                </div>
                                <div class="col-sm-6 text-end mb-50">
                                    <h4 class="inv-title-1">Toko</h4>
                                    <p>Name Store</p>
                                    <p>(+62) 123 123 123</p>
                                    <p>email@example.com</p>
                                    <p>Cirebon, Jawa Barat, Indonesia</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Pesanan -->
                        <div class="order-summary">
                            <div class="table-outer">
                                <table class="default-table invoice-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->name }}</td>
                                                <td class="text-center">{{ $item->price }}</td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-center">{{ $item->subtotal }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                            <td class="text-center">
                                                <strong>{{ Cart::subtotal() }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Pajak</strong></td>
                                            <td class="text-center">
                                                <strong>{{ Cart::tax() }}</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                                            <td class="text-center">
                                                <strong>{{ Cart::total() }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Faktur -->
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a class="btn btn-lg btn-primary" href="{{ route('pos.index') }}">Kembali</a>
                        <button class="btn btn-lg btn-download" type="button" data-bs-toggle="modal"
                            data-bs-target="#modal">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center mx-auto">Faktur {{ $customer->name }}<br />Total
                        ${{ Cart::total() }}</h3>
                </div>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="mb-3">
                            <label for="payment_type">Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-control" id="payment_type" name="payment_type">
                                <option disabled>Pilih metode pembayaran:</option>
                                <option value="HandCash">Tunai</option>
                                <option value="Cheque">Cek</option>
                                <option value="Due">Hutang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pay">Bayar Sekarang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="pay" name="pay"
                                value="{{ old('pay') }}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-lg btn-danger" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-lg btn-download" type="submit">Bayar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
