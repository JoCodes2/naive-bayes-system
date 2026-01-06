@extends('Layouts.Base')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><i class="fas fa-book-dead pr-2"></i>Aturan Penyakit Lingkungan</h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light border-left-primary shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="mr-3">
                                <i class="fas fa-info-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-1">Panduan Pengisian Aturan Naive Bayes</h6>
                                <p class="small mb-0 text-muted">
                                    Gunakan skala bobot berikut untuk menentukan probabilitas hubungan antara penyakit dengan faktor lingkungan/gejala:
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body p-3 text-center">
                                        <h2 class="font-weight-bold text-danger mb-1">0.8 - 1.0</h2>
                                        <span class="badge badge-danger px-3 py-2 mb-2 text-dark">Sangat Kuat</span>
                                        <p class="small text-muted mb-0">Faktor utama yang hampir selalu menyebabkan penyakit muncul.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body p-3 text-center">
                                        <h2 class="font-weight-bold text-warning mb-1">0.4 - 0.7</h2>
                                        <span class="badge badge-warning px-3 py-2 mb-2 text-dark">Sedang</span>
                                        <p class="small text-muted mb-0">Faktor pendukung yang sering ditemukan pada kasus penyakit ini.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body p-3 text-center">
                                        <h2 class="font-weight-bold text-info mb-1">0.1 - 0.3</h2>
                                        <span class="badge badge-info px-3 py-2 mb-2 text-dark">Lemah</span>
                                        <p class="small text-muted mb-0">Faktor kecil yang sesekali muncul namun tidak dominan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 text-right">
                            <small class="text-danger italic font-weight-bold">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Hindari mengisi bobot dengan angka 0 karena akan merusak perhitungan Naive Bayes.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">DAFTAR ATURAN PENYAKIT LINGKUNGAN</h5>
                        <button class="btn btn-primary btn-sm" id="myBtn">
                            <i class="fas fa-plus"></i> Tambah Aturan
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="dataAturanPenyakit" class="table table-borderless table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Penyakit</th>
                                        <th>Parameter</th>
                                        <th>Kondisi</th>
                                        <th>Bobot</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="upsertDataModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="upsertDataForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Aturan Parameter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id" name="id">

                        <!-- PENYAKIT -->
                        <div class="mb-3">
                            <label for="penyakit_id" class="form-label">Penyakit</label>
                            <select class="form-control" name="penyakit_id" id="penyakit_id">
                                <option value="">-- Pilih Penyakit --</option>
                                <!-- data nanti di-load dari backend -->
                            </select>
                            <small id="penyakit_id-error" class="text-danger"></small>
                        </div>

                        <!-- PARAMETER -->
                        <div class="mb-3">
                            <label for="parameter_id" class="form-label">Parameter Lingkungan</label>
                            <select class="form-control" name="parameter_id" id="parameter_id">
                                <option value="">-- Pilih Parameter --</option>
                                <!-- data nanti di-load dari backend -->
                            </select>
                            <small id="parameter_id-error" class="text-danger"></small>
                        </div>

                        <!-- KONDISI -->
                       <div class="mb-3">
                            <label for="kondisi" class="form-label">Kondisi Parameter</label>
                            <select class="form-select @error('kondisi') is-invalid @enderror" name="kondisi" id="kondisi">
                                <option value="" selected disabled>-- Pilih Kondisi --</option>
                                <option value="rendah">Rendah</option>
                                <option value="normal">Normal / Baik</option>
                                <option value="tinggi">Tinggi</option>
                            </select>
                        </div>

                        <!-- BOBOT -->
                        <div class="mb-3">
                            <label for="bobot_pengaruh">Bobot(0.1 - 1)</label>
                            <input type="number" step="0.1" min="0.1" max="1" class="form-control"
                                name="bobot_pengaruh" id="bobot_pengaruh" placeholder="Masukkan bobot_pengaruh">
                            <small id="bobot_pengaruh-error" class="text-danger"></small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="simpanData" class="btn btn-primary">Simpan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            function loadPenyakit() {
                $.get('/naive-bayes/penyakit', function(res) {
                    $("#penyakit_id").empty().append('<option value="">-- Pilih Penyakit --</option>');
                    $.each(res.data, function(i, item) {
                        $("#penyakit_id").append(
                            `<option value="${item.id}">${item.nama_penyakit}</option>`);
                    });
                });
            }

            function loadParameter() {
                $.get('/naive-bayes/parameter-lingkungan', function(res) {
                    $("#parameter_id").empty().append('<option value="">-- Pilih Parameter --</option>');
                    $.each(res.data, function(i, item) {
                        $("#parameter_id").append(
                            `<option value="${item.id}">${item.nama_parameter}</option>`
                        );
                    });
                });
            }


            // panggil saat modal dibuka
            $("#myBtn, #editBtn").on("click", function() {
                loadPenyakit();
                loadParameter();
            });

            function getData() {
                $.ajax({
                    url: `/naive-bayes/aturan-penyakit/`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        let userData = response.data;

                        let tableBody = "";
                        if (userData.length > 0) {
                            $.each(userData, function(index, item) {
                                tableBody += "<tr>";
                                tableBody += "<td>" + (index + 1) + "</td>";

                                tableBody += "<td>" + (item.penyakit?.nama_penyakit || '-') +
                                    "</td>";
                                tableBody += "<td>" + (item.parameter?.nama_parameter || '-') +
                                    "</td>";
                                tableBody += "<td>" + (item.kondisi || '-') + "</td>";
                                tableBody += "<td>" + (item.bobot_pengaruh || '-') + "</td>";

                                tableBody += "<td>";
                                tableBody += `
                                                        <div class="d-flex gap-2">
                                                            <a href="#" class="edit-btn" data-id="${item.id}" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                            <a href="#" class="delete-confirm" data-id="${item.id}" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>`;

                                tableBody += "</td>";
                                tableBody += "</tr>";
                            });
                        }

                        $("#tBody").html(tableBody);

                        // Inisialisasi DataTable
                        $('#dataAturanPenyakit').DataTable({
                            destroy: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            order: [],
                            language: {
                                emptyTable: "Tidak ada data yang tersedia"
                            }
                        });
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                    }
                });
            }

            getData();

            // create
            $(document).on('click', '#simpanData', function(e) {
                $('.text-danger').text('');
                e.preventDefault();

                let id = $('#id').val();
                let formData = new FormData($('#upsertDataForm')[0]);
                let url = id ? `/naive-bayes/aturan-penyakit/update/${id}` :
                    '/naive-bayes/aturan-penyakit/create';
                let method = id ? 'POST' : 'POST';

                loadingAllert();

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        Swal.close();

                        if (response.code === 422) { // Jika validasi gagal
                            let errors = response.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        } else if (response.code === 200 || response.status === "success") {
                            successAlert('Data berhasil disimpan!');
                            reloadBrowsers();
                        } else {
                            errorAlert();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.close();
                        errorAlert();
                    }
                });
            });

            // Edit data button click handler
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');

                $.ajax({
                    url: `/naive-bayes/aturan-penyakit/get/${id}`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {

                        $('#upsertDataModal').modal('show');
                        $('#id').val(response.data.id);

                        // Load dropdown lalu isi nilai
                        loadPenyakit();
                        loadParameter();

                        setTimeout(() => {
                            $('#penyakit_id').val(response.data.penyakit_id);
                            $('#parameter_id').val(response.data.parameter_id);
                        }, 500);

                        // isi field lain
                        $('#kondisi').val(response.data.kondisi);
                        $('#bobot_pengaruh').val(response.data.bobot_pengaruh);
                    },
                    error: function() {
                        console.error("Gagal ambil data");
                    }
                });
            });


            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                // Function to delete data
                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/naive-bayes/aturan-penyakit/delete/${id}`,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.code === 200 || response.status === "success") {
                                successAlert('Data berhasil dihapus!');

                                // Tunggu sebentar sebelum reload
                                setTimeout(function() {
                                    location
                                        .reload(); // Reload browser setelah data terhapus
                                }, 1500);
                            } else {
                                errorAlert();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', xhr.responseText);
                            errorAlert();
                        }
                    });
                }

                // Show confirmation alert
                confirmAlert('Apakah Anda yakin ingin menghapus data?', deleteData);
            });

            function successAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            function errorAlert() {
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan!',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1000,
                });
            }

            function reloadBrowsers() {
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }

            function confirmAlert(message, callback) {
                Swal.fire({
                    title: '<span style="font-size: 22px"> Konfirmasi!</span>',
                    html: message,
                    showCancelButton: true,
                    showConfirmButton: true,
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya',
                    reverseButtons: true,
                    confirmButtonColor: '#48ABF7',
                    cancelButtonColor: '#EFEFEF',
                    customClass: {
                        cancelButton: 'text-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }

            function loadingAllert() {
                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            // Tampilkan modal tambah
            $(document).on('click', '#myBtn', function() {
                $('#upsertDataForm')[0].reset(); // reset form
                $('#id').val('');
                $('#upsertDataModal').modal('show');
                $('.text-danger').text('');

            });

            // Reset saat modal ditutup
            $('#upsertDataModal').on('hidden.bs.modal', function() {
                $('#upsertDataForm')[0].reset();
                $('#id').val('');
                $('.text-danger').text('');

            });
        });
    </script>
@endsection
