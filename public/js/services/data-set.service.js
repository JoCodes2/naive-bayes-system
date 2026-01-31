class datasetService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    // Fungsi untuk load Gejala, Lingkungan, dan Penyakit ke dalam Form
    async loadOptions() {
        try {
            const [resPenyakit, resGejala, resLingkungan] = await Promise.all([
                this.ajaxRequest(`${appUrl}/naive-bayes/penyakit/`, 'GET'),
                this.ajaxRequest(`${appUrl}/naive-bayes/gejala/`, 'GET'),
                this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/`, 'GET')
            ]);

            // 1. Isi Select Penyakit
            let htmlPenyakit = '<option value="" selected disabled>-- Pilih Penyakit --</option>';
            resPenyakit.data.forEach(p => {
                htmlPenyakit += `<option value="${p.id}">${p.kode_penyakit} - ${p.nama_penyakit}</option>`;
            });
            $('#penyakit_id').html(htmlPenyakit);

            // 2. Isi Checkbox Gejala
            let htmlGejala = '';
            resGejala.data.forEach(g => {
                htmlGejala += `
                    <div class="form-check py-1">
                        <input class="form-check-input check-gejala" type="checkbox" name="gejala[]" value="${g.id}" id="g-${g.id}">
                        <label class="form-check-label" for="g-${g.id}">
                            <strong class="text-primary">${g.kode_gejala}</strong> - ${g.nama_gejala}
                        </label>
                    </div>`;
            });
            $('#container-gejala').html(htmlGejala);

            // 3. Isi Checkbox Lingkungan
            let htmlLingkungan = '';
            resLingkungan.data.forEach(l => {
                let badgeClass = l.nilai_label === 'rendah' ? 'btn-primary' : (l.nilai_label === 'normal' ? 'btn-success' : 'btn-danger');
                htmlLingkungan += `
                    <div class="form-check py-1">
                        <input class="form-check-input check-lingkungan" type="checkbox" name="lingkungan[]" value="${l.id}" id="l-${l.id}">
                        <label class="form-check-label" for="l-${l.id}">
                            ${l.nama_parameter} (<span class="badge ${badgeClass} btn-sm" style="font-size:10px">${l.nilai_label.toUpperCase()}</span>)
                        </label>
                    </div>`;
            });
            $('#container-lingkungan').html(htmlLingkungan);

        } catch (error) {
            console.error("Gagal memuat opsi form:", error);
        }
    }

    async getAllData() {
        if ($.fn.dataTable.isDataTable('#datasetTable')) {
            $('#datasetTable').DataTable().clear().destroy();
        }

        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/data-set/`, 'GET');

            if (responseData && responseData.data) {
                let tableBody = '';
                responseData.data.forEach((item, index) => {
                    // Logic Badge untuk list Gejala (Mengambil count atau list kode)
                    let badgeGejala = `<span class="badge btn-primary">${item.gejala ? item.gejala.length : 0} Gejala Terpilih</span>`;
                    let badgeLingkungan = `<span class="badge btn-info">${item.lingkungan ? item.lingkungan.length : 0} Parameter Terpilih</span>`;

                    tableBody += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="fw-bold">${item.penyakit ? item.penyakit.nama_penyakit : 'N/A'}</td>
                        <td class="text-center">${badgeGejala}</td>
                        <td class="text-center">${badgeLingkungan}</td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="javascript:void(0)" class="edit-dataset btn btn-icon btn-round btn-primary btn-sm" data-id="${item.id}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="javascript:void(0)" class="delete-dataset btn btn-icon btn-round btn-danger btn-sm" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                });

                $("#datasetTable tbody").html(tableBody);
                $('#datasetTable').DataTable({ responsive: true, pageLength: 10 });
            }
        } catch (error) {
            console.error('Error fetching dataset:', error);
        }
    }

    async upsertData(e, checkingEdit) {
        let submitButton = $('#btnSimpanDataset');
        try {
            const formData = new FormData(e.target);
            let responseData;

            const url = checkingEdit()
                ? `${appUrl}/naive-bayes/data-set/update/${$('#id').val()}`
                : `${appUrl}/naive-bayes/data-set/create`;

            responseData = await this.ajaxRequest(url, 'POST', formData);

            successAlert(responseData.message).then(() => {
                $('#modalDataset').modal('hide');
                location.reload();
            });
        } catch (error) {
            submitButton.attr('disabled', false);
            if (error.status === 422) {
                warningAlert("Validasi Gagal");
                // Handle manual error display jika diperlukan
            } else {
                errorAlert();
            }
        }
    }

    async getDataById(id, checkingEdit) {
        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/data-set/get/${id}`, 'GET');
            const data = responseData.data;

            await this.loadOptions(); // Pastikan opsi dimuat dulu sebelum di-set (checked)

            $('#modalDataset').modal('show');
            $('#id').val(data.id);
            $('#penyakit_id').val(data.penyakit_id).trigger('change');

            // Set Checked untuk Gejala
            if (data.gejala) {
                data.gejala.forEach(idG => {
                    $(`#g-${idG}`).prop('checked', true);
                });
            }

            // Set Checked untuk Lingkungan
            if (data.lingkungan) {
                data.lingkungan.forEach(idL => {
                    $(`#l-${idL}`).prop('checked', true);
                });
            }

            checkingEdit();
        } catch (error) {
            console.error(error);
        }
    }

    async deleteData(id) {
        const result = await confirmDeleteAlert();
        if (result.isConfirmed) {
            try {
                const response = await this.ajaxRequest(`${appUrl}/naive-bayes/data-set/delete/${id}`, 'DELETE');
                if (response.code === 200 || response.status === 'success') {
                    successAlert("Dihapus!").then(() => location.reload());
                }
            } catch (error) {
                errorAlert();
            }
        }
    }
}

export default datasetService;
