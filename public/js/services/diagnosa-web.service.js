class DiagnosaService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            const isJson = typeof data === 'string'; // Cek apakah data sudah di-JSON.stringify

            $.ajax({
                url,
                method,
                data,
                // Jika kita kirim JSON string, processData harus false
                processData: isJson ? false : true,
                // Pastikan contentType benar
                contentType: isJson ? 'application/json' : (data instanceof FormData ? false : 'application/x-www-form-urlencoded'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json' // Sangat penting agar Laravel kirim error JSON, bukan HTML
                },
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

    // Mapping Ikon untuk Kondisi Lingkungan
    getIconByParameter(param) {
        const p = param.toLowerCase();
        if (p.includes('suhu')) return 'fa-temperature-high text-orange-500';
        if (p.includes('kelembapan udara')) return 'fa-wind text-blue-400';
        if (p.includes('kelembapan tanah')) return 'fa-faucet-drip text-blue-600';
        if (p.includes('ph tanah')) return 'fa-vial text-purple-500';
        if (p.includes('intensitas cahaya')) return 'fa-sun text-yellow-500';
        if (p.includes('curah hujan')) return 'fa-cloud-showers-heavy text-blue-700';
        return 'fa-cloud-sun text-green-600';
    }

    // Mapping Ikon untuk Gejala (Berdasarkan Kategori di Seeder)
    getIconByKategori(kat) {
        const k = kat.toLowerCase();
        switch (k) {
            case 'daun': return 'fa-leaf text-green-500';
            case 'buah': return 'fa-pepper-hot text-red-500';
            case 'batang': return 'fa-tree text-amber-700';
            case 'akar': return 'fa-seedling text-amber-900';
            default: return 'fa-stethoscope text-green-600';
        }
    }

    async initForm() {
        try {
            const [resGejala, resLingkungan] = await Promise.all([
                this.ajaxRequest(`${appUrl}/naive-bayes/gejala/`, 'GET'),
                this.ajaxRequest(`${appUrl}/naive-bayes/parameter-lingkungan/`, 'GET')
            ]);

            if (resGejala && resGejala.data) this.renderGejala(resGejala.data);
            if (resLingkungan && resLingkungan.data) this.renderLingkungan(resLingkungan.data);
        } catch (error) {
            console.error('Gagal inisialisasi form:', error);
        }
    }

    renderLingkungan(data) {
        let html = '';
        data.forEach(item => {
            const iconClass = this.getIconByParameter(item.nama_parameter);
            html += `
                <label class="flex items-center gap-3 p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-green-500 hover:bg-green-50 transition card-hover bg-white shadow-sm">
                    <input type="checkbox" name="lingkungan[${item.nama_parameter}]" value="${item.nilai_label}" class="checkbox-custom">
                    <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50">
                        <i class="fas ${iconClass} text-xl"></i>
                    </div>
                    <div>
                        <span class="text-gray-700 font-semibold block text-sm">${item.nama_parameter}</span>
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider italic">
                            ${item.nilai_label} (${item.min_value}-${item.max_value} ${item.satuan})
                        </span>
                    </div>
                </label>`;
        });
        $('#environmentParams').html(html || '<p>Data tidak tersedia</p>');
    }

    renderGejala(data) {
        // Sort G01, G02, dst
        const sortedData = data.sort((a, b) => a.kode_gejala.localeCompare(b.kode_gejala, undefined, { numeric: true }));

        let html = '';
        sortedData.forEach(item => {
            const iconClass = this.getIconByKategori(item.kategori);
            html += `
                <label class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:border-green-500 hover:bg-green-50 transition bg-white shadow-sm group">
                    <input type="checkbox" name="gejala[]" value="${item.kode_gejala}" class="checkbox-custom">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-50 group-hover:bg-white transition">
                        <i class="fas ${iconClass} text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <span class="text-gray-700 font-medium block text-sm md:text-base">${item.nama_gejala}</span>
                        <div class="flex gap-2 items-center mt-1">
                            <span class="text-[10px] bg-green-600 text-white px-2 py-0.5 rounded font-black">${item.kode_gejala}</span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">${item.kategori}</span>
                        </div>
                    </div>
                </label>`;
        });
        $('#symptoms').html(html);
    }

    async prosesDiagnosa(e) {
        const $form = $(e.target);

        // Susun data manual agar strukturnya PERSIS seperti Postman
        const dataToSend = {
            gejala: [],
            lingkungan: {}
        };

        // Ambil semua gejala yang dicentang
        $form.find('input[name="gejala[]"]:checked').each(function () {
            dataToSend.gejala.push($(this).val());
        });

        // Ambil semua lingkungan yang dicentang
        // Kita parsing name="lingkungan[Nama Parameter]" menjadi key "Nama Parameter"
        $form.find('input[name^="lingkungan"]:checked').each(function () {
            const fullPath = $(this).attr('name'); // misal: lingkungan[Suhu Udara]
            const key = fullPath.match(/\[(.*?)\]/)[1]; // Ambil teks di dalam kurung [ ]
            dataToSend.lingkungan[key] = $(this).val();
        });

        try {
            // Kirim dataToSend sebagai JSON String
            const response = await this.ajaxRequest(
                `${appUrl}/naive-bayes/diagnosa/create`,
                'POST',
                JSON.stringify(dataToSend)
            );

            console.log("Response API:", response);

            if (response.code === 200) {
                this.renderHasil(response.data);
                $('#resultContainer').removeClass('hidden');
                $('html, body').animate({
                    scrollTop: $("#resultContainer").offset().top - 50
                }, 500);

                return response;
            } else {
                throw new Error(response.message || "Gagal Diagnosa");
            }
        } catch (error) {
            // Jika 422, detail error biasanya ada di error.responseJSON
            console.error('Error Detail dari Laravel:', error.responseJSON);
            throw error;
        }
    }
    renderHasil(data) {
        // Sesuai JSON: hasil diagnosa ada di data.hasil
        const diagnosa = data.hasil;
        const detail = data.detail_perhitungan;
        const keyakinan = data.keyakinan;

        // Mapping List Probabilitas
        let probHtml = '';
        detail.forEach(item => {
            // Gunakan item.persentase sesuai JSON Anda
            const percent = parseFloat(item.persentase).toFixed(2);
            probHtml += `
            <div class="space-y-1">
                <div class="flex justify-between text-sm">
                    <span class="font-medium text-gray-700">${item.nama_penyakit}</span>
                    <span class="text-green-600 font-bold">${percent}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                    <div class="bg-green-500 h-full transition-all duration-1000" style="width: ${percent}%"></div>
                </div>
            </div>`;
        });

        $('#resultContent').html(`
        <div class="gradient-bg p-8 rounded-2xl text-white mb-8 shadow-lg">
            <p class="text-xs uppercase tracking-widest font-bold opacity-80 mb-2">Hasil Diagnosa Tertinggi</p>
            <h2 class="text-4xl font-extrabold mb-2">${diagnosa.nama_penyakit}</h2>
            <div class="flex items-center gap-2">
                <span class="text-5xl font-black">${keyakinan}</span>
                <span class="text-xs opacity-80 uppercase leading-none">Tingkat<br>Keyakinan</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                <h4 class="font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-info-circle text-blue-500"></i> Deskripsi
                </h4>
                <p class="text-sm text-gray-600 leading-relaxed">${diagnosa.deskripsi}</p>
            </div>
            <div class="bg-green-50 p-5 rounded-xl border border-green-100 shadow-sm">
                <h4 class="font-bold text-green-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-hand-holding-medical text-green-600"></i> Solusi & Treatment
                </h4>
                <div class="text-sm text-green-700 whitespace-pre-line">${diagnosa.solusi_treatment}</div>
            </div>
        </div>

        <div class="bg-amber-50 p-5 rounded-xl border border-amber-100 shadow-sm mb-8">
            <h4 class="font-bold text-amber-800 mb-2 flex items-center gap-2">
                <i class="fas fa-shield-alt text-amber-600"></i> Langkah Pencegahan
            </h4>
            <p class="text-sm text-amber-700">${diagnosa.pencegahan}</p>
        </div>

        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Distribusi Probabilitas Penyakit Lain</h4>
            <div class="space-y-5">
                ${probHtml}
            </div>
        </div>
    `);
    }
}

export default DiagnosaService;
