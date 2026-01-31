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

        {{-- Ganti bagian row di dalam x-base-form --}}
        <div class="row">
            {{-- Seksi Gejala --}}
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-end mb-2 border-bottom pb-2">
                    <div>
                        <label class="fw-bold fs-5 text-success">
                            <i class="fas fa-leaf me-2"></i>Daftar Gejala Terkait
                        </label>
                        <p class="text-muted small mb-0">Pilih gejala yang muncul pada target penyakit ini</p>
                    </div>
                </div>

                <div class="card border-0 bg-light shadow-none">
                    <div class="card-body p-3" style="max-height: 350px; overflow-y: auto;" id="container-gejala">
                        {{-- Diisi via AJAX --}}
                    </div>
                </div>
                <small class="text-danger" id="gejala-error"></small>
            </div>

            {{-- Seksi Lingkungan --}}
            <div class="col-12">
                <div class="mb-2 border-bottom pb-2">
                    <label class="fw-bold fs-5 text-primary">
                        <i class="fas fa-microchip me-2"></i>Kondisi Lingkungan Ideal
                    </label>
                    <p class="text-muted small mb-0">Tentukan ambang batas lingkungan saat penyakit ini berkembang</p>
                </div>

                <div class="card border-0 bg-light shadow-none">
                    <div class="card-body p-3" id="container-lingkungan">
                        {{-- Diisi via AJAX --}}
                    </div>
                </div>
                <small class="text-danger" id="lingkungan-error"></small>
            </div>
        </div>

    </x-base-form>
@endsection

@section('scripts')
    <script type="module" src="{{ asset('js/controllers/data-set.controller.js')}}"></script>
@endsection
