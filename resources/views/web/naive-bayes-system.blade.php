<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChiliGuard - Diagnosa Kesehatan Tanaman Cabai</title>
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
    </style>
</head>
<body class="bg-gray-50 chili-pattern">

    <!-- Hero Section -->
    <div class="gradient-bg text-white py-20 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white opacity-5 rounded-full -ml-48 -mb-48"></div>
        <div class="absolute top-10 right-1/4 text-6xl opacity-10">🌶️</div>
        <div class="absolute bottom-10 left-1/4 text-6xl opacity-10">🌱</div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-block mb-6">
                    <div class="bg-white bg-opacity-20 rounded-full px-6 py-2 backdrop-blur-sm">
                        <span class="text-sm font-semibold">
                            <i class="fas fa-brain mr-2"></i>Pure Naive Bayes Classification
                        </span>
                    </div>
                </div>

                <h1 class="text-5xl md:text-6xl font-bold mb-4 float-animation">
                    <i class="fas fa-pepper-hot mr-3 text-red-400"></i>ChiliGuard
                </h1>

                <p class="text-xl md:text-2xl text-green-100 font-light mb-2">
                    Sistem Rekomendasi Perawatan  Tanaman Cabai
                </p>
                <p class="text-md text-green-200 mb-8">
                    Berbasis Algoritma Naive Bayes
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-10 pb-20">
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Form Area -->
            <div class="lg:col-span-2">
                <form id="diagnosisForm" class="space-y-6">
                    @csrf

                    <!-- Section 1: Parameter Lingkungan -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 card-hover leaf-decoration">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="section-number">1</div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">
                                    <i class="fas fa-cloud-sun text-green-600 mr-2"></i>Kondisi Lingkungan
                                </h2>
                                <p class="text-gray-500 text-sm mt-1">Input data parameter lingkungan pertanian cabai</p>
                            </div>
                        </div>

                        <div id="environmentParams" class="grid md:grid-cols-2 gap-4">

                        </div>
                    </div>

                    <!-- Section 2: Gejala Tanaman -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 card-hover">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="section-number">2</div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">
                                    <i class="fas fa-stethoscope text-green-600 mr-2"></i>Gejala Visual Tanaman
                                </h2>
                                <p class="text-gray-500 text-sm mt-1">Observasi gejala klinis pada tanaman cabai</p>
                            </div>
                        </div>

                        <div id="symptoms" class="space-y-3">

                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full text-white font-semibold py-4 px-8 rounded-xl text-lg shadow-lg">
                        <i class="fas fa-calculator mr-2"></i>
                        ANALISIS DENGAN NAIVE BAYES
                    </button>

                </form>

                <!-- Container Hasil -->
                <div id="resultContainer" class="mt-8 hidden">
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">Hasil Diagnosa</h3>
                                <p class="text-sm text-gray-500">Berdasarkan kalkulasi Naive Bayes</p>
                            </div>
                        </div>

                        <div id="resultContent" class="space-y-4">
                            <!-- Hasil diagnosa akan ditampilkan di sini -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-8 space-y-6">

                    <!-- Naive Bayes Method -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                                <i class="fas fa-brain text-white"></i>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">Algoritma Naive Bayes</h3>
                        </div>

                        <p class="text-gray-600 text-sm mb-4">
                            Teorema probabilitas untuk klasifikasi penyakit:
                        </p>

                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4 mb-4 border-2 border-green-200">
                            <div class="text-center mb-2">
                                <div class="font-mono text-sm font-semibold text-green-800">
                                    P(Penyakit|Gejala) =
                                </div>
                                <div class="border-t-2 border-green-300 my-2"></div>
                                <div class="font-mono text-xs text-green-700">
                                    P(Gejala|Penyakit) × P(Penyakit)
                                </div>
                                <div class="border-t-2 border-green-300 my-1 mx-8"></div>
                                <div class="font-mono text-xs text-green-700">
                                    P(Gejala)
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs text-gray-600">
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-green-700">P(Penyakit|Gejala):</span>
                                <span>Probabilitas posterior</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-green-700">P(Gejala|Penyakit):</span>
                                <span>Likelihood evidence</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="font-semibold text-green-700">P(Penyakit):</span>
                                <span>Prior probability</span>
                            </div>
                        </div>
                    </div>

                    <!-- Algorithm Flow -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 card-hover">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-project-diagram text-green-600"></i>
                            <h3 class="font-bold text-gray-800">Alur Diagnosa</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="algorithm-step">
                                <div class="step-dot">1</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-sm text-gray-700">Input Evidence</h4>
                                    <p class="text-xs text-gray-500">Gejala & lingkungan</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">2</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-sm text-gray-700">Hitung Likelihood</h4>
                                    <p class="text-xs text-gray-500">P(E|H) per penyakit</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">3</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-sm text-gray-700">Kalikan Prior</h4>
                                    <p class="text-xs text-gray-500">P(H) dari dataset</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">4</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-sm text-gray-700">Normalisasi</h4>
                                    <p class="text-xs text-gray-500">Bagi dengan P(E)</p>
                                </div>
                            </div>

                            <div class="algorithm-step">
                                <div class="step-dot">5</div>
                                <div class="pl-6">
                                    <h4 class="font-semibold text-sm text-gray-700">Pilih Max</h4>
                                    <p class="text-xs text-gray-500">Probabilitas tertinggi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Petunjuk -->
                    <div class="info-box rounded-2xl p-6">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fas fa-info-circle text-green-600"></i>
                            <h3 class="font-bold text-gray-800">Petunjuk Penggunaan</h3>
                        </div>

                        <ul class="space-y-3 text-sm text-gray-600">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Centang minimal 1 kondisi lingkungan aktual</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Pilih 2-5 gejala yang paling dominan terlihat</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Sistem akan menghitung probabilitas tiap penyakit</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <span>Hasil dengan confidence > 60% dianggap valid</span>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-green-900 to-emerald-900 text-gray-300 py-8">
        <div class="container mx-auto px-4">
            <div class="text-center mb-6">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <i class="fas fa-pepper-hot text-red-400 text-2xl"></i>
                    <span class="font-bold text-white text-xl">ChiliGuard</span>
                </div>
                <p class="text-sm text-green-200 mb-2">Sistem Pakar Diagnosa Penyakit Tanaman Cabai</p>
                <p class="text-xs">Powered by JoCodes</p>
            </div>

            <div class="border-t border-green-800 pt-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs">
                    <div>
                        <p>© 2026 ChiliGuard NB System By JoCodes. All rights reserved.</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-white transition flex items-center gap-1">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                        <a href="#" class="hover:text-white transition flex items-center gap-1">
                            <i class="fas fa-book"></i> Dokumentasi
                        </a>
                        <a href="#" class="hover:text-white transition flex items-center gap-1">
                            <i class="fas fa-envelope"></i> Kontak
                        </a>
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
     <script type="module" src="{{ asset('js/controllers/diagnosa-web.controller.js')}}"></script>
</body>
</html>
