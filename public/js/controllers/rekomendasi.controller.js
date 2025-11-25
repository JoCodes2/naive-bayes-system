import rekomendasiService from "../services/rekomendasi.service.js";

$(document).ready(function () {
    const rekomendasi = new rekomendasiService();
    rekomendasi.getAllData();

    $('#btnTambahRekomendasi').on('click', function () {
        $('#formRekomendasi')[0].reset();
        $('#id').val('');

        $('#formRekomendasi .form-control').removeClass('is-valid is-invalid');
        $('#judul-error, #deskripsi-error').text('');

        $('#modalRekomendasi').modal('show');
    });
    function validation() {
        $('#formRekomendasi').validate({
            rules: {
                judul: { required: true },
                deskripsi: { required: true },
            },
            messages: {
                judul: { required: "Form tidak boleh kosong" },
                deskripsi: { required: "Form tidak boleh kosong" },
            },
            highlight: function (element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            errorPlacement: function (error, element) {
                error.addClass('text-danger text-sm');
                error.insertAfter(element);
            }
        });
    }

    validation();

    $('#judul, #deskripsi').on('input', function () {
        $(this).valid();
    });

    function checkingEdit() {
        return $('#id').val() ? true : false;
    }
    $('#btnSimpanRekomendasi').on('click', function () {

        if (!$('#formRekomendasi').valid()) {
            return;
        }
        const form = $('#formRekomendasi')[0];
        rekomendasi.upsertData(form, checkingEdit);
    });

    $(document).on('click', '.edit-rekomendasi', function () {
        const id = $(this).data('id');
        rekomendasi.getDataById(id, checkingEdit);
    });

    $(document).on('click', '.delete-rekomendasi', function () {
        const id = $(this).data('id');
        rekomendasi.deleteData(id);
    });

    $('#modalRekomendasi').on('hidden.bs.modal', function () {
        $('#id').val('');
        $('#judul').val('');
        $('#deskripsi').val('');
        $('.form-control').removeClass('is-invalid').removeClass('is-valid');
        $('.error').remove();
    });
    $('#modalRekomendasi').on('show.bs.modal', function () {
        $('#modal-title').html(`
            <i class="fas fa-box ms-2"></i>
            Form Data
        `);
    });

});
