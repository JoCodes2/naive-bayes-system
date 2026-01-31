class DiagnosaService {
    ajaxRequest(url, method, data = null) {
        return new Promise((resolve, reject) => {
            const isJson = typeof data === 'string';

            $.ajax({
                url,
                method,
                data,
                processData: isJson ? false : true,
                contentType: isJson ? 'application/json' : (data instanceof FormData ? false : 'application/x-www-form-urlencoded'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: (response) => resolve(response),
                error: (error) => reject(error),
            });
        });
    }

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
        const grouped = data.reduce((acc, item) => {
            if (!acc[item.nama_parameter]) acc[item.nama_parameter] = [];
            acc[item.nama_parameter].push(item);
            return acc;
        }, {});

        let html = '';
        Object.keys(grouped).forEach(paramName => {
            const options = grouped[paramName].sort((a, b) => {
                const order = { 'rendah': 1, 'normal': 2, 'tinggi': 3 };
                return order[a.nilai_label.toLowerCase()] - order[b.nilai_label.toLowerCase()];
            });

            html += `
        <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-100 p-3 sm:p-4 md:p-5 mb-3 sm:mb-4 shadow-sm">
            <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas ${this.getIconByParameter(paramName)} text-green-600 text-xs sm:text-sm md:text-base"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-xs sm:text-sm md:text-base">${paramName}</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-3">
                ${options.map(opt => `
                    <label class="relative flex flex-col p-2.5 sm:p-3 border-2 border-gray-50 rounded-lg sm:rounded-xl cursor-pointer hover:border-green-500 hover:bg-green-50/20 transition-all group has-[:checked]:border-green-500 has-[:checked]:bg-green-50/30">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[8px] sm:text-[9px] md:text-[10px] font-black uppercase ${opt.nilai_label.toLowerCase() === 'normal' ? 'text-green-600' : 'text-orange-500'}">
                                ${opt.nilai_label}
                            </span>
                            <input type="radio" name="lingkungan[${paramName}]" value="${opt.nilai_label}"
                                class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-600 focus:ring-green-500 pointer-events-none flex-shrink-0" required>
                        </div>
                        <div class="text-[9px] sm:text-[10px] md:text-[11px] font-bold text-gray-400">
                            ${opt.min_value} - ${opt.max_value} <span class="text-[7px] sm:text-[8px] tracking-tighter">${opt.satuan}</span>
                        </div>
                    </label>
                `).join('')}
            </div>
        </div>`;
        });

        $('#environmentParams').html(html);
    }

    renderGejala(data) {
        const grouped = data.reduce((acc, item) => {
            if (!acc[item.kategori]) acc[item.kategori] = [];
            acc[item.kategori].push(item);
            return acc;
        }, {});

        let html = '';
        Object.keys(grouped).sort().forEach(kategori => {
            const symptoms = grouped[kategori].sort((a, b) => a.kode_gejala.localeCompare(b.kode_gejala, undefined, { numeric: true }));
            const iconClass = this.getIconByKategori(kategori);

            html += `
        <div class="mb-6 sm:mb-8 md:mb-10">
            <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4 ml-1 sm:ml-2">
                <i class="fas ${iconClass} text-green-600 opacity-70 text-xs sm:text-sm"></i>
                <h3 class="font-black text-gray-400 uppercase text-[9px] sm:text-[10px] md:text-xs tracking-[0.2em] sm:tracking-[0.3em]">Observasi Bagian ${kategori}</h3>
            </div>

            <div class="space-y-2 sm:space-y-3">
                ${symptoms.map(item => `
                    <label class="flex items-start gap-3 sm:gap-4 md:gap-5 p-3 sm:p-4 md:p-5 border-2 border-gray-100 rounded-xl sm:rounded-2xl cursor-pointer hover:border-green-500 hover:bg-green-50/30 transition-all bg-white shadow-sm group">
                        <div class="mt-0.5 sm:mt-1 flex-shrink-0">
                            <input type="checkbox" name="gejala[]" value="${item.kode_gejala}" class="checkbox-custom w-4 h-4 sm:w-5 sm:h-5">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1.5 sm:gap-3 mb-1">
                                <span class="text-[8px] sm:text-[9px] md:text-[10px] bg-green-100 text-green-700 px-1.5 sm:px-2 py-0.5 rounded-md sm:rounded-lg font-black border border-green-200 inline-block w-fit">${item.kode_gejala}</span>
                                <span class="text-gray-800 font-bold text-sm sm:text-base group-hover:text-green-700 transition-colors break-words">${item.nama_gejala}</span>
                            </div>
                            <p class="text-[10px] sm:text-xs text-gray-400 leading-relaxed">
                                ${item.deskripsi || 'Perhatikan tanda-tanda kerusakan atau perubahan warna pada bagian ini.'}
                            </p>
                        </div>
                    </label>
                `).join('')}
            </div>
        </div>`;
        });

        $('#symptoms').html(html || '<p class="text-center text-gray-400 py-10 text-sm">Data gejala tidak tersedia</p>');
    }

    async prosesDiagnosa(e) {
        if (e) e.preventDefault();

        const namaPetani = $('#nama_petani').val();
        const $form = $(e.target);

        const ringkasanInput = {
            gejala: [],
            lingkungan: []
        };

        $form.find('input[name="gejala[]"]:checked').each(function () {
            ringkasanInput.gejala.push($(this).closest('label').find('span.text-sm, span.text-base').text().trim());
        });

        $form.find('input[name^="lingkungan"]:checked').each(function () {
            const paramName = $(this).attr('name').match(/\[(.*?)\]/)[1];
            const val = $(this).val();
            ringkasanInput.lingkungan.push(`${paramName}: ${val}`);
        });

        const dataToSend = {
            nama_petani: namaPetani,
            gejala: $form.find('input[name="gejala[]"]:checked').map(function () { return $(this).val(); }).get(),
            lingkungan: ringkasanInput.lingkungan.reduce((acc, curr) => {
                const [k, v] = curr.split(': ');
                acc[k] = v;
                return acc;
            }, {})
        };

        try {
            const response = await this.ajaxRequest(
                `${appUrl}/naive-bayes/diagnosa/create`,
                'POST',
                JSON.stringify(dataToSend)
            );

            if (response.code === 200) {
                $('#diagnosisForm').addClass('hidden');

                this.renderHasil(response.data, namaPetani, ringkasanInput);

                $('#resultContainer').removeClass('hidden');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    renderHasil(data, namaPetani, inputan) {
        const diagnosa = data.hasil;
        const keyakinan = data.keyakinan;

        $('#resultContent').html(`
        <div class="max-w-4xl mx-auto font-sans px-2 sm:px-4">
            <div id="captureArea" class="bg-white p-4 sm:p-6 md:p-8 rounded-xl sm:rounded-2xl md:rounded-3xl border border-gray-100 shadow-sm">
                <!-- Header Laporan - Responsive -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-2 border-gray-100 pb-3 sm:pb-4 mb-4 sm:mb-6 gap-2 sm:gap-3">
                    <div class="w-full sm:w-auto">
                        <p class="text-[8px] sm:text-[9px] md:text-[10px] text-green-600 font-black tracking-[0.15em] sm:tracking-[0.2em] uppercase">Laporan Diagnosa CabaiSense</p>
                        <h1 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 uppercase break-words">${namaPetani}</h1>
                    </div>
                    <div class="text-left sm:text-right w-full sm:w-auto">
                        <p class="text-[8px] sm:text-[9px] md:text-[10px] text-gray-400 font-bold uppercase tracking-wider sm:tracking-widest">Waktu Diagnosa</p>
                        <p class="text-[10px] sm:text-xs md:text-sm font-bold text-gray-700">${new Date().toLocaleString('id-ID')}</p>
                    </div>
                </div>

                <!-- Grid Input Summary - Responsive -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
                    <!-- Gejala Terdeteksi -->
                    <div class="p-2.5 sm:p-3 bg-gray-50 rounded-lg sm:rounded-xl border border-gray-100">
                        <h4 class="text-[8px] sm:text-[9px] md:text-[10px] font-black text-gray-400 uppercase mb-1.5 sm:mb-2">Gejala Terdeteksi</h4>
                        <div class="flex flex-wrap gap-1 sm:gap-1.5">
                            ${inputan.gejala.map(g => `<span class="bg-white text-green-700 text-[7px] sm:text-[8px] md:text-[9px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-green-100 shadow-sm">${g}</span>`).join('')}
                        </div>
                    </div>

                    <!-- Kondisi Lingkungan -->
                    <div class="p-2.5 sm:p-3 bg-gray-50 rounded-lg sm:rounded-xl border border-gray-100">
                        <h4 class="text-[8px] sm:text-[9px] md:text-[10px] font-black text-gray-400 uppercase mb-1.5 sm:mb-2">Kondisi Lingkungan</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-y-1 sm:gap-x-3 md:gap-x-4">
                            ${inputan.lingkungan.map(l => {
            const [lbl, val] = l.split(': ');
            return `<div class="flex justify-between items-center text-[7px] sm:text-[8px] md:text-[9px] border-b border-gray-200 sm:border-none pb-0.5 sm:pb-0">
                                    <span class="text-gray-400 truncate pr-1">${lbl}</span>
                                    <span class="font-bold text-gray-700 flex-shrink-0">${val}</span>
                                </div>`;
        }).join('')}
                        </div>
                    </div>
                </div>

                <!-- Hasil Diagnosa Card - Responsive -->
                <div class="bg-gray-100 p-3 sm:p-4 rounded-lg sm:rounded-xl mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-l-4 border-green-600 shadow-inner gap-2 sm:gap-0">
                    <div class="pr-0 sm:pr-2 w-full sm:w-auto">
                        <p class="text-[8px] sm:text-[9px] md:text-[10px] font-bold text-gray-400 uppercase">Penyakit Teridentifikasi</p>
                        <h2 class="text-base sm:text-lg md:text-2xl font-black text-gray-800 leading-tight">${diagnosa.nama_penyakit}</h2>
                    </div>
                    <div class="text-left sm:text-right min-w-[60px] sm:min-w-[70px]">
                        <span class="text-2xl sm:text-3xl font-black text-green-600">${keyakinan}</span>
                        <p class="text-[7px] sm:text-[8px] font-bold text-gray-400 uppercase">Keyakinan</p>
                    </div>
                </div>

                <!-- Treatment & Prevention Grid - Responsive -->
                <div class="grid grid-cols-1 gap-3 sm:gap-4">
                    <!-- Tindakan Perawatan -->
                    <div class="bg-green-50 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl md:rounded-2xl border border-green-200">
                        <h3 class="font-bold text-green-900 text-[10px] sm:text-xs md:text-sm mb-1.5 sm:mb-2 flex items-center gap-1.5 sm:gap-2">
                            <i class="fas fa-hand-holding-medical text-xs sm:text-sm"></i>
                            <span>Tindakan Perawatan</span>
                        </h3>
                        <div class="text-gray-700 text-[10px] sm:text-[11px] md:text-xs leading-relaxed whitespace-pre-line">${diagnosa.solusi_treatment}</div>
                    </div>

                    <!-- Langkah Pencegahan -->
                    <div class="bg-amber-50 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl md:rounded-2xl border border-amber-200">
                        <h3 class="font-bold text-amber-900 text-[10px] sm:text-xs md:text-sm mb-1.5 sm:mb-2 flex items-center gap-1.5 sm:gap-2">
                            <i class="fas fa-shield-alt text-xs sm:text-sm"></i>
                            <span>Langkah Pencegahan</span>
                        </h3>
                        <div class="text-gray-700 text-[10px] sm:text-[11px] md:text-xs leading-relaxed">${diagnosa.pencegahan}</div>
                    </div>
                </div>

                <!-- Footer Note - Responsive -->
                <div class="mt-4 sm:mt-6 text-center border-t border-dashed pt-3 sm:pt-4">
                    <p class="text-[7px] sm:text-[8px] md:text-[9px] text-gray-400 italic">Laporan ini dihasilkan secara otomatis oleh Sistem Pakar Naive Bayes CabaiSense.</p>
                </div>
            </div>

            <!-- Action Buttons - Responsive -->
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 mt-6 sm:mt-8 pb-8 sm:pb-10">
                <button id="btnSimpanFoto" class="w-full sm:flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 sm:py-3 md:py-4 rounded-lg sm:rounded-xl md:rounded-2xl shadow-lg transition-all flex items-center justify-center gap-1.5 sm:gap-2 text-xs sm:text-sm md:text-base">
                    <i class="fas fa-camera text-xs sm:text-sm"></i>
                    <span>Simpan Hasil</span>
                </button>
                <button onclick="location.reload()" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-500 font-bold py-2.5 sm:py-3 md:py-4 px-6 sm:px-8 rounded-lg sm:rounded-xl md:rounded-2xl transition-all flex items-center justify-center gap-1.5 sm:gap-2 text-xs sm:text-sm md:text-base">
                    <i class="fas fa-undo text-xs sm:text-sm"></i>
                    <span>Diagnosa kembali</span>
                </button>
            </div>
        </div>
    `);

        // Event Listener tetap sama
        $('#btnSimpanFoto').on('click', () => {
            this.ambilFotoLaporan(namaPetani);
        });
    }

    // Fungsi Baru untuk Mengonversi HTML ke Foto
    ambilFotoLaporan(namaPetani) {
        const element = document.getElementById('captureArea');
        const btn = document.getElementById('btnSimpanFoto');

        // Feedback visual saat memproses
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        btn.disabled = true;

        html2canvas(element, {
            scale: 2, // Meningkatkan kualitas gambar (HD)
            useCORS: true,
            backgroundColor: "#ffffff"
        }).then(canvas => {
            const image = canvas.toDataURL("image/png");
            const link = document.createElement('a');
            link.download = `Hasil_Diagnosa_${namaPetani.replace(/\s+/g, '_')}.png`;
            link.href = image;
            link.click();

            // Kembalikan tombol
            btn.innerHTML = '<i class="fas fa-camera"></i> Simpan Hasil';
            btn.disabled = false;
        });
    }
}

export default DiagnosaService;
