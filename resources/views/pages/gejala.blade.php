@extends('Layouts.Base')

@section('content')

<div class="card">

    {{-- Header --}}
    <x-base-header
        title="Data Gejala"
        icon="fa-solid fa-virus"
        :button="['id' => 'btnTambahGejala', 'label' => 'Tambah Daftar Gejala',]"
    />

    {{-- Body --}}
    <x-base-body>
        <div class="py-3">
            <h6>Daftar Gejala Tanaman</h6>

            {{-- Table --}}
            <x-base-table initId="gejalaTable" :columns="['No', 'Nama Gejala', 'Deskripsi', 'Aksi']">
                <tbody>

                </tbody>
            </x-base-table>

        </div>
    </x-base-body>
    <x-base-form
        modalId="modalGejala"
        modalLabelId="labelModalGejala"
        title="Form Gejala"
        formId="formGejala"
        submitId="btnSimpanGejala"
        submitText="Simpan Gejala"
    >

        <input type="hidden" name="id" id="id" value="">

        <div class="form-group mb-3">
            <label for="nama">Nama Gejala</label>
            <input type="text" class="form-control" id="nama" name="nama"
                placeholder="Masukkan nama gejala">
            <small class="text-danger" id="nama-error"></small>
        </div>

        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"
                placeholder="Masukkan deskripsi gejala"></textarea>
            <small class="text-danger" id="deskripsi-error"></small>
        </div>

    </x-base-form>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('helper/helper.js') }}"></script>
    <script type="module" src="{{ asset('js/controllers/gejala.controller.js')}}"></script>
@endsection
