import parameterService from "../services/parameter.service.js";

$(document).ready(function () {
    const parameter = new parameterService();
    parameter.getAllData();

    // Reset validasi visual dan pesan error
    function resetValidationState() {
        $('#formParameter .form-control').removeClass('is-valid is-invalid');
        // Bersihkan semua elemen pesan error berdasarkan ID yang baru
        $('#nama_parameter-error, #satuan-error, #nilai_label-error, #min_value-error, #max_value-error')
            .text('');
        // Hapus class error bawaan jquery validation jika ada
        $('.error').remove();
    }

    $('#btnTambahParameter').on('click', function () {
        $('#formParameter')[0].reset();
        $('#id').val('');
        resetValidationState();
        $('#modalParameter').modal('show');
    });

    // Validasi menggunakan jQuery Validation Plugin
    function validation() {
        $('#formParameter').validate({
            rules: {
                nama_parameter: { required: true },
                satuan: { required: false },
                nilai_label: { required: true },
                min_value: { number: true, required: true },
                max_value: {
                    number: true,
                    required: true,
                    greaterThanMin: true
                }
            },
            messages: {
                nama_parameter: { required: "Nama parameter wajib diisi" },
                nilai_label: { required: "Pilih label kondisi (rendah/normal/tinggi)" },
                min_value: { number: "Harus berupa angka", required: 'Batas minimal wajib diisi' },
                max_value: {
                    number: "Harus berupa angka",
                    required: 'Batas maksimal wajib diisi',
                    greaterThanMin: "Nilai maksimal harus lebih besar dari nilai minimal"
                }
            },
            highlight: function (element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            errorPlacement: function (error, element) {
                // Mencari elemen small atau div yang ID-nya [name]-error
                let errorId = $(element).attr('name') + "-error";
                if ($("#" + errorId).length) {
                    $("#" + errorId).html(error);
                } else {
                    error.addClass('text-danger text-sm');
                    error.insertAfter(element);
                }
            }
        });
    }

    // Method custom untuk membandingkan min dan max
    $.validator.addMethod("greaterThanMin", function (value, element) {
        const min = parseFloat($('#min_value').val());
        const max = parseFloat(value);
        if (isNaN(min) || isNaN(max)) return true;
        return max > min;
    });

    validation();

    // Trigger validasi saat input berubah
    $('#nama_parameter, #nilai_label, #min_value, #max_value').on('input change', function () {
        $(this).valid();
    });

    function checkingEdit() {
        return $('#id').val() !== "" && $('#id').val() !== null;
    }

    $('#formParameter').submit(function (e) {
        e.preventDefault();
        // Hanya kirim jika jquery validation valid
        if ($(this).valid()) {
            parameter.upsertData(e, checkingEdit);
        }
    });

    $(document).on('click', '.edit-parameter', function () {
        const id = $(this).data('id');
        resetValidationState();
        parameter.getDataById(id, checkingEdit);
    });

    $(document).on('click', '.delete-parameter', function () {
        const id = $(this).data('id');
        parameter.deleteData(id);
    });

    $('#modalParameter').on('hidden.bs.modal', function () {
        $('#formParameter')[0].reset();
        $('#id').val('');
        resetValidationState();
    });

    $('#modalParameter').on('show.bs.modal', function () {
        const title = checkingEdit() ? 'Edit Kondisi Lingkungan' : 'Tambah Kondisi Lingkungan';
        $('#labelModaParameter').html(`
            <i class="fa-solid fa-hand-holding-droplet me-2"></i>
            ${title}
        `);
    });
});
