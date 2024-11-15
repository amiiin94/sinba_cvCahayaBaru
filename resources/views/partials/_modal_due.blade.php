<div class="modal modal-blur fade" id="modal-due" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form method="POST" action="{{ route('due.update', $order) }}">
            @csrf
            @method('put')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $order->invoice_no }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="payed" class="form-label required">
                                    {{ __('Sudah Dibayar') }}
                                </label>

                                <input type="text" id="payed" class="form-control"
                                       value="{{ Number::currency($order->pay, 'IDR') }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due" class="form-label required">
                                    {{ __('Belum Dibayar') }}
                                </label>

                                <input type="text" id="due" class="form-control"
                                       value="{{ Number::currency($order->due, 'IDR') }}" disabled>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label for="pay_now" class="form-label required">
                                {{ __('Bayar sisa') }}
                            </label>

                            <input type="number"
                                   id="pay_now"
                                   name="pay"
                                   class="form-control @error('pay') is-invalid @enderror"
                                   value="{{ old('pay') }}"
                                   required
                            />

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
                        {{ __('Batal') }}
                    </button>

                    <button type="submit" class="btn btn-primary" onclick="return validatePayment()">
                        {{ __('Bayar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function validatePayment() {
    const payNowInput = document.getElementById('pay_now').value;
    const dueInput = {{ $order->due }};

    if (parseFloat(payNowInput) > parseFloat(dueInput)) {
        alert('Pembayaran melebihi sisa tagihan');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>
