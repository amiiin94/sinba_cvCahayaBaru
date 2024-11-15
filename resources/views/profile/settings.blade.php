@extends('layouts.tabler')

@section('content')
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Pengaturan Akun - Pengaturan
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-xl px-4 mt-4">
        @include('profile.component.menu')

        <hr class="mt-0 mb-4" />

        @include('partials.session')

        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">
                                {{ __('Ubah Kata Sandi') }}
                            </h3>
                        </div>
                    </div>

                    <x-form action="{{ route('password.update') }}" method="PUT">
                        <div class="card-body">
                            <x-input type="password" name="current_password" label="Kata Sandi Saat Ini" required />
                            <x-input type="password" name="password" label="Kata Sandi Baru" required />
                            <x-input type="password" name="password_confirmation" label="Konfirmasi Kata Sandi" required />
                        </div>

                        <div class="card-footer text-end">
                            <x-button type="submit">{{ __('Simpan') }}</x-button>
                        </div>
                    </x-form>
                </div>
            </div>

            {{-- <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        Otentikasi Dua Faktor
                    </div>
                    <div class="card-body">
                        <p>
                            Tambahkan lapisan keamanan ekstra ke akun Anda dengan mengaktifkan otentikasi dua faktor.
                            Kami akan mengirimkan pesan teks untuk memverifikasi upaya login Anda pada perangkat dan
                            browser yang tidak dikenal.
                        </p>
                        <form>
                            <div class="form-check">
                                <input class="form-check-input" id="twoFactorOn" type="radio" name="twoFactor"
                                    checked="" />
                                <label class="form-check-label" for="twoFactorOn">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="twoFactorOff" type="radio" name="twoFactor" />
                                <label class="form-check-label" for="twoFactorOff">Nonaktif</label>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        Hapus Akun
                    </div>
                    <div class="card-body">
                        <p>
                            Menghapus akun Anda adalah tindakan permanen dan tidak dapat dibatalkan. Jika Anda yakin ingin
                            menghapus akun Anda, pilih tombol di bawah ini.
                        </p>
                        <button type="button" class="btn btn-danger-soft text-danger">
                            Saya mengerti, hapus akun saya
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@push('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpush
