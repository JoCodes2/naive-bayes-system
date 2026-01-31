import DiagnosaService from "../services/diagnosa-web.service.js";
import AlertComponent from "./alertComponent.js";

$(document).ready(function () {
    const diagnosaService = new DiagnosaService();
    diagnosaService.initForm();

    $('#diagnosisForm').validate({
        rules: {
            "gejala[]": { required: true, minlength: 2 }, // Minimal 2 gejala agar akurat
            "lingkungan[]": { required: true }
        },
        // Matikan error default jQuery Validate karena kita pakai AlertComponent
        errorPlacement: function () { },
        invalidHandler: function (event, validator) {
            const errors = validator.numberOfInvalids();
            if (errors) {
                AlertComponent.toast("Mohon pilih setidaknya 2 gejala dan kondisi lingkungan aktif.", "warning");
            }
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            $('.validation-error-container').remove();

            // Tampilkan Loading Overlay
            AlertComponent.showLoading(true);

            diagnosaService.prosesDiagnosa(e)
                .then(() => {
                    AlertComponent.toast("Diagnosa Berhasil", "success");
                })
                .catch(() => {
                    AlertComponent.toast("Terjadi kesalahan sistem", "error");
                })
                .finally(() => {
                    AlertComponent.showLoading(false);
                });
        }
    });
});
