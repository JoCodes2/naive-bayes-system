@extends('Layouts.Base')

@section('content')
    {{-- Header --}}
<x-base-header
    title="Rekomendasi Pencegahan"
    icon="fa-solid fa-virus"
/>
    {{-- Body --}}
    <x-base-body
        title="Data Rekomendasi Pencegahan"
        :button="['id' => 'btnTambahRekomendasi', 'label' => 'Tambah Daftar Rekomendasi',]"
    >
        <div class="py-0">
            {{-- Table --}}
            <x-base-table initId="rekomendasiTable" :columns="['No', 'Nama ', 'Deskripsi', 'Aksi']">
                <tbody>

                </tbody>
            </x-base-table>

        </div>
    </x-base-body>
    <x-base-form
        modalId="modalRekomendasi"
        modalLabelId="labelModaRekomendasi"
        title="Form Rekomendasi"
        formId="formRekomendasi"
        submitId="btnSimpanRekomendasi"
        submitText="Simpan Rekomendasi"
    >

        <input type="hidden" name="id" id="id" value="">

        <div class="form-group mb-3">
            <label for="judul">Nama</label>
            <input type="text" class="form-control" id="judul" name="judul"
                placeholder="Input here..">
            <small class="text-danger" id="judul-error"></small>
        </div>

        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"
                placeholder="Masukkan deskripsi gejala"></textarea>
            <small class="text-danger" id="deskripsi-error"></small>
        </div>

    </x-base-form>
@endsection
@section('scripts')
    <script type="module" src="{{ asset('js/controllers/rekomendasi.controller.js')}}"></script>
@endsection
