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
        :button="['id' => 'btnTambahParameter', 'label' => 'Tambah Kondisi Lingkungan']"
    >
        <div class="py-0">
            {{-- Table --}}
            <x-base-table initId="parameterTable" :columns="['No', 'Nama Parameter', 'Satuan', 'Label (Kategori)', 'Min Value', 'Max Value', 'Aksi']">
                <tbody id="tBody">
                    {{-- Data diisi via AJAX --}}
                </tbody>
            </x-base-table>
        </div>
    </x-base-body>

    {{-- Form Modal --}}
    <x-base-form
        modalId="modalParameter"
        modalLabelId="labelModaParameter"
        title="Form Parameter Lingkungan"
        formId="formParameter"
        submitText="Simpan Parameter"
        submitId="btnSimpanParameter"
    >
        <input type="hidden" name="id" id="id">

        <div class="row">
            {{-- Nama Parameter --}}
            <div class="col-md-8 form-group mb-3">
                <label for="nama_parameter">Nama Parameter</label>
                <input type="text" class="form-control" id="nama_parameter" name="nama_parameter"
                    placeholder="Contoh: Suhu Udara, pH Tanah">
                <small class="text-danger" id="nama_parameter-error"></small>
            </div>

            {{-- Satuan --}}
            <div class="col-md-4 form-group mb-3">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan"
                    placeholder="°C, %, Lux">
                <small class="text-danger" id="satuan-error"></small>
            </div>
        </div>

        {{-- Nilai Label (Diskritisasi) --}}
        <div class="form-group mb-3">
            <label for="nilai_label">Label Kondisi</label>
            <select class="form-control" id="nilai_label" name="nilai_label">
                <option value="">-- Pilih Label --</option>
                <option value="rendah">Rendah</option>
                <option value="normal">Normal</option>
                <option value="tinggi">Tinggi</option>
            </select>
            <small class="text-danger" id="nilai_label-error"></small>
        </div>

        <div class="row">
            {{-- Min Value --}}
            <div class="col-md-6 form-group mb-3">
                <label for="min_value">Batas Minimum Value</label>
                <input type="number" step="0.01" class="form-control" id="min_value" name="min_value"
                    placeholder="0.00">
                <small class="text-danger" id="min_value-error"></small>
            </div>

            {{-- Max Value --}}
            <div class="col-md-6 form-group mb-3">
                <label for="max_value">Batas Maksimum Value</label>
                <input type="number" step="0.01" class="form-control" id="max_value" name="max_value"
                    placeholder="0.00">
                <small class="text-danger" id="max_value-error"></small>
            </div>
        </div>

    </x-base-form>
@endsection

@section('scripts')
    <script type="module" src="{{ asset('js/controllers/parameter.controller.js')}}"></script>
@endsection
