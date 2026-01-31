import datasetService from "../services/data-set.service.js";


$(document).ready(function () {
    const service = new datasetService();
    service.getAllData();

    // Fungsi Reset Validasi & Form
    function resetFormState() {
        $('#formDataset')[0].reset();
        $('#id').val('');
        $('.form-control').removeClass('is-valid is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.text-danger').text('');
        // Kosongkan container agar tidak double saat load ulang
        $('#container-gejala, #container-lingkungan').html('<div class="text-muted small">Memuat data...</div>');
    }

    // Tombol Tambah
    $('#btnTambahDataset').on('click', async function () {
        resetFormState();
        await service.loadOptions(); // Load data master (penyakit, gejala, lingkungan)
        $('#modalDataset').modal('show');
    });

    // Validasi jQuery
    function validation() {
        $('#formDataset').validate({
            rules: {
                penyakit_id: { required: true },
                "gejala[]": { required: true, minlength: 1 },
                "lingkungan[]": { required: true, minlength: 1 }
            },
            messages: {
                penyakit_id: "Pilih penyakit target",
                "gejala[]": "Pilih minimal satu gejala",
                "lingkungan[]": "Pilih minimal satu kondisi lingkungan"
            },
            errorElement: 'small', // Gunakan tag small
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).closest('.form-group, .col-md-6').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group, .col-md-6').removeClass('has-error');
            },
            errorPlacement: function (error, element) {
                // Mencegah error masuk ke dalam baris checkbox
                if (element.attr("name") === "gejala[]") {
                    $("#gejala-error").html(error); // Masukkan ke elemen yang sudah kita siapkan di bawah card
                } else if (element.attr("name") === "lingkungan[]") {
                    $("#lingkungan-error").html(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }

    validation();

    function checkingEdit() {
        return $('#id').val() ? true : false;
    }

    // Submit Form
    $('#formDataset').submit(function (e) {
        e.preventDefault();
        if ($(this).valid()) {
            service.upsertData(e, checkingEdit);
        }
    });

    // Edit Data
    $(document).on('click', '.edit-dataset', function () {
        const id = $(this).data('id');
        resetFormState();
        service.getDataById(id, checkingEdit);
    });

    // Delete Data
    $(document).on('click', '.delete-dataset', function () {
        const id = $(this).data('id');
        service.deleteData(id);
    });

    // Modal Events
    $('#modalDataset').on('hidden.bs.modal', function () {
        resetFormState();
    });

    $('#modalDataset').on('show.bs.modal', function () {
        const title = checkingEdit() ? 'Edit Dataset Training' : 'Tambah Dataset Training';
        $('#labelModalDataset').html(`<i class="fas fa-database me-2"></i> ${title}`);
    });
});
