/**
 * Diagnosa Controller - Handle DOM manipulation dengan Tailwind & jQuery Validate
 */
class DiagnosaControllerWeb {
    constructor(service) {
        this.service = service;
        this.gejalaData = [];
        this.parameterData = [];
        this.selectedGejala = [];
        this.validator = null;
    }

    /**
     * Initialize controller (SIMPLIFIED)
     */
    async init() {
        // loadData() menangani rendering dan setupValidation
        await this.loadData();
        this.bindEvents();
    }

    /**
     * Load initial data dan rendering form
     */
    async loadData() {
        let parameterRendered = false;
        let gejalaRendered = false;

        // --- Load Parameter Lingkungan ---
        const parameterResult = await this.service.getParameterLingkungan();
        console.log("Parameter Result:", parameterResult);

        if (parameterResult.success) {
            this.parameterData = parameterResult.data;
            this.renderParameterForm();
            parameterRendered = true;
        } else {
            const errMsg = parameterResult.message || 'Gagal memuat parameter lingkungan. Cek koneksi API.';
            $('#kondisiLingkunganForm').html(`<p class="text-red-500 font-bold p-4">${errMsg}</p>`);
        }

        // --- Load Gejala ---
        const gejalaResult = await this.service.getGejala();
        console.log("Gejala Result:", gejalaResult);

        if (gejalaResult.success) {
            this.gejalaData = gejalaResult.data;
            this.renderGejalaList();
            gejalaRendered = true;
        } else {
            const errMsg = gejalaResult.message || 'Gagal memuat data gejala. Cek koneksi API.';
            $('#gejalaList').html(`<p class="text-red-500 font-bold p-4">${errMsg}</p>`);
        }

        // Panggil setupValidation HANYA jika data parameter sukses dimuat
        if (parameterRendered && typeof $.fn.validate === 'function') {
            this.setupValidation();
            console.log("Setup Validation berhasil diinisialisasi.");
        } else if (parameterRendered && typeof $.fn.validate !== 'function') {
            console.error("jQuery Validate plugin is not loaded. Cannot set up form validation.");
        }
    }


    /**
     * Setup jQuery Validate dengan custom handling untuk Tailwind
     */
    setupValidation() {
        const { rules, messages } = this.service.getJqueryValidateRules(this.parameterData);

        this.validator = $('#diagnosaForm').validate({
            rules: {
                ...rules,
                'gejala[]': {
                    required: true
                }
            },
            messages: {
                ...messages,
                'gejala[]': {
                    required: "Pilih minimal 1 gejala tanaman"
                }
            },
            errorElement: 'p',
            errorClass: 'text-red-600 text-sm mt-1',

            highlight: (element, errorClass, validClass) => {
                if (element.name === 'gejala[]') {
                    this.applyGejalaErrorStyling();
                } else {
                    $(element).addClass('border-red-500').removeClass('border-gray-300');
                }
            },

            unhighlight: (element, errorClass, validClass) => {
                if (element.name !== 'gejala[]') {
                    $(element).removeClass('border-red-500').addClass('border-gray-300');
                }
                if ($('input[name="gejala[]"]:checked').length > 0) {
                    this.removeGejalaErrorStyling();
                }
            },

            errorPlacement: (error, element) => {
                if (element.attr("name") === "gejala[]") {
                    $('#gejalaErrorContainer').html(error);
                } else {
                    error.insertAfter(element);
                }
            },

            invalidHandler: (event, validator) => {
                if (validator.errorMap['gejala[]']) {
                    this.applyGejalaErrorStyling();
                }
                this.scrollToElement('.text-red-600:first', -100);
            },

            submitHandler: (form) => {
                this.handleSubmit(form);
                return false;
            }
        });
    }

    /**
     * Bind all event listeners
     */
    bindEvents() {
        $(document).on('change', 'input[name="gejala[]"]', (e) => {
            this.handleGejalaCheck(e);

            setTimeout(() => {
                if (this.validator) {
                    this.validator.element('[name="gejala[]"]');

                    if ($('input[name="gejala[]"]:checked').length > 0) {
                        this.removeGejalaErrorStyling();
                    } else if (!this.validator.element('[name="gejala[]"]')) {
                        this.applyGejalaErrorStyling();
                    }
                }
            }, 100);
        });

        $(document).on('click', '#diagnosaLagiBtn', () => this.resetForm());
    }

    /**
     * Apply error styling pada semua checkbox gejala (Tailwind)
     */
    applyGejalaErrorStyling() {
        $('input[name="gejala[]"]').addClass('ring-2 ring-red-500 border-red-500');
        $('input[name="gejala[]"] + label').addClass('text-red-500');
        $('#gejalaList').addClass('border border-red-500 bg-red-50');
    }

    /**
     * Remove error styling dari semua checkbox gejala (Tailwind)
     */
    removeGejalaErrorStyling() {
        $('input[name="gejala[]"]').removeClass('ring-2 ring-red-500 border-red-500');
        $('input[name="gejala[]"] + label').removeClass('text-red-500');
        $('#gejalaList').removeClass('border border-red-500 bg-red-50');
    }

    /**
     * Render parameter form (Tailwind)
     */
    renderParameterForm() {
        $('#kondisiLingkunganForm').empty();

        let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">';

        if (this.parameterData.length === 0) {
            console.error("RENDER ERROR: parameterData kosong saat renderParameterForm dipanggil!");
            $('#kondisiLingkunganForm').html('<p class="text-red-500">Data parameter tidak ditemukan.</p>');
            return;
        }

        this.parameterData.forEach(param => {
            const fieldName = param.nama_parameter.toLowerCase().replace(/ /g, '_');
            const min = param.nilai_ideal_min;
            const max = param.nilai_ideal_max;

            html += `
            <div>
                <label for="${fieldName}" class="block text-sm font-medium text-gray-700 mb-1">
                    ${param.nama_parameter}
                    <span class="text-xs text-gray-500">(${param.satuan})</span>
                </label>
                <input
                    type="number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150"
                    id="${fieldName}"
                    name="kondisi_lingkungan[${fieldName}]"
                    step="0.1"
                    placeholder="Masukkan nilai ${param.nama_parameter.toLowerCase()}"
                    data-parameter="${fieldName}"
                    data-min="${min || ''}"
                    data-max="${max || ''}"
                >
                <p class="text-xs text-gray-400 mt-1">
                    ${min !== null && max !== null
                    ? `Ideal: ${min} - ${max} ${param.satuan}`
                    : 'Tidak ada range ideal'}
                </p>
            </div>
            `;
        });

        html += '</div>';

        console.log("RENDER PARAMETER SUCCESS: HTML generated length:", html.length);

        $('#kondisiLingkunganForm').html(html);

        console.log("RENDER PARAMETER SUCCESS: DOM check:", $('#kondisiLingkunganForm').children().length, "children inserted.");
    }

    /**
     * Render gejala list grouped by kategori (Tailwind)
     */
    renderGejalaList() {
        $('#gejalaList').empty();

        let html = `
            <div id="gejalaErrorContainer" class="mb-4"></div>
            <div class="grid grid-cols-1 ">
        `;

        const gejalaByKategori = {};
        this.gejalaData.forEach(gejala => {
            if (!gejalaByKategori[gejala.kategori]) {
                gejalaByKategori[gejala.kategori] = [];
            }
            gejalaByKategori[gejala.kategori].push(gejala);
        });

        Object.keys(gejalaByKategori).forEach(kategori => {
            const categoryName = kategori.charAt(0).toUpperCase() + kategori.slice(1);
            const gejalaList = gejalaByKategori[kategori];

            html += `
            <div class="border border-gray-200 rounded-lg shadow-sm">
                <div class="p-3 bg-gray-100 rounded-t-lg">
                    <h6 class="text-base font-semibold text-gray-700 flex justify-between items-center">
                        <span class="flex items-center"><i class="fas fa-folder text-blue-500 mr-2"></i> ${categoryName}</span>
                        <span class="text-xs font-medium bg-gray-300 text-gray-800 px-2 py-0.5 rounded-full">${gejalaList.length} gejala</span>
                    </h6>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        `;

            const midIndex = Math.ceil(gejalaList.length / 2);

            const renderCheckboxes = (start, end) => {
                let colHtml = '<div>';
                for (let i = start; i < end; i++) {
                    const gejala = gejalaList[i];
                    colHtml += `
                    <div class="flex items-start mb-3">
                        <input
                            class="mt-1 h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 gejala-checkbox"
                            type="checkbox"
                            value="${gejala.id}"
                            id="gejala_${gejala.id}"
                            name="gejala[]"
                            data-kategori="${kategori}"
                        >
                        <label class="ml-3 text-sm font-medium text-gray-700 cursor-pointer" for="gejala_${gejala.id}">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">${gejala.kode_gejala}</span>
                            ${gejala.deskripsi_gejala}
                        </label>
                    </div>
                    `;
                }
                colHtml += '</div>';
                return colHtml;
            };

            html += renderCheckboxes(0, midIndex);
            if (gejalaList.length > 1) {
                html += renderCheckboxes(midIndex, gejalaList.length);
            }


            html += `
                    </div>
                </div>
            </div>
            `;
        });

        html += '</div>';

        console.log("RENDER GEJALA SUCCESS: HTML generated length:", html.length);

        $('#gejalaList').html(html);
    }

    /**
     * Handle form submission
     */
    async handleSubmit(form) {
        if (!this.validator || !this.validator.form()) {
            if (this.validator && this.validator.errorMap['gejala[]']) {
                this.applyGejalaErrorStyling();
            }
            return;
        }

        const kondisiLingkungan = this.collectKondisiLingkungan();

        this.showLoading(true);

        try {
            const result = await this.service.prosesDiagnosa(kondisiLingkungan, this.selectedGejala);

            this.showLoading(false);

            if (result.success) {
                if (typeof successAlert === 'function') successAlert(result.message);
                this.showHasilDiagnosa(result.data);
            } else {
                if (typeof errorAlert === 'function') errorAlert(result.message || 'Diagnosa gagal. Periksa data Anda.');
            }

        } catch (error) {
            this.showLoading(false);
            if (typeof errorAlert === 'function') errorAlert('Terjadi kesalahan koneksi saat memproses diagnosa.');
        }
    }

    /**
     * Collect kondisi lingkungan data from form
     */
    collectKondisiLingkungan() {
        const kondisiLingkungan = {};

        $('input[name^="kondisi_lingkungan["]').each(function () {
            const input = $(this);
            const fieldNameMatch = input.attr('name').match(/\[(.*?)\]/);

            if (fieldNameMatch && fieldNameMatch[1]) {
                const fieldName = fieldNameMatch[1];
                const value = input.val();

                kondisiLingkungan[fieldName] = value !== '' ? parseFloat(value) : null;
            }
        });

        return kondisiLingkungan;
    }

    /**
     * Handle gejala checkbox change
     */
    handleGejalaCheck(e) {
        const checkbox = $(e.target);
        const gejalaId = checkbox.val();

        if (checkbox.is(':checked')) {
            if (this.selectedGejala.indexOf(gejalaId) === -1) {
                this.selectedGejala.push(gejalaId);
            }
        } else {
            const index = this.selectedGejala.indexOf(gejalaId);
            if (index > -1) {
                this.selectedGejala.splice(index, 1);
            }
        }
    }

    /**
     * Show diagnosa results (Tailwind)
     */
    showHasilDiagnosa(data) {
        const hasil = data.diagnosa_terbaik;
        const semuaHasil = data.semua_hasil;

        const hasilHtml = this.generateHasilTemplate(hasil, semuaHasil);
        $('#hasilDiagnosa').html(hasilHtml).removeClass('hidden');

        this.scrollToElement('#hasilDiagnosa', -20);
    }

    /**
     * Generate HTML template for results (Tailwind)
     */
    generateHasilTemplate(hasil, semuaHasil) {
        return `
        <div class="bg-white border border-green-500 rounded-lg shadow-2xl">
            <div class="p-4 bg-green-600 rounded-t-lg text-white">
                <h5 class="text-xl font-bold mb-0 flex items-center"><i class="fas fa-file-medical mr-2"></i>Hasil Diagnosa Utama</h5>
            </div>
            <div class="p-6">
                <div class="p-4 mb-6 bg-green-50 border-l-4 border-green-500 text-green-900" role="alert">
                    <h4 class="text-2xl font-bold flex items-center">
                        <i class="fas fa-diagnoses mr-3 text-green-600"></i>Diagnosa: ${hasil.penyakit}
                    </h4>
                    <p class="mt-2 text-sm">
                        <strong>Tingkat Kepercayaan:</strong> <span class="font-bold">${hasil.tingkat_kepercayaan}</span>
                        <br>
                        <strong>Kode Penyakit:</strong> ${hasil.kode_penyakit}
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow-sm">
                        <div class="mb-3 border-b pb-2">
                            <h6 class="text-lg font-semibold text-blue-800 flex items-center"><i class="fas fa-info-circle mr-2"></i>Deskripsi Penyakit</h6>
                        </div>
                        <p class="text-sm text-gray-700">${this.formatText(hasil.deskripsi)}</p>
                        <p class="mt-3 text-sm font-semibold text-gray-800">Faktor Risiko: ${hasil.faktor_risiko}</p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-sm">
                        <div class="mb-3 border-b pb-2">
                            <h6 class="text-lg font-semibold text-yellow-800 flex items-center"><i class="fas fa-prescription-bottle-medical mr-2"></i>Rekomendasi Perawatan</h6>
                        </div>
                        <p class="text-sm text-gray-700">${this.formatText(hasil.rekomendasi_perawatan)}</p>
                    </div>
                </div>

                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 shadow-sm mt-6">
                    <div class="mb-3 border-b pb-2">
                        <h6 class="text-lg font-semibold text-indigo-800 flex items-center"><i class="fas fa-shield-virus mr-2"></i>Tindakan Pencegahan</h6>
                    </div>
                    <p class="text-sm text-gray-700">${this.formatText(hasil.tindakan_pencegahan)}</p>
                </div>

                <div class="mt-6 border border-gray-200 rounded-lg overflow-hidden">
                    <div class="p-3 bg-gray-700 text-white">
                        <h6 class="text-lg font-semibold flex items-center"><i class="fas fa-chart-bar mr-2"></i>Semua Kemungkinan</h6>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyakit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Gejala</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skor Lingkungan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                ${this.generateHasilTableRows(hasil, semuaHasil)}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center mt-8 space-x-4">
                    <button class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-150" onclick="window.print()">
                        <i class="fas fa-print mr-2"></i>Cetak Hasil
                    </button>
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150" id="diagnosaLagiBtn">
                        <i class="fas fa-redo mr-2"></i>Diagnosa Lagi
                    </button>
                </div>
            </div>
        </div>
        `;
    }

    /**
     * Generate table rows for all results (Tailwind)
     */
    generateHasilTableRows(hasil, semuaHasil) {
        return semuaHasil.map(item => {
            const persentase = parseFloat(item.persentase);
            let progressBarColor = 'bg-red-600';

            if (persentase > 70) progressBarColor = 'bg-green-500';
            else if (persentase > 40) progressBarColor = 'bg-yellow-500';

            const isBest = item.penyakit === hasil.penyakit;
            const rowClass = isBest ? 'bg-green-50 font-semibold' : 'hover:bg-gray-50';

            return `
            <tr class="${rowClass}">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.penyakit}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div class="w-full bg-gray-200 rounded-full h-5">
                        <div class="h-5 rounded-full ${progressBarColor} text-xs font-medium text-white text-center p-0.5 leading-none"
                             style="width: ${item.persentase}"
                             aria-valuenow="${persentase}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                            ${item.persentase}
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${parseFloat(item.skor_gejala).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${parseFloat(item.skor_lingkungan).toFixed(2)}</td>
            </tr>
            `;
        }).join('');
    }

    /**
     * Format text with line breaks
     */
    formatText(text) {
        return (text || '').replace(/\n/g, '<br>');
    }

    /**
     * Reset form for new diagnosa (Tailwind)
     */
    resetForm() {
        if (this.validator) {
            this.validator.resetForm();
        }
        $('#diagnosaForm')[0].reset();

        this.selectedGejala = [];
        $('input[name="gejala[]"]').prop('checked', false);

        this.removeGejalaErrorStyling();
        $('.w-full.px-4.py-2').removeClass('border-red-500').addClass('border-gray-300');

        $('#gejalaErrorContainer').empty();

        $('#hasilDiagnosa').addClass('hidden').empty();

        this.scrollToElement('body');

        if (typeof successAlert === 'function') {
            successAlert('Form berhasil direset');
        }
    }

    /**
     * Show loading spinner (Tailwind)
     */
    showLoading(show) {
        const submitBtn = $('#submitBtn');
        const loadingSpinner = $('#loadingSpinner');

        if (show) {
            submitBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
            loadingSpinner.removeClass('hidden');
        } else {
            submitBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
            loadingSpinner.addClass('hidden');
        }
    }

    /**
     * Scroll to element
     */
    scrollToElement(selector, offset = -20) {
        const element = $(selector);
        if (element.length) {
            $('html, body').animate({
                scrollTop: element.offset().top + offset
            }, 500);
        }
    }
}
