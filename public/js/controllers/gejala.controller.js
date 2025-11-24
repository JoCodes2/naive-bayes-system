import gejalaService from "../services/gejala.service.js";


$(document).ready(function () {
    const gejalaservice = new gejalaService();
    gejalaservice.getAllData();

    $('#btnTambahGejala').on('click', function () {
        $('#formGejala')[0].reset();
        $('#id').val('');

        $('#formGejala .form-control').removeClass('is-valid is-invalid');
        $('#nama-error, #deskripsi-error').text('');

        $('#modalGejala').modal('show');
    });
    function validation() {
        $('#formGejala').validate({
            rules: {
                nama: { required: true },
                deskripsi: { required: true },
            },
            messages: {
                nama: { required: "Form tidak boleh kosong" },
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

    $('#nama, #deskripsi').on('input', function () {
        $(this).valid();
    });

    function checkingEdit() {
        return $('#id').val() ? true : false;
    }
    $('#btnSimpanGejala').on('click', function () {

        if (!$('#formGejala').valid()) {
            return;
        }
        const form = $('#formGejala')[0];
        gejalaservice.upsertData(form, checkingEdit);
    });

    $(document).on('click', '.edit-gejala', function () {
        const id = $(this).data('id');
        gejalaservice.getDataById(id, checkingEdit);
    });

    $(document).on('click', '.delete-gejala', function () {
        const id = $(this).data('id');
        gejalaservice.deleteData(id);
    });

    $('#modalGejala').on('hidden.bs.modal', function () {
        $('#id').val('');
        $('#nama').val('');
        $('#deskripsi').val('');
        $('.form-control').removeClass('is-invalid').removeClass('is-valid');
        $('.error').remove();
    });
    $('#modalGejala').on('show.bs.modal', function () {
        $('#modal-title').html(`
            <i class="fas fa-box ms-2"></i>
            Form Data
        `);
    });

});
