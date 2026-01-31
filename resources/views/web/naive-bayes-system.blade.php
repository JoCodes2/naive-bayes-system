<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CabaiSense Tadulako Pride - Diagnosa Perawatan Tanaman Cabai</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/assets/logonaivebayes.png') }}" />
    <script>
        let appUrl = '{{ env('APP_URL') }}';
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
        }

        .gradient-chili {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(34, 197, 94, 0.2), 0 10px 10px -5px rgba(34, 197, 94, 0.1);
        }

        .checkbox-custom {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #d1d5db;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .checkbox-custom:checked {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
            border-color: #22c55e;
        }

        .checkbox-custom:checked::after {
            content: '✓';
            display: block;
            text-align: center;
            color: white;
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .section-number {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.3);
        }

        /* Responsive section number */
        @media (max-width: 640px) {
            .section-number {
                width: 40px;
                height: 40px;
                font-size: 1.125rem;
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, #22c55e 0%, #15803d 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(34, 197, 94, 0.4);
        }

        .info-box {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.05) 0%, rgba(21, 128, 61, 0.05) 100%);
            border-left: 4px solid #22c55e;
        }

        /* Chili Plant Pattern Background */
        .chili-pattern {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(239, 68, 68, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
        }

        /* Leaf decoration */
        .leaf-decoration {
            position: relative;
        }

        .leaf-decoration::before {
            content: '🌿';
            position: absolute;
            font-size: 3rem;
            opacity: 0.1;
            left: -20px;
            top: -10px;
        }

        /* Hide leaf decoration on mobile */
        @media (max-width: 768px) {
            .leaf-decoration::before {
                display: none;
            }
        }

        /* Probability bar animation */
        .probability-bar {
            height: 8px;
            background: linear-gradient(90deg, #22c55e 0%, #15803d 100%);
            border-radius: 4px;
            transition: width 1s ease-out;
        }

        /* Algorithm flow */
        .algorithm-step {
            position: relative;
            padding-left: 2rem;
        }

        .algorithm-step::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 2rem;
            bottom: -1rem;
            width: 2px;
            background: linear-gradient(180deg, #22c55e 0%, transparent 100%);
        }

        .algorithm-step:last-child::before {
            display: none;
        }

        .step-dot {
            position: absolute;
            left: 0;
            top: 0.5rem;
            width: 1.5rem;
            height: 1.5rem;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Responsive sticky positioning */
        @media (max-width: 1023px) {
            .sticky-sidebar {
                position: static !important;
            }
        }

        /* Responsive header decorations */
        @media (max-width: 768px) {
            .header-cabai .absolute.text-6xl {
                font-size: 3rem;
            }

            .header-cabai .w-96.h-96 {
                width: 16rem;
                height: 16rem;
            }
        }

        /* Responsive padding and margins */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

    </style>


</head>
<body class="bg-gray-50 chili-pattern">
    <div class="gradient-bg header-cabai text-white py-5 sm:py-6 md:py-8 lg:py-10 relative overflow-hidden w-full left-0 right-0">

        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -ml-48 -mb-48 pointer-events-none"></div>

        <div class="absolute top-10 right-1/4 text-6xl opacity-10 pointer-events-none hidden sm:block">🌶️</div>
        <div class="absolute bottom-10 left-1/4 text-6xl opacity-10 pointer-events-none hidden sm:block">🌱</div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-block mb-4 sm:mb-6">
                    <div class="bg-white bg-opacity-20 rounded-full px-4 sm:px-6 py-1.5 sm:py-2 backdrop-blur-sm">
                        <span class="text-xs sm:text-sm font-semibold">
                            <i class="fas fa-brain mr-1 sm:mr-2"></i>Pure Naive Bayes Classification
                        </span>
                    </div>
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-3 sm:mb-4 float-animation px-2">
                    <i class="fas fa-pepper-hot mr-2 sm:mr-3 text-red-400"></i>CabaiSense Tadulako Pride
                </h1>

                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-green-100 font-light mb-1 sm:mb-2 px-2">
                    Sistem Rekomendasi Perawatan Tanaman Cabai
                </p>
                <p class="text-sm sm:text-base md:text-lg text-green-200 mb-4 sm:mb-6 md:mb-8 px-2">
                    Berbasis Algoritma Naive Bayes
                </p>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container mx-auto px-3 sm:px-4 -mt-6 sm:-mt-8 md:-mt-10 pb-12 sm:pb-16 md:pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">

            <!-- Form Area -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6  sticky">
                <form id="diagnosisForm" class="space-y-4 sm:space-y-6">
                    @csrf
                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 mb-4 sm:mb-6 card-hover border-l-4 sm:border-l-6 md:border-l-8 border-green-500">
                        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                            <div class="bg-green-100 w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                                <i class="fas fa-user-circle text-xl sm:text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">Profil Identitas</h2>
                                <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">Lengkapi nama untuk keperluan laporan diagnosa</p>
                            </div>
                        </div>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-green-600 text-gray-400">
                                <i class="fas fa-user text-sm sm:text-base"></i>
                            </div>
                            <input type="text"
                                name="nama_petani"
                                id="nama_petani"
                                required
                                class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 bg-gray-50 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent focus:bg-white outline-none transition-all duration-200 text-sm sm:text-base text-gray-700 placeholder-gray-400"
                                placeholder="Masukkan Nama Lengkap Petani...">
                        </div>
                    </div>

                    <!-- Section 1: Parameter Lingkungan -->
                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 card-hover leaf-decoration">
                        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                            <div class="section-number flex-shrink-0">1</div>
                            <div>
                                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">
                                    <i class="fas fa-cloud-sun text-green-600 mr-1 sm:mr-2"></i>Kondisi Lingkungan
                                </h2>
                                <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">Input data parameter lingkungan pertanian cabai</p>
                            </div>
                        </div>

                        <div id="environmentParams" class="grid grid-cols-1 gap-3 sm:gap-4">

                        </div>
                    </div>

                    <!-- Section 2: Gejala Tanaman -->
                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8 card-hover">
                        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                            <div class="section-number flex-shrink-0">2</div>
                            <div>
                                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">
                                    <i class="fas fa-stethoscope text-green-600 mr-1 sm:mr-2"></i>Gejala Visual Tanaman
                                </h2>
                                <p class="text-gray-500 text-xs sm:text-sm mt-0.5 sm:mt-1">Observasi gejala klinis pada tanaman cabai</p>
                            </div>
                        </div>

                        <div id="symptoms" class="space-y-2 sm:space-y-3">

                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full text-white font-semibold py-3 sm:py-4 px-6 sm:px-8 rounded-lg sm:rounded-xl text-base sm:text-lg shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>
                        <span class="hidden sm:inline">ANALISIS DENGAN NAIVE BAYES</span>
                        <span class="sm:hidden">ANALISIS NAIVE BAYES</span>
                    </button>

                </form>

                <!-- Container Hasil -->
                <div id="resultContainer" class="mt-6 sm:mt-8 hidden">
                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-6 md:p-8">
                        <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-xl sm:text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">Hasil Diagnosa</h3>
                                <p class="text-xs sm:text-sm text-gray-500">Berdasarkan kalkulasi Naive Bayes</p>
                            </div>
                        </div>

                        <div id="resultContent" class="space-y-3  sticky sm:space-y-4">
                            <!-- Hasil diagnosa akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky-sidebar sticky top-4 sm:top-6 md:top-8 space-y-4 sm:space-y-6">

                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-5 md:p-6 card-hover border-t-4 border-green-500">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 gradient-bg rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-brain text-white text-sm sm:text-base"></i>
                            </div>
                            <h3 class="font-bold text-base sm:text-lg text-gray-800">Logika Bayes</h3>
                        </div>

                        <p class="text-gray-600 text-xs mb-3 sm:mb-4">
                            Menghitung probabilitas penyakit ($H$) berdasarkan bukti Gejala ($G$) dan Lingkungan ($L$):
                        </p>

                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-3 sm:p-4 mb-3 sm:mb-4 border border-green-100 shadow-inner">
                            <div class="text-center mb-2">
                                <div class="font-mono text-xs font-bold text-green-800">
                                    P(H|G,L) =
                                </div>
                                <div class="border-t-2 border-green-300 my-1 mx-4"></div>
                                <div class="font-mono text-[10px] text-green-700">
                                    P(G|H) × P(L|H) × P(H)
                                </div>
                                <div class="border-t-2 border-green-300 my-1 mx-8"></div>
                                <div class="font-mono text-[10px] text-green-700">
                                    P(G,L)
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5 sm:space-y-2 text-[10px] sm:text-[11px] text-gray-600">
                            <div class="flex items-start gap-1.5 sm:gap-2">
                                <span class="font-bold text-green-700 flex-shrink-0">P(H|G,L):</span>
                                <span>Probabilitas akhir (Posterior)</span>
                            </div>
                            <div class="flex items-start gap-1.5 sm:gap-2">
                                <span class="font-bold text-green-700 flex-shrink-0">P(G|H):</span>
                                <span>Likelihood bukti Gejala</span>
                            </div>
                            <div class="flex items-start gap-1.5 sm:gap-2">
                                <span class="font-bold text-green-700 flex-shrink-0">P(L|H):</span>
                                <span>Likelihood bukti Lingkungan</span>
                            </div>
                            <div class="flex items-start gap-1.5 sm:gap-2">
                                <span class="font-bold text-green-700 flex-shrink-0">P(H):</span>
                                <span>Probabilitas penyakit (Prior)</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg p-4 sm:p-5 md:p-6 card-hover">
                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <i class="fas fa-project-diagram text-green-600 text-sm sm:text-base"></i>
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base">Alur Diagnosa</h3>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            <div class="algorithm-step">
                                <div class="step-dot">1</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-xs sm:text-sm text-gray-700">Koleksi Bukti</h4>
                                    <p class="text-[10px] sm:text-[11px] text-gray-500">Normalisasi input Gejala & Lingkungan</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">2</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-xs sm:text-sm text-gray-700">Hitung Likelihood</h4>
                                    <p class="text-[10px] sm:text-[11px] text-gray-500">Mencari frekuensi $P(G|H)$ dan $P(L|H)$</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">3</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-xs sm:text-sm text-gray-700">Integrasi Prior</h4>
                                    <p class="text-[10px] sm:text-[11px] text-gray-500">Kalikan nilai Likelihood dengan $P(H)$</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">4</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-xs sm:text-sm text-gray-700">Klasifikasi</h4>
                                    <p class="text-[10px] sm:text-[11px] text-gray-500">Mencari nilai Max Posterior (ArgMax)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-box rounded-xl sm:rounded-2xl p-4 sm:p-5 md:p-6">
                        <div class="flex items-center gap-2 mb-3 sm:mb-4">
                            <i class="fas fa-info-circle text-green-600 text-sm sm:text-base"></i>
                            <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Petunjuk Penggunaan</h3>
                        </div>

                        <ul class="space-y-2 sm:space-y-3 text-[10px] sm:text-[11px] text-gray-600">
                            <li class="flex items-start gap-1.5 sm:gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 sm:mt-1 flex-shrink-0"></i>
                                <span>Isi nama petani untuk keperluan laporan diagnosa.</span>
                            </li>
                            <li class="flex items-start gap-1.5 sm:gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 sm:mt-1 flex-shrink-0"></i>
                                <span>Pastikan minimal 2 parameter lingkungan diisi sesuai kondisi lahan.</span>
                            </li>
                            <li class="flex items-start gap-1.5 sm:gap-2">
                                <i class="fas fa-check-circle text-green-500 mt-0.5 sm:mt-1 flex-shrink-0"></i>
                                <span>Pilih minimal 2 gejala yang paling dominan terlihat.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-900 to-emerald-900 text-gray-300 py-6 sm:py-8">
        <div class="container mx-auto px-4">
            <div class="text-center mb-4 sm:mb-6">
                <div class="flex items-center justify-center gap-2 mb-2 sm:mb-3">
                    <i class="fas fa-pepper-hot text-red-400 text-xl sm:text-2xl"></i>
                    <span class="font-bold text-white text-lg sm:text-xl">CabaiSense Tadulako Pride</span>
                </div>
                <p class="text-xs sm:text-sm text-green-200 mb-1 sm:mb-2">Sistem Rekomendasi Perawatan Penyakit Tanaman Cabai</p>
                <p class="text-[10px] sm:text-xs">Powered by JoCodes</p>
            </div>

            <div class="border-t border-green-800 pt-3 sm:pt-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-2 sm:gap-4 text-[10px] sm:text-xs">
                    <div>
                        <p>© 2026 CabaiSense Tadulako Pride NB System By JoCodes. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
 <!-- build:js assets/vendor/js/core.js -->
 <script src="{{ asset('assets/assets/vendor/libs/jquery/jquery.js') }}"></script>
 <script src="{{ asset('assets/assets/vendor/libs/popper/popper.js') }}"></script>
 <script src="{{ asset('assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
     integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
     <script type="module" src="{{ asset('js/controllers/diagnosa-web.controller.js')}}"></script>
</body>
</html>
