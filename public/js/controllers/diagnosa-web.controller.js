import DiagnosaService from "../services/diagnosa-web.service.js";
import AlertComponent from "./alertComponent.js";
$(document).ready(function () {
    const diagnosaService = new DiagnosaService();

    diagnosaService.initForm().then(() => {
        $('input[name^="lingkungan"]').each(function () {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Semua kondisi lingkungan wajib dipilih"
                }
            });
        });

        $('input[name="gejala[]"]').each(function () {
            $(this).rules("add", {
                required: true,
                minlength: 2,
                messages: {
                    required: "Anda belum memilih gejala",
                    minlength: "Pilih minimal 2 gejala"
                }
            });
        });
    });

    $('#diagnosisForm').validate({
        ignore: [],
        rules: {
            "nama_petani": {
                required: true,
                minlength: 3
            }
        },
        messages: {
            "nama_petani": {
                required: "Nama petani tidak boleh kosong",
                minlength: "Nama petani minimal 3 karakter"
            }
        },
        errorPlacement: function () { return false; },
        invalidHandler: function (event, validator) {
            const errorList = validator.errorList;
            if (errorList.length > 0) {
                AlertComponent.toast(errorList[0].message, "warning");
            }
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            AlertComponent.showLoading(true);
            diagnosaService.prosesDiagnosa(e)
                .then(() => {
                    AlertComponent.toast("Diagnosa Berhasil", "success");
                })
                .catch((err) => {
                    AlertComponent.toast("Gagal melakukan diagnosa", "error");
                })
                .finally(() => {
                    AlertComponent.showLoading(false);
                });
        }
    });
});
