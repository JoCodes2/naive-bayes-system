class rekomendasiService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                processData: false,
                contentType: false,
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    async getAllData() {
        if ($.fn.dataTable.isDataTable('#rekomendasiTable')) {
            $('#rekomendasiTable').DataTable().clear().destroy();
        }

        $("#rekomendasiTable tbody").empty();

        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/rekomendasi/`, 'GET');
            console.log(responseData);

            if (responseData && responseData.data) {
                console.log();

                let tableBody = '';
                responseData.data.forEach((item, index) => {
                    tableBody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.judul}</td>
                        <td>${item.deskripsi}</td>
                        <td class="text-center">
                           <div class="d-flex gap-2">
                                <a href="#" class="edit-rekomendasi" data-id="${item.id}" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a href="#" class="delete-rekomendasi" data-id="${item.id}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    `;
                });

                $("#rekomendasiTable tbody").html(tableBody);

                $('#rekomendasiTable').DataTable({
                    paging: true,
                    searching: true,
                    responsive: true,
                    order: [[0, 'asc']],
                    pageLength: 5,
                    lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                });
            } else {
                console.error('Response data is invalid:', responseData);
            }
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    async upsertData(form, checkingEdit) {
        let submitButton = $('#btnSimpanRekomendasi');

        try {
            const formData = new FormData(form);
            let responseData;

            if (checkingEdit()) {
                const id = $('#id').val();
                responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/rekomendasi/update/${id}`, 'POST', formData);
            } else {
                submitButton.attr('disabled', true);
                responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/rekomendasi/create`, 'POST', formData);
            }
            if (responseData.code === 200) {
                successAlert().then(() => {
                    realoadBrowser();
                    $('#modalRekomendasi').modal('hide');
                });
            } else {
                warningAlert();
            }

            submitButton.attr('disabled', false);

        } catch (error) {
            submitButton.attr('disabled', false);
            errorAlert();
            console.error('Error:', error);
        }
    }


    async getDataById(id, checkingEdit) {
        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/rekomendasi/get/${id}`, 'GET');
            console.log(responseData);
            $('#modalRekomendasi').modal('show');
            $('#id').val(responseData.data.id);
            $('#judul').val(responseData.data.judul);
            $('#deskripsi').val(responseData.data.deskripsi);
            checkingEdit();
        } catch (error) {
            console.log(error);
        }
    }

    async deleteData(id) {
        try {
            const result = await confirmDeleteAlert();
            if (result.isConfirmed) {
                const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/rekomendasi/delete/${id}`, 'DELETE');
                console.log(responseData);
                if (responseData.code === 200) {
                    await successAlert().then(() => {
                        realoadBrowser();
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

export default rekomendasiService;
