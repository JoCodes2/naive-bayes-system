class parameterService {
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

    async getAllData() {
        if ($.fn.dataTable.isDataTable('#parameterTable')) {
            $('#parameterTable').DataTable().clear().destroy();
        }

        $("#parameterTable tbody").empty();

        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/`, 'GET');

            if (responseData && responseData.data) {
                let tableBody = '';

                // TIPS: Jika backend belum mengurutkan, kita urutkan manual di sini (optional)
                responseData.data.sort((a, b) => a.nama_parameter.localeCompare(b.nama_parameter));

                responseData.data.forEach((item, index) => {
                    let btnClass = 'btn-secondary';
                    if (item.nilai_label === 'rendah') btnClass = 'btn-primary';
                    if (item.nilai_label === 'normal') btnClass = 'btn-success';
                    if (item.nilai_label === 'tinggi') btnClass = 'btn-danger';

                    tableBody += `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="fw-bold">${item.nama_parameter}</td>
                        <td class="text-center">${item.satuan ?? '-'}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm ${btnClass}" style="cursor: default; pointer-events: none; min-width: 90px;">
                                ${item.nilai_label.toUpperCase()}
                            </button>
                        </td>
                        <td class="text-center text-primary fw-bold">${item.min_value}</td>
                        <td class="text-center text-danger fw-bold">${item.max_value}</td>
                        <td class="text-center">
                           <div class="d-flex gap-2 justify-content-center">
                                <a href="javascript:void(0)" class="edit-parameter btn btn-icon btn-round btn-primary btn-sm" data-id="${item.id}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="javascript:void(0)" class="delete-parameter btn btn-icon btn-round btn-danger btn-sm" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`;
                });

                $("#parameterTable tbody").html(tableBody);

                $('#parameterTable').DataTable({
                    paging: true,
                    searching: true,
                    responsive: true,
                    // Urutkan berdasarkan kolom Nama Parameter (indeks 1) secara ASC
                    order: [[1, 'asc']],
                    pageLength: 15, // Set ke 15 agar semua range parameter (3 label x 5-6 param) terlihat
                    columnDefs: [
                        { targets: [0, 3, 6], orderable: false } // No, Label, dan Aksi tidak perlu di-sort
                    ]
                });
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    async upsertData(e, checkingEdit) {
        let submitButton = $('#btnSimpanParameter'); // Sesuai ID di Blade

        try {
            const formData = new FormData(e.target);
            let responseData;

            // Bersihkan error validasi sebelumnya
            $('.text-danger').text("");
            $('.form-control').removeClass('is-invalid');

            if (checkingEdit()) {
                const id = $('#id').val();
                responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/update/${id}`, 'POST', formData);
            } else {
                submitButton.attr('disabled', true);
                responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/create`, 'POST', formData);
            }

            successAlert("Data berhasil disimpan").then(() => {
                $('#modalParameter').modal('hide');
                location.reload(); // Refresh untuk update tabel
            });

        } catch (error) {
            submitButton.attr('disabled', false);

            if (error.status === 422) {
                const errors = error.responseJSON.data; // Sesuaikan dengan PenyakitRequest tadi
                $.each(errors, function (key, value) {
                    $(`#${key}-error`).text(value[0]);
                    $(`#${key}`).addClass('is-invalid');
                });
                warningAlert("Mohon periksa kembali inputan Anda");
                return;
            }
            errorAlert();
        }
    }

    async getDataById(id, checkingEdit) {
        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/get/${id}`, 'GET');
            const data = responseData.data;

            $('#modalParameter').modal('show');
            $('#modalParameter .modal-title').text('Edit Parameter Lingkungan');

            // Map data ke field baru
            $('#id').val(data.id);
            $('#nama_parameter').val(data.nama_parameter);
            $('#satuan').val(data.satuan);
            $('#nilai_label').val(data.nilai_label);
            $('#min_value').val(data.min_value);
            $('#max_value').val(data.max_value);

            checkingEdit();
        } catch (error) {
            console.error('Error fetching by ID:', error);
        }
    }

    async deleteData(id) {
        try {
            const result = await confirmDeleteAlert();
            if (result.isConfirmed) {
                const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/delete/${id}`, 'DELETE');
                if (responseData.code === 200 || responseData.status === 'success') {
                    await successAlert("Data berhasil dihapus").then(() => {
                        location.reload();
                    });
                } else {
                    errorAlert();
                }
            }
        } catch (error) {
            errorAlert();
        }
    }
}

export default parameterService;
