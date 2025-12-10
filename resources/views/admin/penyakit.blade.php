@extends('Layouts.Base')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title"><i class="fas fa-virus-covid pr-2"></i>Penyakit</h4>
        </div>

        <div class="row">
            <div class="col-md-12">

                <!-- Card Section -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">DAFTAR PENYAKIT</h5>
                        {{-- @if (auth()->user()->role === 'admin') --}}
                        <button class="btn btn-primary btn-sm" id="myBtn">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                        {{-- @endif --}}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataPenyakit" class="table table-striped table-bordered align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 140px;">Kode</th>
                                        <th style="width: 180px;">Nama Penyakit</th>
                                        <th style="width: 300px;">Deskripsi</th>
                                        <th style="width: 300px;">Solusi Perawatan</th>
                                        <th style="width: 300px;">Tindakan Pencegahan</th>
                                        <th style="width: 250px;">Faktor Risiko</th>
                                        <th style="width: 100px;">Action</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="upsertDataForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Penyakit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="id" name="id">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="kode_penyakit" class="form-label">Kode Penyakit</label>
                                <input type="text" class="form-control" name="kode_penyakit" id="kode_penyakit"
                                    placeholder="Masukkan kode penyakit">
                                <small id="kode_penyakit-error" class="text-danger"></small>
                            </div>

                            <div class="col-md-6">
                                <label for="nama_penyakit" class="form-label">Nama Penyakit</label>
                                <input type="text" class="form-control" name="nama_penyakit" id="nama_penyakit"
                                    placeholder="Masukkan nama penyakit">
                                <small id="nama_penyakit-error" class="text-danger"></small>
                            </div>

                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="2" placeholder="Masukkan deskripsi penyakit"></textarea>
                                <small id="deskripsi-error" class="text-danger"></small>
                            </div>

                            <div class="col-12">
                                <label for="solusi_perawatan" class="form-label">Solusi Perawatan</label>
                                <textarea name="solusi_perawatan" class="form-control list-textarea" id="solusi_perawatan"></textarea>
                                <small id="solusi_perawatan-error" class="text-danger"></small>
                            </div>

                            <div class="col-12">
                                <label for="tindakan_pencegahan" class="form-label">Tindakan Pencegahan</label>
                                <textarea name="tindakan_pencegahan" class="form-control list-textarea" id="tindakan_pencegahan"></textarea>
                                <small id="tindakan_pencegahan-error" class="text-danger"></small>
                            </div>

                            <div class="col-12">
                                <label for="faktor_risiko" class="form-label">Faktor Resiko</label>
                                <textarea name="faktor_risiko" class="form-control list-textarea" id="faktor_risiko"></textarea>
                                <small id="faktor_risiko-error" class="text-danger"></small>
                            </div>

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

            // Fungsi untuk merapikan teks menjadi list
            function formatList(text) {
                if (!text) return '-';

                // Pecah berdasarkan angka dan titik (contoh: 1. , 2. , 3.)
                let items = text.split(/\d+\.\s*/).filter(i => i.trim() !== '');

                let html = "<ul style='text-align: left; padding-left: 18px;'>";
                items.forEach(i => {
                    html += `<li>${i.trim()}</li>`;
                });
                html += "</ul>";

                return html;
            }

            // Fetch Data
            function getData() {
                $.ajax({
                    url: `/naive-bayes/penyakit`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        let userData = response.data;
                        let tableBody = "";

                        if (userData.length > 0) {
                            $.each(userData, function(index, item) {
                                tableBody += "<tr>";
                                tableBody += "<td>" + (index + 1) + "</td>";
                                tableBody += "<td>" + (item.kode_penyakit || '-') + "</td>";
                                tableBody += "<td>" + (item.nama_penyakit || '-') + "</td>";
                                tableBody += "<td style='text-align: left;'>" + (item
                                    .deskripsi ?? '-') + "</td>";
                                tableBody += "<td>" + formatList(item.solusi_perawatan) +
                                    "</td>";
                                tableBody += "<td>" + formatList(item.tindakan_pencegahan) +
                                    "</td>";
                                tableBody += "<td>" + formatList(item.faktor_risiko) + "</td>";
                                tableBody += `
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="edit-btn" data-id="${item.id}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="#" class="delete-confirm" data-id="${item.id}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>`;
                                tableBody += "</tr>";
                            });
                        }

                        $("#tBody").html(tableBody);

                        // Initialize DataTable
                        $('#dataPenyakit').DataTable({
                            destroy: true,
                            paging: true,
                            searching: true,
                            ordering: true,
                            info: true,
                            order: [],
                        });
                    },
                    error: function() {
                        console.log("Gagal mengambil data dari server");
                    }
                });
            }

            getData();

            // Create or Update Data
            $(document).on('click', '#simpanData', function() {
                let formData = new FormData($('#upsertDataForm')[0]);
                let id = $('#id').val();
                let url = id ? `/naive-bayes/penyakit/update/${id}` : "/naive-bayes/penyakit/create";

                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: response.message || "Data berhasil disimpan",
                            timer: 1500,
                            showConfirmButton: false,
                        });

                        $('#upsertDataModal').modal('hide');
                        $('#upsertDataForm')[0].reset();

                        reloadBrowsers(); // 🔥 Auto refresh halaman

                        getData();
                    },

                    error: function(xhr) {
                        $('.text-danger').text(""); // reset error dulu

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                $("#" + key + "-error").text(value[0]);
                            });

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: "Terjadi kesalahan server!",
                            });
                        }
                    }
                });
            });


            // Edit data button click handler
            $(document).on('click', '.edit-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/naive-bayes/penyakit/get/${id}`,
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#upsertDataModal').modal('show');

                        // Populate form fields with existing data
                        $('#id').val(response.data.id);
                        $('#kode_penyakit').val(response.data.kode_penyakit);
                        $('#nama_penyakit').val(response.data.nama_penyakit);
                        $('#deskripsi').val(response.data.deskripsi);
                        $('textarea[name="solusi_perawatan"]').val(response.data
                            .solusi_perawatan);
                        $('textarea[name="tindakan_pencegahan"]').val(response.data
                            .tindakan_pencegahan);
                        $('textarea[name="faktor_risiko"]').val(response.data.faktor_risiko);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data for edit:', error);
                    }
                });
            });

            // Show modal tambah
            $(document).on('click', '#myBtn', function() {
                $('#upsertDataForm')[0].reset();
                $('.summernote').summernote('code', '');
                $('#id').val('');
                $('#upsertDataModal').modal('show');
            });

            // Delete data button click handler
            $(document).on('click', '.delete-confirm', function() {
                let id = $(this).data('id');

                // Function to delete data
                function deleteData() {
                    $.ajax({
                        type: 'DELETE',
                        url: `/naive-bayes/penyakit/delete/${id}`,
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            if (response.code === 200 || response.status === "success") {
                                successAlert("Data berhasil dihapus");
                                reloadBrowsers(); // 🔥 Auto refresh halaman

                                getData();
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
                confirmAlert('Apakah Anda yakin ingin menghapus data ini?', deleteData);
            });

            function reloadBrowsers() {
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }

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

            // Reset Summernote ketika modal ditutup
            $('#upsertDataModal').on('hidden.bs.modal', function() {
                $('#upsertDataForm')[0].reset();
                $('.summernote').summernote('code', '');
                $('#id').val('');
                $('.text-danger').text('');
            });

            function formatListText(event) {
                const textarea = event.target;

                // Kalau tekan ENTER
                if (event.key === "Enter") {
                    event.preventDefault();

                    const lines = textarea.value.split("\n").filter(l => l.trim() !== "");
                    let newLine = (lines.length + 1) + ". ";

                    textarea.value += "\n" + newLine;
                }
            }

            // Daftarkan ke semua textarea input list
            $(document).on("keydown", ".list-textarea", function(event) {
                const textarea = this;

                if (event.key === "Enter") {
                    event.preventDefault();

                    const lines = textarea.value.split("\n").filter(l => l.trim() !== "");
                    textarea.value += "\n" + (lines.length + 1) + ". ";
                }
            });

        });
    </script>
@endsection
