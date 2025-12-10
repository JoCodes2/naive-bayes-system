@extends('Layouts.Base')

@section('content')
{{-- Header --}}
<x-base-header
    title="Diagnosa Tanaman"
    icon="fa-solid fa-stethoscope"
/>

{{-- Body --}}
<x-base-body
    title="Form Diagnosa Tanaman"
>
    <div class="py-3">
        {{-- Alert Area --}}
        <div id="alertArea" class="mb-4"></div>

        {{-- Form Diagnosa --}}
        <form id="diagnosaForm">
            @csrf

            {{-- Kondisi Lingkungan --}}
            <div class="card mb-4">
                <div class="card-header bg-light ">
                    <h5 class="mb-0"><i class="fas fa-temperature-half me-2"></i>Kondisi Lingkungan</h5>
                </div>
                <div class="card-body">
                    <div id="kondisiLingkunganForm">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat data parameter lingkungan...</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Gejala Tanaman --}}
            <div class="card mb-4">
                <div class="card-header bg-light ">
                    <h5 class="mb-0"><i class="fas fa-leaf me-2"></i>Gejala Tanaman</h5>
                </div>
                <div class="card-body">
                    <div id="gejalaList">
                        <div class="text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat data gejala...</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">Pilih satu atau lebih gejala yang ditemukan pada tanaman cabai Anda</small>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg btn-primary px-5" id="submitBtn">
                    <i class="fas fa-stethoscope me-2"></i>Lakukan Diagnosa
                </button>
            </div>
        </form>

        {{-- Loading Spinner --}}
        <div id="loadingSpinner" class="text-center d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Sedang memproses diagnosa...</p>
        </div>

        {{-- Hasil Diagnosa --}}
        <div id="hasilDiagnosa" class="mt-4 d-none">
            {{-- Will be filled by JavaScript --}}
        </div>
    </div>
</x-base-body>
@endsection

@section('scripts')
<script src="{{ asset('js/services/diagnosa.service.js') }}"></script>
<script src="{{ asset('js/controllers/diagnosa.controller.js') }}"></script>
<script>
$(document).ready(function() {
    const baseUrl = '{{ url("/") }}';
    const service = new DiagnosaService(baseUrl);
    const controller = new DiagnosaController(service);

    controller.init();
});
</script>
@endsection
