<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/bootstrap.min.css') }}">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/invoice/css/style.css') }}">
</head>
    <body>
        @php
            $user=auth()->user();
        @endphp
        <div class="invoice-16 invoice-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-inner-9" id="invoice_wrapper">
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="logo">
                                            <h1>{{ $user->store_name }}</h1>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <div class="invoice">
                                            {{-- <h1>Invoice # <span>123456</span></h1> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-info">
                                <div class="row">
                                    <div class="col-sm-6 mb-50">
                                        <div class="invoice-number">
                                            <h4 class="inv-title-1">Tanggal Invoice:</h4>
                                            <p class="invo-addr-1">
                                            {{ isset($order_date) ? \Carbon\Carbon::parse($order_date)->format('M d, Y') : \Carbon\Carbon::now()->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 mb-50">
                                        <h4 class="inv-title-1">Customer</h4>
                                        <p class="inv-from-1">{{ $customer->name }}</p>
                                        <p class="inv-from-1">{{ $customer->phone }}</p>
                                        <p class="inv-from-1">{{ $customer->email }}</p>
                                        <p class="inv-from-2">{{ $customer->address }}</p>
                                    </div>
                                    <div class="col-sm-6 text-end mb-50">
                                        <h4 class="inv-title-1">Store</h4>
                                        <p class="inv-from-1">{{ $user->store_name }}</p>
                                        <p class="inv-from-1">{{ $user->store_phone }}</p>
                                        <p class="inv-from-1">{{ $user->store_email }}</p>
                                        <p class="inv-from-2">{{ $user->store_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="order-summary">
                                <div class="table-outer">
                                    <table class="default-table invoice-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Nama Barang</th>
                                                {{-- <th class="text-center">Kategori</th> --}}
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $item)
                                            <tr>
                                                <td class="text-center">{{ $item->name }}</td>
                                                {{-- <td class="text-center">{{ $item->category->name }}</td> --}}
                                                <td class="text-center">{{ Number::currency($item->price, 'IDR', 'Rp') }}</td>
                                                <td class="text-center">{{ $item->qty }}</td>
                                                <td class="text-center">{{  Number::currency($item->subtotal, 'IDR', 'Rp') }}</td>
                                            </tr>
                                            @endforeach
                                            {{-- <tr>
                                                <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                                <td class="text-center">
                                                    <strong>{{ Cart::subtotal() }}</strong>
                                                </td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <td colspan="3" class="text-end"><strong>Tax</strong></td>
                                                <td class="text-center">
                                                    <strong>{{ Cart::tax() }}</strong>
                                                </td>
                                            </tr>
                                            <tr> --}}
                                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                                <td class="text-center">
                                                    <strong>{{ Number::currency(Cart::total(), 'IDR', 'Rp') }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="invoice-informeshon-footer">
                                <ul>
                                    <li><a href="#">www.website.com</a></li>
                                    <li><a href="mailto:sales@hotelempire.com">info@example.com</a></li>
                                    <li><a href="tel:+088-01737-133959">+62 123 123 123</a></li>
                                </ul> --}}
        {{--                    </div>--}}
                        </div>

                        <div class="invoice-btn-section clearfix d-print-none">
                            <a href="{{ url()->previous() }}" class="btn btn-warning">
                                {{ __('Kembali') }}
                            </a>

                            {{-- <form action="{{ route('orders.store') }}" method="POST" style="display: inline;">
                                @csrf --}}
                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                                <input type="hidden" name="payment_type" value="HandCash">
                                <input type="hidden" name="pay" value="{{ Cart::total() }}">
                                <!-- Replace the existing Bayar button with this -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                                    {{ __('Bayar') }}
                                </button>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-blur fade" id="modal" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('Pembayaran') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST" onsubmit="return validatePay()">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                        <x-input.index label="Customer" name="customer" value="{{ $customer->name }}" disabled/>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="payment_type" class="form-label required">
                                            {{ __('Pembayaran') }}
                                        </label>

                                        <select class="form-control @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type">
                                            <option selected disabled>Pilih Pembayaran...</option>
                                            <option value="HandCash">Bayar Langsung</option>
                                            <option value="Due">Dp (Uang muka)</option>
                                        </select>

                                        @error('payment_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <label for="pay" class="form-label required">
                                        {{ __('Bayar Sekarang') }}
                                    </label>

                                    <input type="number"
                                           id="pay"
                                           name="pay"
                                           class="form-control @error('pay') is-invalid @enderror"
                                           value="{{ old('pay') }}"
                                           required
                                           data-total="{{ Cart::total() }}"
                                    >

                                    @error('pay')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">
                                {{ __('Batalkan') }}
                            </button>
                            <button class="btn btn-primary" type="submit">
                                {{ __('Bayar') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>
            // When modal opens
            document.getElementById('modal').addEventListener('show.bs.modal', function () {
                const paymentType = document.getElementById('payment_type');
                const payInput = document.getElementById('pay');
                const total = {{ Cart::total() }};

                // Reset payment type selection
                paymentType.selectedIndex = 0;

                // Reset pay input
                payInput.value = '';
                payInput.readOnly = false;
            });

            // When payment type changes
            document.getElementById('payment_type').addEventListener('change', function() {
                const payInput = document.getElementById('pay');
                const total = {{ Cart::total() }};

                if (this.value === 'HandCash') {
                    payInput.value = total;
                    payInput.readOnly = true;
                } else {
                    payInput.value = '';
                    payInput.readOnly = false;
                }
            });

            function validatePay() {
    const payInput = document.getElementById('pay');
    const payValue = parseFloat(payInput.value);
    const total = parseFloat(payInput.getAttribute('data-total'));

    if (payValue > total) {
        alert('Jumlah pembayaran tidak boleh lebih besar dari total keranjang: ' + total);
        return false;
    }
    return true;
}
        </script>
    </body>
</html>
