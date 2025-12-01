@extends('Layouts.Base')

@section('content')
    {{-- Header --}}
<x-base-header
    title="Data Gejala"
    icon="fa-solid fa-virus"
/>
    {{-- Body --}}
    <x-base-body
        title="Data Gejala Tanaman"
        :button="['id' => 'btnTambahGejala', 'label' => 'Tambah Daftar Gejala',]"
    >
        <div class="py-0">
            {{-- Table --}}
            <x-base-table initId="gejalaTable" :columns="['No', 'Kode Gejala', 'Kategori Gejala', 'Deskripsi', 'Aksi']">
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
            <label for="kode_gejala">Kode Gejala</label>
            <input type="text" class="form-control" id="kode_gejala" name="kode_gejala"
                placeholder="Contoh : G00x">
            <small class="text-danger" id="kode_gejala-error"></small>
        </div>
        <div class="form-group mb-3">
            <label for="ketagori">Kategori Gejala</label>
            <select name="kategori" id="kategori" class="form-control">
                <option value="" selected disabled>--pilih--</option>
                <option value="daun">Daun</option>
                <option value="buah">Buah</option>
                <option value="batang">Batang</option>
                <option value="akar">Akar</option>
                <option value="umum">Umum</option>
            </select>
            <small class="text-danger" id="ketagori-error"></small>
        </div>

        <div class="form-group mb-3">
            <label for="deskripsi_gejala">Deskripsi</label>
            <textarea class="form-control" id="deskripsi_gejala" name="deskripsi_gejala"
                placeholder="Masukkan deskripsi gejala"></textarea>
            <small class="text-danger" id="deskripsi_gejala-error"></small>
        </div>

    </x-base-form>
@endsection
@section('scripts')
    <script type="module" src="{{ asset('js/controllers/gejala.controller.js')}}"></script>
@endsection
