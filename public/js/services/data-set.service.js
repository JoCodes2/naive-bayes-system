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

    async loadOptions() {
        try {
            const [resPenyakit, resGejala, resLingkungan] = await Promise.all([
                this.ajaxRequest(`${appUrl}/naive-bayes/penyakit/`, 'GET'),
                this.ajaxRequest(`${appUrl}/naive-bayes/gejala/`, 'GET'),
                this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/`, 'GET')
            ]);

            let htmlPenyakit = '<option value="" selected disabled>-- Pilih Penyakit --</option>';
            resPenyakit.data.forEach(p => {
                htmlPenyakit += `<option value="${p.id}">${p.kode_penyakit} - ${p.nama_penyakit}</option>`;
            });
            $('#penyakit_id').html(htmlPenyakit);

            const sortedGejala = resGejala.data.sort((a, b) =>
                a.kode_gejala.localeCompare(b.kode_gejala, undefined, { numeric: true, sensitivity: 'base' })
            );

            let htmlGejala = '<div class="row">';
            sortedGejala.forEach(g => {
                htmlGejala += `
            <div class="col-md-6">
                <div class="form-check py-1">
                    <input class="form-check-input check-gejala" type="checkbox" name="gejala[]"
                           value="${g.kode_gejala}" id="g-${g.kode_gejala}">
                    <label class="form-check-label cursor-pointer" for="g-${g.kode_gejala}">
                        <strong class="text-success">${g.kode_gejala}</strong> - ${g.nama_gejala}
                    </label>
                </div>
            </div>`;
            });
            htmlGejala += '</div>';
            $('#container-gejala').html(htmlGejala);

            const groups = resLingkungan.data.reduce((acc, obj) => {
                acc[obj.nama_parameter] = acc[obj.nama_parameter] || [];
                acc[obj.nama_parameter].push(obj);
                return acc;
            }, {});

            const sortedParams = Object.keys(groups).sort();

            const labelOrder = { 'rendah': 1, 'normal': 2, 'tinggi': 3 };

            let htmlLingkungan = '';
            sortedParams.forEach(paramName => {
                const sortedValues = groups[paramName].sort((a, b) =>
                    labelOrder[a.nilai_label.toLowerCase()] - labelOrder[b.nilai_label.toLowerCase()]
                );

                htmlLingkungan += `
            <div class="mb-4 bg-white p-2 rounded border-bottom">
                <label class="d-block small fw-black text-primary mb-2 text-uppercase tracking-wider">
                    <i class="fas fa-sm fa-sliders-h me-1"></i> ${paramName}
                </label>
                <div class="d-flex gap-4 flex-wrap ms-2">
                    ${sortedValues.map(item => {
                    const label = item.nilai_label.toLowerCase();
                    const colorClass = label === 'rendah' ? 'bg-info' : (label === 'normal' ? 'bg-success' : 'bg-danger');
                    return `
                        <div class="form-check">
                            <input class="form-check-input check-lingkungan" type="radio"
                                   name="lingkungan[${paramName}]"
                                   value="${item.nilai_label}"
                                   id="l-${item.id}">
                            <label class="form-check-label cursor-pointer" for="l-${item.id}">
                                <span class="badge ${colorClass} px-3 py-2">${item.nilai_label.toUpperCase()}</span>
                            </label>
                        </div>`;
                }).join('')}
                </div>
            </div>`;
            });
            $('#container-lingkungan').html(htmlLingkungan || '<div class="text-center p-3 text-muted">Data parameter tidak ditemukan</div>');

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
                    // Perbaikan: Gunakan Object.keys untuk menghitung objek lingkungan
                    const countGejala = item.gejala ? item.gejala.length : 0;
                    const countLingkungan = item.lingkungan ? Object.keys(item.lingkungan).length : 0;

                    // Badge yang bisa diklik (Cursor Pointer)
                    let badgeGejala = `
                    <span class="badge btn-primary cursor-pointer btn-view-gejala"
                          data-id="${item.id}"
                          style="cursor:pointer">
                        ${countGejala} Gejala Terpilih
                    </span>`;

                    let badgeLingkungan = `
                    <span class="badge btn-info cursor-pointer btn-view-lingkungan"
                          data-id="${item.id}"
                          style="cursor:pointer">
                        ${countLingkungan} Parameter Terpilih
                    </span>`;

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
                $('#datasetTable').DataTable({ responsive: true });

                // Pasang event listener untuk modal detail
                this.initDetailEvents(responseData.data);
            }
        } catch (error) {
            console.error('Error fetching dataset:', error);
        }
    }
    initDetailEvents(allData) {
        const self = this;

        // Klik Detail Gejala
        $(document).off('click', '.btn-view-gejala').on('click', '.btn-view-gejala', function () {
            const id = $(this).data('id');
            const item = allData.find(d => d.id === id);

            let listHtml = '<ul class="list-group">';
            item.gejala.forEach(g => {
                listHtml += `<li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Kode Gejala: <b>${g}</b></li>`;
            });
            listHtml += '</ul>';

            self.showDetailModal('Detail Gejala Terpilih', listHtml);
        });

        // Klik Detail Lingkungan
        $(document).off('click', '.btn-view-lingkungan').on('click', '.btn-view-lingkungan', function () {
            const id = $(this).data('id');
            const item = allData.find(d => d.id === id);

            let listHtml = '<div class="table-responsive"><table class="table table-bordered table-striped"><thead><tr><th>Parameter</th><th>Kondisi</th></tr></thead><tbody>';
            Object.entries(item.lingkungan).forEach(([key, val]) => {
                let badgeColor = val === 'tinggi' ? 'danger' : (val === 'normal' ? 'success' : 'primary');
                listHtml += `<tr><td>${key}</td><td><span class="badge bg-${badgeColor}">${val.toUpperCase()}</span></td></tr>`;
            });
            listHtml += '</tbody></table></div>';

            self.showDetailModal('Detail Kondisi Lingkungan', listHtml);
        });
    }

    showDetailModal(title, content) {
        // Gunakan SweetAlert2 untuk modal detail yang cepat dan cantik
        Swal.fire({
            title: title,
            html: content,
            width: '600px',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#3085d6'
        });
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
            } else {
                errorAlert();
            }
        }
    }

    async getDataById(id, checkingEdit) {
        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/data-set/get/${id}`, 'GET');
            const data = responseData.data;

            await this.loadOptions();

            $('#modalDataset').modal('show');
            $('#id').val(data.id);

            $('#penyakit_id').val(data.penyakit_id).trigger('change');

            if (data.gejala && Array.isArray(data.gejala)) {
                data.gejala.forEach(kodeG => {
                    $(`input[name="gejala[]"][value="${kodeG}"]`).prop('checked', true);
                });
            }

            if (data.lingkungan && typeof data.lingkungan === 'object') {
                Object.entries(data.lingkungan).forEach(([parameter, nilai]) => {
                    const selector = `input[name="lingkungan[${parameter}]"][value="${nilai}"]`;
                    $(selector).prop('checked', true);
                });
            }

            if (typeof checkingEdit === 'function') {
                checkingEdit();
            }

        } catch (error) {
            console.error("Gagal mengambil data edit:", error);
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
