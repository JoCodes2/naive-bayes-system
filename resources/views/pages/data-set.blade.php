@extends('Layouts.Base')

@section('content')
    {{-- Header --}}
    <x-base-header
        title="Dataset Training"
        icon="fa-solid fa-database"
    />

    {{-- Body --}}
    <x-base-body
        title="Daftar Knowledge Base (Dataset)"
        :button="['id' => 'btnTambahDataset', 'label' => 'Tambah Dataset Baru']"
    >
        <div class="py-0">
            {{-- Table --}}
            <x-base-table initId="datasetTable" :columns="['No', 'Penyakit', 'Gejala', 'Kondisi Lingkungan', 'Aksi']">
                <tbody id="tBody">
                    {{-- Diisi via AJAX --}}
                </tbody>
            </x-base-table>
        </div>
    </x-base-body>

    {{-- Form Modal --}}
    <x-base-form
        modalId="modalDataset"
        modalLabelId="labelModalDataset"
        title="Form Dataset Training"
        formId="formDataset"
        submitId="btnSimpanDataset"
        submitText="Simpan Dataset"
    >
        <input type="hidden" name="id" id="id" value="">

        {{-- Pilih Penyakit --}}
        <div class="form-group mb-4">
            <label for="penyakit_id" class="fw-bold">Target Penyakit</label>
            <select name="penyakit_id" id="penyakit_id" class="form-control select2-single">
                <option value="" selected disabled>-- Pilih Penyakit --</option>
                {{-- Diisi via AJAX dari Master Penyakit --}}
            </select>
            <small class="text-danger" id="penyakit_id-error"></small>
        </div>

        <div class="row">
            {{-- Pilih Gejala --}}
            <div class="col-md-6">
                <label class="fw-bold mb-2">Daftar Gejala Terkait</label>
                <div class="card border p-3" style="max-height: 300px; overflow-y: auto;" id="container-gejala">
                    {{-- Checkbox gejala diisi via AJAX --}}
                    <div class="text-muted small">Memuat data gejala...</div>
                </div>
                <small class="text-danger" id="gejala-error"></small>
            </div>

            {{-- Pilih Lingkungan --}}
            <div class="col-md-6">
                <label class="fw-bold mb-2">Kondisi Lingkungan Terkait</label>
                <div class="card border p-3" style="max-height: 300px; overflow-y: auto;" id="container-lingkungan">
                    {{-- Checkbox lingkungan diisi via AJAX --}}
                    <div class="text-muted small">Memuat data lingkungan...</div>
                </div>
                <small class="text-danger" id="lingkungan-error"></small>
            </div>
        </div>

    </x-base-form>
@endsection

@section('scripts')
    <script type="module" src="{{ asset('js/controllers/data-set.controller.js')}}"></script>

<style>
    /* Merapikan daftar checkbox */
    .form-check {
        display: flex;
        align-items: flex-start;
        padding-left: 0;
        margin-bottom: 8px;
        position: relative;
    }

    .form-check-input {
        margin-top: 4px;
        margin-right: 10px;
        position: relative;
        margin-left: 0;
    }

    .form-check-label {
        line-height: 1.4;
        cursor: pointer;
        display: block;
    }

    /* Memastikan pesan error tidak merusak layout checkbox */
    #gejala-error, #lingkungan-error {
        display: block;
        margin-top: 5px;
        font-weight: bold;
    }

    /* Menghilangkan ikon error bawaan jika ada yang menumpuk */
    .form-check .error {
        display: none !important;
    }
</style>
@endsection
