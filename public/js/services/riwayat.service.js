class riwayatService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url,
                method,
                data,
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    async getAllData() {
        if ($.fn.dataTable.isDataTable('#riwayatTabel')) {
            $('#riwayatTabel').DataTable().clear().destroy();
        }

        try {
            const responseData = await this.ajaxRequest(`${appUrl}/naive-bayes/diagnosa/riwayat`, 'GET');
            const data = responseData.data; // Mengambil array data dari respons JSON
            let tableBody = "";

            data.forEach((item, index) => {
                const date = new Date(item.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit', month: 'short', year: 'numeric'
                });

                // KARENA lingkungan_input adalah Object, kita hitung jumlah key-nya
                const jumlahLingkungan = Object.keys(item.lingkungan_input || {}).length;
                // gejala_input adalah Array
                const jumlahGejala = (item.gejala_input || []).length;

                const inputButtons = `
                    <div class="d-flex flex-column gap-1">
                        <button class="btn btn-xs btn-info text-white mb-1" style="font-size: 10px; padding: 2px 5px; pointer-events: none; border:none; opacity: 0.9;">
                             <i class="fas fa-microscope mr-1"></i> ${jumlahLingkungan} Kondisi
                        </button>
                        <button class="btn btn-xs btn-success text-white" style="font-size: 10px; padding: 2px 5px; pointer-events: none; border:none; opacity: 0.9;">
                             <i class="fas fa-leaf mr-1"></i> ${jumlahGejala} Gejala
                        </button>
                    </div>
                `;

                tableBody += `
                <tr>
                    <td class="text-center align-middle">${index + 1}</td>
                    <td class="align-middle text-nowrap">${date}</td>
                    <td class="align-middle font-weight-bold text-uppercase" style="font-size: 0.85rem;">${item.nama_petani}</td>
                    <td class="align-middle">${inputButtons}</td>
                    <td class="align-middle">
                        <div class="d-flex flex-column">
                            <span class="font-weight-bold text-dark" style="line-height: 1.2;">${item.penyakit.nama_penyakit}</span>
                            <small class="badge badge-light text-muted border mt-1" style="width: fit-content;">${item.penyakit.kode_penyakit}</small>
                        </div>
                    </td>
                    <td class="text-center align-middle">
                        <div class="p-1" style="background: #f0fdf4; border-radius: 20px; border: 1px solid #bbf7d0;">
                            <span class="font-weight-bold text-success" style="font-size: 0.8rem;">
                                ${parseFloat(item.probabilitas).toFixed(2)}%
                            </span>
                        </div>
                    </td>
                </tr>
            `;
            });

            $("#riwayatTabel tbody").html(tableBody);

            $('#riwayatTabel').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari Riwayat:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ diagnosa",
                    paginate: {
                        previous: "<i class='fas fa-chevron-left'></i>",
                        next: "<i class='fas fa-chevron-right'></i>"
                    }
                }
            });

        } catch (error) {
            console.error("Error fetching data:", error);
            $("#riwayatTabel tbody").html('<tr><td colspan="7" class="text-center text-danger p-4">Gagal memuat data riwayat.</td></tr>');
        }
    }
}

export default riwayatService;
