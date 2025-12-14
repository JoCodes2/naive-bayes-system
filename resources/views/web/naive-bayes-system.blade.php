<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Diagnosa Tanaman Cabai</title>

    <meta name="description" content="Formulir Diagnosa Penyakit Cabai dengan Naive Bayes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/assets/logonaivebayes.png') }}" />

    <script>
        let appUrl = '{{ env('APP_URL') }}';
    </script>
    {{-- Tailwind CSS & Font Awesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Libraries --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
     integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f3f4f6;
        }
        /* Styling untuk pesan error jQuery Validate */
        .text-red-600 {
            color: #dc2626;
        }
    </style>
</head>
<body>

<div class="container mx-auto px-4 py-12 max-w-5xl">

    {{-- Header Area --}}
    <div class="bg-white shadow-xl rounded-xl p-6 mb-8 border-t-4 border-blue-600">
        <header>
            <h1 class="text-3xl font-extrabold text-gray-900 flex items-center">
                <i class="fas fa-stethoscope text-blue-600 mr-3 text-2xl"></i>
                Diagnosis Penyakit Tanaman Cabai
            </h1>
        </header>
    </div>

    {{-- Deskripsi Sistem --}}
    <div class="bg-white shadow-md rounded-xl p-6 mb-8 border-l-4 border-yellow-500">
        <h3 class="text-xl font-bold text-gray-800 mb-3 flex items-center">
            <i class="fas fa-microchip text-yellow-500 mr-2"></i> Mengenal Sistem Diagnosis
        </h3>
        <p class="text-gray-600 mb-3">
            Formulir ini dirancang untuk membantu petani mendiagnosa penyakit pada tanaman cabai menggunakan sistem pakar.
        </p>
        <div class="p-4 bg-yellow-50 rounded-lg">
            <p class="text-sm font-semibold text-gray-700">Algoritma Naive Bayes</p>
        </div>
    </div>


    {{-- Body Area / Main Content --}}
    <div class="bg-white shadow-xl rounded-xl p-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6 border-b pb-3">Formulir Input Data</h2>

        <div class="py-3">
            {{-- Alert Area (SweetAlert) --}}

            {{-- Form Diagnosa --}}
            <form id="diagnosaForm">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                {{-- 1. Kondisi Lingkungan --}}
                <section class="bg-white border border-gray-200 rounded-lg mb-6 shadow-md transition duration-300 hover:shadow-lg">
                    <div class="p-4 bg-gray-100 rounded-t-lg border-b">
                        <h5 class="text-xl font-medium text-gray-800 flex items-center">
                            <i class="fas fa-temperature-half text-indigo-500 mr-3"></i>1. Kondisi Lingkungan
                        </h5>
                    </div>
                    <div class="p-6">
                        <div id="kondisiLingkunganForm">
                            {{-- Loading State Awal (Akan diganti oleh Controller) --}}
                            <div class="flex flex-col items-center justify-center h-24">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
                                <p class="mt-3 text-sm text-gray-500">Memuat data parameter lingkungan...</p>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 2. Gejala Tanaman --}}
                <section class="bg-white border border-gray-200 rounded-lg mb-8 shadow-md transition duration-300 hover:shadow-lg">
                    <div class="p-4 bg-gray-100 rounded-t-lg border-b">
                        <h5 class="text-xl font-medium text-gray-800 flex items-center">
                            <i class="fas fa-leaf text-green-600 mr-3"></i>2. Gejala Tanaman
                        </h5>
                    </div>
                    <div class="p-6">
                        <div id="gejalaList" class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4">
                            {{-- Loading State Awal (Akan diganti oleh Controller) --}}
                            <div class="col-span-full flex flex-col items-center justify-center h-24">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500"></div>
                                <p class="mt-3 text-sm text-gray-500">Memuat data gejala...</p>
                            </div>
                        </div>
                        <div class="mt-6 border-t pt-4">
                            <p class="text-xs text-gray-500">Pilih satu atau lebih gejala yang ditemukan pada tanaman cabai Anda</p>
                        </div>
                    </div>
                </section>

                {{-- Submit Button --}}
                <div class="text-center mt-8">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3 px-16 rounded-full shadow-xl transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submitBtn"
                    >
                        <i class="fas fa-stethoscope mr-2"></i>Lakukan Diagnosa
                    </button>
                </div>
            </form>

            {{-- Loading Spinner Saat Proses Diagnosa --}}
            <div id="loadingSpinner" class="text-center py-10 hidden">
                <div class="flex flex-col items-center justify-center">
                    <div class="animate-ping rounded-full h-4 w-4 bg-blue-500 mb-2"></div>
                    <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-blue-600"></div>
                    <p class="mt-4 text-gray-600 font-medium">Sedang memproses diagnosa...</p>
                </div>
            </div>

            {{-- Hasil Diagnosa --}}
            <div id="hasilDiagnosa" class="mt-12 hidden">
                {{-- Will be filled by JavaScript --}}
            </div>
        </div>
    </div>
</div>


{{-- Global Helper Functions --}}
<script>
    function successAlert(message) {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: message });
    }
    function errorAlert(message) {
        Swal.fire({ icon: 'error', title: 'Gagal', text: message });
    }
</script>

{{-- File JavaScript Kustom --}}
{{-- PENTING: Pastikan jalur file di bawah ini benar sesuai struktur proyek Anda --}}
<script src="{{ asset('js/services/diagnosa-web.service.js') }}"></script>
<script src="{{ asset('js/controllers/diagnosa-web.controller.js') }}"></script>

<script>
$(document).ready(function() {
    // Inisialisasi Controller
    const service = new DiagnosaServiceWeb(appUrl);
    const controller = new DiagnosaControllerWeb(service);
    controller.init();
});
</script>
</body>
</html>
