import datasetService from "../services/data-set.service.js";

$(document).ready(function () {
    const service = new datasetService();
    service.getAllData();

    function resetFormState() {
        $('#formDataset')[0].reset();
        $('#id').val('');
        $('.form-control').removeClass('is-valid is-invalid');
        $('.form-check-input').removeClass('is-invalid');
        $('.text-danger').text('');
        // Tetap biarkan container memuat data
        $('#container-gejala, #container-lingkungan').html('<div class="text-muted small">Memuat data...</div>');
    }

    $('#btnTambahDataset').on('click', async function () {
        resetFormState();
        await service.loadOptions();
        $('#modalDataset').modal('show');
    });

    function validation() {
        if ($.data($('#formDataset')[0], 'validator')) {
            $('#formDataset').validate().destroy();
        }

        $.validator.addMethod("requireMinLingkungan", function (value, element) {
            const totalChecked = $('#container-lingkungan input[type="radio"]:checked').length;
            return totalChecked >= 2;
        }, "Pilih minimal 2 parameter kondisi lingkungan.");

        $.validator.addClassRules("check-lingkungan", {
            requireMinLingkungan: true
        });

        const validator = $('#formDataset').validate({
            rules: {
                penyakit_id: { required: true },
                "gejala[]": {
                    required: true,
                    minlength: 2
                }
            },
            messages: {
                penyakit_id: "Silahkan pilih penyakit target dahulu.",
                "gejala[]": {
                    required: "Wajib memilih gejala.",
                    minlength: "Pilih minimal 2 gejala agar data training valid."
                }
            },
            errorElement: 'small',
            errorClass: 'text-danger d-block mt-1',
            errorPlacement: function (error, element) {
                const name = element.attr("name");
                if (name === "gejala[]") {
                    $("#gejala-error").html(error);
                } else if (name && name.indexOf("lingkungan") !== -1) {
                    $("#lingkungan-error").html(error);
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element) {
                const name = $(element).attr("name");
                if (name === "gejala[]" || (name && name.indexOf("lingkungan") !== -1)) {
                    $(element).closest('.card').addClass('border border-danger');
                } else {
                    $(element).addClass('is-invalid');
                }
            },
            unhighlight: function (element) {
                const name = $(element).attr("name");
                if (name && name.indexOf("lingkungan") !== -1) {
                    const totalChecked = $('#container-lingkungan input[type="radio"]:checked').length;
                    if (totalChecked >= 2) {
                        $(element).closest('.card').removeClass('border border-danger');
                        $("#lingkungan-error").empty();
                    }
                } else if (name === "gejala[]") {
                    $(element).closest('.card').removeClass('border border-danger');
                    $("#gejala-error").empty();
                } else {
                    $(element).removeClass('is-invalid');
                }
            }
        });

        $(document).on('change', '.check-lingkungan', function () {
            validator.element(this);

            if ($('#container-lingkungan input[type="radio"]:checked').length >= 2) {
                $("#lingkungan-error").empty();
                $(this).closest('.card').removeClass('border border-danger');
            }
        });
    }

    validation();

    function checkingEdit() {
        return $('#id').val() ? true : false;
    }

    $('#formDataset').submit(function (e) {
        e.preventDefault();
        if ($(this).valid()) {
            service.upsertData(e, checkingEdit);
        }
    });

    // Edit Data
    $(document).on('click', '.edit-dataset', function () { // Sesuaikan class tombol edit Anda
        const id = $(this).data('id');
        resetFormState();
        service.getDataById(id, checkingEdit);
    });

    // Delete Data
    $(document).on('click', '.delete-dataset', function () { // Sesuaikan class tombol delete Anda
        const id = $(this).data('id');
        service.deleteData(id);
    });

    $('#modalDataset').on('hidden.bs.modal', function () {
        resetFormState();
    });

    $('#modalDataset').on('show.bs.modal', function () {
        const title = checkingEdit() ? 'Edit Dataset Training' : 'Tambah Dataset Training';
        $('#labelModalDataset').html(`<i class="fas fa-database me-2"></i> ${title}`);
    });
});
