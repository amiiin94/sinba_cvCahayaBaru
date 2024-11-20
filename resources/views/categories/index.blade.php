@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        @if (!$categories)
            <x-empty title="Kategori tidak ditemukan"
                message="obalah menyesuaikan pencarian atau filter Anda untuk menemukan apa yang Anda cari.."
                button_label="{{ __('Tambah Kategori Pertama Anda') }}" button_route="{{ route('categories.create') }}" />
        @else

            <div class="container-xl">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <h3 class="mb-1">Berhasil</h3>
                    <p>{{ session('success') }}</p>

                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <h3 class="mb-1">Terjadi Kesalahan</h3>
                    <p>{{ session('error') }}</p>

                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

                @livewire('tables.category-table')
            </div>
        @endif
    </div>
@endsection
