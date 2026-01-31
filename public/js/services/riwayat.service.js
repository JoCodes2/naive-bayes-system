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
            const data = responseData.data;
            let tableBody = "";

            data.forEach((item, index) => {
                const date = new Date(item.created_at).toLocaleDateString('id-ID', {
                    day: '2-digit', month: 'short', year: 'numeric'
                });

                // GANTI BADGE KE BTN (Gunakan btn-sm agar tidak terlalu besar di dalam tabel)
                const inputButtons = `
                    <div class="d-flex flex-column gap-1">
                        <button class="btn btn-xs btn-info text-white mb-1" style="font-size: 10px; padding: 2px 5px; pointer-events: none;">
                             <i class="fas fa-microscope mr-1"></i> ${item.lingkungan_input.length} Kondisi
                        </button>
                        <button class="btn btn-xs btn-success text-white" style="font-size: 10px; padding: 2px 5px; pointer-events: none;">
                             <i class="fas fa-leaf mr-1"></i> ${item.gejala_input.length} Gejala
                        </button>
                    </div>
                `;

                tableBody += `
                <tr>
                    <td class="text-center align-middle">${index + 1}</td>
                    <td class="align-middle text-nowrap">${date}</td>
                    <td class="align-middle">${inputButtons}</td>
                    <td class="align-middle">
                        <div class="d-flex flex-column">
                            <span class="font-weight-bold text-dark">${item.penyakit.nama_penyakit}</span>
                            <small class="text-muted font-weight-bold">${item.penyakit.kode_penyakit}</small>
                        </div>
                    </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-sm btn-primary font-weight-bold" style="pointer-events: none; border-radius: 20px; width: 80px;">
                            ${parseFloat(item.probabilitas).toFixed(2)}%
                        </button>
                    </td>
                    <td class="text-center align-middle">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary btn-detail"
                                    data-id="${item.id}"
                                    title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            });

            $("#riwayatTabel tbody").html(tableBody);

            $('#riwayatTabel').DataTable({
                responsive: true,
                autoWidth: false,
            });

        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }
}

export default riwayatService;
