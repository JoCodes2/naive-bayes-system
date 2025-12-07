/**
 * Diagnosa Controller - Handle DOM manipulation and events
 */
class DiagnosaController {
    constructor(service) {
        this.service = service;
        this.gejalaData = [];
        this.parameterData = [];
        this.selectedGejala = [];
    }

    /**
     * Initialize controller
     */
    init() {
        this.bindEvents();
        this.loadData();
    }

    /**
     * Load initial data
     */
    async loadData() {
        try {
            // Load gejala and parameter data in parallel
            const [gejalaData, parameterData] = await Promise.all([
                this.service.getGejala(),
                this.service.getParameterLingkungan()
            ]);

            this.gejalaData = gejalaData;
            this.parameterData = parameterData;

            this.renderParameterForm();
            this.renderGejalaList();

            this.showAlert('success', 'Data berhasil dimuat');
        } catch (error) {
            this.showAlert('danger', 'Gagal memuat data. Silahkan refresh halaman.');
            console.error('Error loading data:', error);
        }
    }

    /**
     * Bind all event listeners
     */
    bindEvents() {
        // Form submission
        $('#diagnosaForm').on('submit', (e) => this.handleSubmit(e));

        // Checkbox events
        $(document).on('change', '.gejala-checkbox', (e) => this.handleGejalaCheck(e));

        // Input validation
        $(document).on('input', 'input[type="number"]', (e) => this.handleInputValidation(e));

        // Button handlers (will be bound dynamically)
        $(document).on('click', '#diagnosaLagiBtn', () => this.resetForm());
        $(document).on('click', '#lihatRiwayatBtn', () => this.goToRiwayat());
    }

    /**
     * Render parameter form
     */
    renderParameterForm() {
        let html = '<div class="row">';

        this.parameterData.forEach(param => {
            const fieldName = param.nama_parameter.toLowerCase().replace(/ /g, '_');

            html += `
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="${fieldName}" class="form-label">
                        ${param.nama_parameter}
                        <span class="text-muted">(${param.satuan})</span>
                    </label>
                    <input
                        type="number"
                        class="form-control"
                        id="${fieldName}"
                        name="kondisi_lingkungan[${fieldName}]"
                        step="0.1"
                        placeholder="Masukkan nilai ${param.nama_parameter.toLowerCase()}"
                        required
                        data-parameter="${fieldName}"
                    >
                    <div class="form-text">
                        <span id="status_${fieldName}">Ideal: ${param.nilai_ideal_min} - ${param.nilai_ideal_max} ${param.satuan}</span>
                    </div>
                </div>
            </div>
            `;
        });

        html += '</div>';
        $('#kondisiLingkunganForm').html(html);
    }

    /**
     * Render gejala list grouped by kategori
     */
    renderGejalaList() {
        let html = '';

        // Group gejala by kategori
        const gejalaByKategori = {};
        this.gejalaData.forEach(gejala => {
            if (!gejalaByKategori[gejala.kategori]) {
                gejalaByKategori[gejala.kategori] = [];
            }
            gejalaByKategori[gejala.kategori].push(gejala);
        });

        // Render each category
        Object.keys(gejalaByKategori).forEach(kategori => {
            const categoryName = kategori.charAt(0).toUpperCase() + kategori.slice(1);

            html += `
            <div class="col-12 mb-4 mt-3">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="fas fa-folder me-2"></i>
                            ${categoryName}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
            `;

            gejalaByKategori[kategori].forEach(gejala => {
                html += `
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="form-check">
                        <input
                            class="form-check-input gejala-checkbox"
                            type="checkbox"
                            value="${gejala.id}"
                            id="gejala_${gejala.id}"
                            name="gejala[]"
                            data-kategori="${gejala.kategori}"
                        >
                        <label class="form-check-label" for="gejala_${gejala.id}">
                            <strong>${gejala.kode_gejala}:</strong> ${gejala.deskripsi_gejala}
                        </label>
                    </div>
                </div>
                `;
            });

            html += `
                        </div>
                    </div>
                </div>
            </div>
            `;
        });

        $('#gejalaList').html(html);

        // Update counter
        this.updateGejalaCounter();
    }

    /**
     * Handle form submission
     */
    /**
     * Handle form submission
     */
    /**
     * Handle form submission
     */


    /**
     * Collect kondisi lingkungan data from form
     */
    /**
     * Collect kondisi lingkungan data from form
     */
    /**
     * Collect kondisi lingkungan data from form
     */
    collectKondisiLingkungan() {
        const kondisiLingkungan = {};

        // Map field names exactly as required by API
        const fieldMapping = {
            'suhu_udara': 'suhu_udara',
            'kelembapan_udara': 'kelembapan_udara',
            'ph_tanah': 'ph_tanah',
            'intensitas_cahaya': 'intensitas_cahaya',
            'curah_hujan': 'curah_hujan',
            'kelembapan_tanah': 'kelembapan_tanah'
        };

        Object.keys(fieldMapping).forEach(field => {
            const input = $(`#${field}`);
            if (input.length) {
                const value = parseFloat(input.val());
                if (!isNaN(value)) {
                    kondisiLingkungan[field] = value;
                } else {
                    kondisiLingkungan[field] = null;
                }
            }
        });

        return kondisiLingkungan;
    }

    /**
     * Validate form data before submission
     */
    validateFormData(kondisiLingkungan) {
        const errors = [];

        // Validation rules based on your Laravel validation
        const validationRules = {
            suhu_udara: { min: 0, max: 50, message: 'Suhu udara harus antara 0-50°C' },
            kelembapan_udara: { min: 0, max: 100, message: 'Kelembapan udara harus antara 0-100%' },
            ph_tanah: { min: 0, max: 14, message: 'pH tanah harus antara 0-14' },
            intensitas_cahaya: { min: 0, message: 'Intensitas cahaya harus positif' },
            curah_hujan: { min: 0, message: 'Curah hujan harus positif' },
            kelembapan_tanah: { min: 0, max: 100, message: 'Kelembapan tanah harus antara 0-100%' }
        };

        Object.keys(validationRules).forEach(field => {
            const value = kondisiLingkungan[field];
            const rule = validationRules[field];

            if (value === null || value === undefined) {
                errors.push(`${this.formatFieldName(field)} harus diisi`);
                $(`#${field}`).addClass('is-invalid');
            } else if (rule.min !== undefined && value < rule.min) {
                errors.push(`${this.formatFieldName(field)} minimal ${rule.min}`);
                $(`#${field}`).addClass('is-invalid');
            } else if (rule.max !== undefined && value > rule.max) {
                errors.push(`${this.formatFieldName(field)} maksimal ${rule.max}`);
                $(`#${field}`).addClass('is-invalid');
            } else {
                $(`#${field}`).removeClass('is-invalid');
            }
        });

        return errors;
    }

    formatFieldName(field) {
        const names = {
            'suhu_udara': 'Suhu Udara',
            'kelembapan_udara': 'Kelembapan Udara',
            'ph_tanah': 'pH Tanah',
            'intensitas_cahaya': 'Intensitas Cahaya',
            'curah_hujan': 'Curah Hujan',
            'kelembapan_tanah': 'Kelembapan Tanah'
        };
        return names[field] || field;
    }

    /**
     * Handle form submission
     */
    async handleSubmit(e) {
        e.preventDefault();

        // Validate gejala selection
        if (this.selectedGejala.length === 0) {
            this.showAlert('warning', 'Pilih minimal 1 gejala tanaman');
            return;
        }

        // Collect data
        const kondisiLingkungan = this.collectKondisiLingkungan();
        console.log('Kondisi Lingkungan:', kondisiLingkungan);
        console.log('Gejala Dipilih:', this.selectedGejala);

        // Validate form data
        const validationErrors = this.validateFormData(kondisiLingkungan);
        if (validationErrors.length > 0) {
            this.showAlert('danger', validationErrors.join(', '));
            return;
        }

        // Show loading
        this.showLoading(true);

        try {
            // Process diagnosa
            console.log('Sending request...');
            const response = await this.service.prosesDiagnosa(kondisiLingkungan, this.selectedGejala);
            console.log('Response received:', response);

            // Hide loading
            this.showLoading(false);

            if (response.success) {
                this.showHasilDiagnosa(response.data);
                this.showAlert('success', 'Diagnosa berhasil dilakukan!');
            } else {
                this.showAlert('danger', response.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            this.showLoading(false);
            console.error('Error in handleSubmit:', error);

            this.showAlert('danger', error.message || 'Terjadi kesalahan pada server');
        }
    }

    /**
     * Handle gejala checkbox change
     */
    handleGejalaCheck(e) {
        const checkbox = $(e.target);
        const gejalaId = checkbox.val();

        if (checkbox.is(':checked')) {
            this.selectedGejala.push(gejalaId);
        } else {
            const index = this.selectedGejala.indexOf(gejalaId);
            if (index > -1) {
                this.selectedGejala.splice(index, 1);
            }
        }

        this.updateGejalaCounter();
    }

    /**
     * Update gejala selection counter
     */
    updateGejalaCounter() {
        const counter = $('.gejala-checkbox:checked').length;
        const total = $('.gejala-checkbox').length;

        // Update any counter display if exists
        if ($('#gejalaCounter').length === 0) {
            $('#gejalaList').before(`
                <div class="alert alert-info" id="gejalaCounter">
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="counterText">Tidak ada gejala yang dipilih</span>
                </div>
            `);
        }

        const counterText = counter === 0
            ? 'Tidak ada gejala yang dipilih'
            : `Dipilih ${counter} dari ${total} gejala`;

        $('#counterText').text(counterText);
    }

    /**
     * Handle input validation for numbers
     */
    handleInputValidation(e) {
        const input = $(e.target);
        const value = parseFloat(input.val());
        const fieldName = input.attr('data-parameter');

        if (isNaN(value)) {
            input.removeClass('is-invalid is-warning is-valid');
            $(`#status_${fieldName}`).removeClass('text-danger text-warning text-success');
            return;
        }

        // Find matching parameter
        const param = this.parameterData.find(p =>
            p.nama_parameter.toLowerCase().replace(/ /g, '_') === fieldName
        );

        if (!param) return;

        const validation = this.service.validateInput(value, param);
        const statusElement = $(`#status_${fieldName}`);

        // Update input class
        input.removeClass('is-invalid is-warning is-valid');
        input.addClass(`is-${validation.status}`);

        // Update status text
        statusElement.removeClass('text-danger text-warning text-success');
        statusElement.addClass(`text-${validation.status}`);
        statusElement.html(`
            Ideal: ${param.nilai_ideal_min} - ${param.nilai_ideal_max} ${param.satuan}
            <br>
            <small><em>${validation.message}</em></small>
        `);
    }

    /**
     * Show diagnosa results
     */
    showHasilDiagnosa(data) {
        const hasil = data.diagnosa_terbaik;
        const semuaHasil = data.semua_hasil;

        const hasilHtml = this.generateHasilTemplate(hasil, semuaHasil);
        $('#hasilDiagnosa').html(hasilHtml).removeClass('d-none');

        // Scroll to results
        this.scrollToElement('#hasilDiagnosa');
    }

    /**
     * Generate HTML template for results
     */
    generateHasilTemplate(hasil, semuaHasil) {
        return `
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i>Hasil Diagnosa</h5>
            </div>
            <div class="card-body">
                <!-- Diagnosis Utama -->
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">
                        <i class="fas fa-diagnoses me-2"></i>Diagnosa: ${hasil.penyakit}
                    </h4>
                    <p class="mb-0">
                        <strong>Tingkat Kepercayaan:</strong> ${hasil.tingkat_kepercayaan}
                        <br>
                        <strong>Kode:</strong> ${hasil.kode_penyakit}
                    </p>
                </div>

                <div class="row">
                    <!-- Deskripsi Penyakit -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Deskripsi Penyakit</h6>
                            </div>
                            <div class="card-body">
                                <p>${this.formatText(hasil.deskripsi)}</p>
                                <p class="mb-0"><strong>Faktor Risiko:</strong> ${hasil.faktor_risiko}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Rekomendasi Perawatan -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0"><i class="fas fa-prescription-bottle-medical me-2"></i>Rekomendasi Perawatan</h6>
                            </div>
                            <div class="card-body">
                                <p>${this.formatText(hasil.rekomendasi_perawatan)}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pencegahan -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-shield-virus me-2"></i>Tindakan Pencegahan</h6>
                    </div>
                    <div class="card-body">
                        <p>${this.formatText(hasil.tindakan_pencegahan)}</p>
                    </div>
                </div>

                <!-- Semua Hasil -->
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Semua Kemungkinan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Penyakit</th>
                                        <th>Persentase</th>
                                        <th>Skor Gejala</th>
                                        <th>Skor Lingkungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${this.generateHasilTableRows(hasil, semuaHasil)}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Button Actions -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary me-2" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>Cetak Hasil
                    </button>
                    <button class="btn btn-success me-2" id="diagnosaLagiBtn">
                        <i class="fas fa-redo me-2"></i>Diagnosa Lagi
                    </button>
                    <button class="btn btn-outline-secondary" id="lihatRiwayatBtn">
                        <i class="fas fa-history me-2"></i>Lihat Riwayat
                    </button>
                </div>
            </div>
        </div>
        `;
    }

    /**
     * Generate table rows for all results
     */
    generateHasilTableRows(hasil, semuaHasil) {
        return semuaHasil.map(item => {
            const persentase = parseFloat(item.persentase);
            let progressBarClass = 'bg-danger';

            if (persentase > 70) progressBarClass = 'bg-success';
            else if (persentase > 40) progressBarClass = 'bg-warning';

            const isBest = item.penyakit === hasil.penyakit;
            const rowClass = isBest ? 'class="table-success"' : '';

            return `
            <tr ${rowClass}>
                <td>${item.penyakit}</td>
                <td>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar ${progressBarClass}"
                             role="progressbar"
                             style="width: ${item.persentase}"
                             aria-valuenow="${persentase}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                            ${item.persentase}
                        </div>
                    </div>
                </td>
                <td>${parseFloat(item.skor_gejala).toFixed(2)}</td>
                <td>${parseFloat(item.skor_lingkungan).toFixed(2)}</td>
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
     * Reset form for new diagnosa
     */
    resetForm() {
        // Reset form fields
        $('#diagnosaForm')[0].reset();

        // Reset gejala selection
        this.selectedGejala = [];
        $('.gejala-checkbox').prop('checked', false);

        // Hide results
        $('#hasilDiagnosa').addClass('d-none');

        // Reset validation classes
        $('input[type="number"]').removeClass('is-invalid is-warning is-valid');
        $('.form-text').removeClass('text-danger text-warning text-success');

        // Update counter
        this.updateGejalaCounter();

        // Scroll to top
        this.scrollToElement('body');
    }

    /**
     * Navigate to riwayat page
     */
    goToRiwayat() {
        window.location.href = '/api/diagnosa/riwayat';
    }

    /**
     * Show loading spinner
     */
    showLoading(show) {
        const submitBtn = $('#submitBtn');
        const loadingSpinner = $('#loadingSpinner');

        if (show) {
            submitBtn.prop('disabled', true);
            loadingSpinner.removeClass('d-none');
        } else {
            submitBtn.prop('disabled', false);
            loadingSpinner.addClass('d-none');
        }
    }

    /**
     * Show alert message
     */
    showAlert(type, message) {
        const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        `;

        $('#alertArea').html(alertHtml);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
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
