class gejalaService {
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
        if ($.fn.dataTable.isDataTable('#gejalaTable')) {
            $('#gejalaTable').DataTable().clear().destroy();
        }

        $("#gejalaTable tbody").empty();

        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/gejala/`, 'GET');
            console.log(responseData);

            if (responseData && responseData.data) {
                console.log();

                let tableBody = '';
                responseData.data.forEach((item, index) => {
                    tableBody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.deskripsi}</td>
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm edit-gejala mr-1" data-toggle="modal" data-target="#modalGejala" data-id="${item.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="delete-gejala btn btn-outline-danger btn-sm" data-id="${item.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    `;
                });

                $("#gejalaTable tbody").html(tableBody);

                $('#gejalaTable').DataTable({
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
        let submitButton = $('#btnSimpanGejala');

        try {
            const formData = new FormData(form);
            let responseData;

            if (checkingEdit()) {
                const id = $('#id').val();
                responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/gejala/update/${id}`, 'POST', formData);
            } else {
                submitButton.attr('disabled', true);
                responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/gejala/create`, 'POST', formData);
            }
            if (responseData.code === 200) {
                successAlert().then(() => {
                    realoadBrowser();
                    $('#modalGejala').modal('hide');
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
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/gejala/get/${id}`, 'GET');
            console.log(responseData);
            $('#modalGejala').modal('show');
            $('#id').val(responseData.data.id);
            $('#nama').val(responseData.data.nama);
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
                const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/gejala/delete/${id}`, 'DELETE');
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

export default gejalaService;
