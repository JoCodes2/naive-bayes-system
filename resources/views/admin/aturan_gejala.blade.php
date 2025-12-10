@extends('Layouts.Base')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><i class="fas fa-book-medical pr-2"></i>Aturan Gejala</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- Card Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">DAFTAR ATURAN GEJALA</h5>
                        {{-- @if (auth()->user()->role === 'admin') --}}
                        <button class="btn btn-primary btn-sm" id="myBtn">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                        {{-- @endif --}}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table id="dataAturanGejala" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Penyakit</th>
                                        <th>Kode Gejala</th>
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
                        <h5 class="modal-title">Tambah Aturan Gejala</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id" name="id">

                        <!-- Penyakit -->
                        <div class="mb-3">
                            <label for="penyakit_id">Penyakit</label>
                            <select class="form-control" name="penyakit_id" id="penyakit_id">
                                <option value="">-- Pilih Penyakit --</option>
                                <!-- Dynamic Option via AJAX -->
                            </select>
                            <small id="penyakit_id-error" class="text-danger"></small>
                        </div>

                        <!-- Gejala -->
                        <div class="mb-3">
                            <label for="gejala_id">Gejala</label>
                            <select class="form-control" name="gejala_id" id="gejala_id">
                                <option value="">-- Pilih Gejala --</option>
                                <!-- Dynamic Option via AJAX -->
                            </select>
                            <small id="gejala_id-error" class="text-danger"></small>
                        </div>

                        <!-- Bobot -->
                        <div class="mb-3">
                            <label for="bobot">Bobot (0.1 - 1)</label>
                            <input type="number" step="0.1" min="0.1" max="1" class="form-control"
                                name="bobot" id="bobot" placeholder="Masukkan bobot">
                            <small id="bobot-error" class="text-danger"></small>
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

            function loadGejala() {
                $.get('/naive-bayes/gejala', function(res) {
                    $("#gejala_id").empty().append('<option value="">-- Pilih Gejala --</option>');
                    $.each(res.data, function(i, item) {
                        $("#gejala_id").append(
                            `<option value="${item.id}">${item.nama_gejala}</option>`);
                    });
                });
            }

            // panggil saat modal dibuka
            $("#myBtn, #editBtn").on("click", function() {
                loadPenyakit();
                loadGejala();
            });


            function getData() {
                $.ajax({
                    url: `/naive-bayes/aturan-gejala/`,
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
                                tableBody += "<td>" + (item.penyakit?.kode_penyakit || '-') +
                                    "</td>";
                                tableBody += "<td>" + (item.gejala?.kode_gejala || '-') +
                                    "</td>";


                                tableBody += "<td>" + (item.bobot || '-') + "</td>";
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
                        $('#dataAturanGejala').DataTable({
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
                let url = id ? `/naive-bayes/aturan-gejala/update/${id}` :
                    '/naive-bayes/aturan-gejala/create';
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
                    url: `/naive-bayes/aturan-gejala/get/${id}`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#upsertDataModal').modal('show');

                        // Populate form fields with existing data
                        $('#id').val(response.data.id);
                        $('#penyakit_id').val(response.data.penyakit_id);
                        $('#gejala_id').val(response.data.gejala_id);
                        $('#bobot').val(response.data.bobot);

                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data for edit:', error);
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
                        url: `/naive-bayes/aturan-gejala/delete/${id}`,
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
