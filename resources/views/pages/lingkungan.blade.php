@extends('Layouts.Base')

@section('content')
    {{-- Header --}}
<x-base-header
    title="Kondisi Lingkungan"
    icon="fa-solid fa-hand-holding-droplet"
/>
    {{-- Body --}}
    <x-base-body
        title="Data Kondisi Lingkungan"
        :button="['id' => 'btnTambahParameter', 'label' => 'Tambah Daftar Kondisi Lingkungan',]"
    >
        <div class="py-0">
            {{-- Table --}}
            <x-base-table initId="parameterTable" :columns="['No', 'Nama Parameter','Satuan','Kategori','Nilai Ideal Min','Nilai Ideal Max', 'Deskripsi', 'Aksi']">
                <tbody>

                </tbody>
            </x-base-table>

        </div>
    </x-base-body>
    <x-base-form
        modalId="modalParameter"
        modalLabelId="labelModaParameter"
        title="Form Parameter Lingkungan"
        formId="formParameter"
        submitText="Simpan Parameter"
        submitId="btnSimpanParameter"
    >

        <input type="hidden" name="id" id="id" value="">

        {{-- Nama Parameter --}}
        <div class="form-group mb-3">
            <label for="nama_parameter">Nama Parameter</label>
            <input type="text" class="form-control" id="nama_parameter" name="nama_parameter"
                placeholder="Masukkan nama parameter">
            <small class="text-danger" id="nama_parameter-error"></small>
        </div>

        {{-- Satuan --}}
        <div class="form-group mb-3">
            <label for="satuan">Satuan</label>
            <input type="text" class="form-control" id="satuan" name="satuan"
                placeholder="Contoh: mg/L, °C, Lux, ppm">
            <small class="text-danger" id="satuan-error"></small>
        </div>

        {{-- Kategori --}}
        <div class="form-group mb-3">
            <label for="kategori">Kategori</label>
            <select class="form-control" id="kategori" name="kategori">
                <option value="">-- Pilih Kategori --</option>
                <option value="air">Air</option>
                <option value="tanah">Tanah</option>
                <option value="cahaya">Cahaya</option>
                <option value="udara">Udara</option>
            </select>
            <small class="text-danger" id="kategori-error"></small>
        </div>

        {{-- Nilai Ideal Minimal --}}
        <div class="form-group mb-3">
            <label for="nilai_ideal_min">Nilai Ideal Minimal</label>
            <input type="number" step="0.01" class="form-control" id="nilai_ideal_min" name="nilai_ideal_min"
                placeholder="Masukkan nilai ideal minimum">
            <small class="text-danger" id="nilai_ideal_min-error"></small>
        </div>

        {{-- Nilai Ideal Maksimal --}}
        <div class="form-group mb-3">
            <label for="nilai_ideal_max">Nilai Ideal Maksimal</label>
            <input type="number" step="0.01" class="form-control" id="nilai_ideal_max" name="nilai_ideal_max"
                placeholder="Masukkan nilai ideal maksimum">
            <small class="text-danger" id="nilai_ideal_max-error"></small>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi"
                placeholder="Masukkan deskripsi parameter"></textarea>
            <small class="text-danger" id="deskripsi-error"></small>
        </div>

    </x-base-form>

@endsection
@section('scripts')
    <script type="module" src="{{ asset('js/controllers/parameter.controller.js')}}"></script>
@endsection
