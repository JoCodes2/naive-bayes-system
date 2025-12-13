@extends('Layouts.Base')

@section('content')
    <div class="page-inner">

        <!-- Header -->
        <div class="page-header">
            <h4 class="page-title">
                <i class="fas fa-seedling me-2"></i>Diagnosa Penyakit Tanaman
            </h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Diagnosa Tanaman</h5>
                    </div>

                    <div class="card-body">
                        <form id="formDiagnosaTanaman">

                            <!-- Kondisi Lingkungan -->
                            <div class="card mb-4">
                                <div class="card-header fw-bold">
                                    <i class="fas fa-cloud-sun me-1"></i> Kondisi Lingkungan
                                </div>

                                <div class="card-body row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">pH Tanah</label>
                                        <input type="number" step="0.1" name="ph_tanah" class="form-control"
                                            placeholder="Masukkan nilai pH tanah">
                                        <small class="text-muted">Ideal: 5.5 – 6.8</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Intensitas Cahaya (Lux)</label>
                                        <input type="number" name="intensitas_cahaya" class="form-control"
                                            placeholder="Masukkan intensitas cahaya">
                                        <small class="text-muted">Ideal: 25.000 – 50.000 lux</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Curah Hujan (mm/hari)</label>
                                        <input type="number" step="0.1" name="curah_hujan" class="form-control"
                                            placeholder="Masukkan curah hujan">
                                        <small class="text-muted">Ideal: 2 – 5 mm/hari</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Kelembapan Tanah (%)</label>
                                        <input type="number" step="0.1" name="kelembapan_tanah" class="form-control"
                                            placeholder="Masukkan kelembapan tanah">
                                        <small class="text-muted">Ideal: 50 – 70 %</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Kelembapan Udara (%)</label>
                                        <input type="number" step="0.1" name="kelembapan_udara" class="form-control"
                                            placeholder="Masukkan kelembapan udara">
                                        <small class="text-muted">Ideal: 60 – 80 %</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Suhu Tanah (°C)</label>
                                        <input type="number" step="0.1" name="suhu_tanah" class="form-control"
                                            placeholder="Masukkan suhu tanah">
                                        <small class="text-muted">Ideal: 22 – 28 °C</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Suhu Udara (°C)</label>
                                        <input type="number" step="0.1" name="suhu_udara" class="form-control"
                                            placeholder="Masukkan suhu udara">
                                        <small class="text-muted">Ideal: 24 – 30 °C</small>
                                    </div>

                                </div>
                            </div>

                            <!-- Gejala Tanaman -->
                            <div class="card mb-4">
                                <div class="card-header fw-bold">
                                    <i class="fas fa-leaf me-1"></i> Gejala Tanaman
                                </div>

                                <div class="card-body row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Daun Menguning</label>
                                        <select name="daun_menguning" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Bercak pada Daun</label>
                                        <select name="bercak_daun" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Batang Busuk</label>
                                        <select name="batang_busuk" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Pertumbuhan Terhambat</label>
                                        <select name="pertumbuhan_terhambat" class="form-control">
                                            <option value="">-- Pilih --</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="text-end">
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <button type="button" id="btnDiagnosa" class="btn btn-success">
                                    <i class="fas fa-search"></i> Proses Diagnosa
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
