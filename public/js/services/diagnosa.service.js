/**
 * Diagnosa Service - Handle API calls
 */
class DiagnosaService {
    constructor(baseUrl = '') {
        this.baseUrl = baseUrl;
    }

    /**
     * Get all gejala data
     */
    async getGejala() {
        try {
            const response = await $.ajax({
                url: `${this.baseUrl}/naive-bayes/gejala/`,
                method: 'GET'
            });

            if (response.code === 200) {
                return response.data;
            }
            throw new Error('Failed to load gejala data');
        } catch (error) {
            console.error('Error loading gejala:', error);
            throw error;
        }
    }

    /**
     * Get all parameter lingkungan data
     */
    async getParameterLingkungan() {
        try {
            const response = await $.ajax({
                url: `${this.baseUrl}/naive-bayes/parameter-lingkungan/`,
                method: 'GET'
            });

            if (response.code === 200) {
                return response.data;
            }
            throw new Error('Failed to load parameter data');
        } catch (error) {
            console.error('Error loading parameter:', error);
            throw error;
        }
    }

    /**
     * Process diagnosa
     * @param {Object} kondisiLingkungan
     * @param {Array} gejalaDipilih
     */
    /**
     * Process diagnosa
     */
    async prosesDiagnosa(kondisiLingkungan, gejalaDipilih) {
        try {
            // Prepare data in EXACT format required by API
            const requestData = {
                kondisi_lingkungan: {
                    suhu_udara: parseFloat(kondisiLingkungan.suhu_udara),
                    kelembapan_udara: parseFloat(kondisiLingkungan.kelembapan_udara),
                    ph_tanah: parseFloat(kondisiLingkungan.ph_tanah),
                    intensitas_cahaya: parseFloat(kondisiLingkungan.intensitas_cahaya),
                    curah_hujan: parseFloat(kondisiLingkungan.curah_hujan),
                    kelembapan_tanah: parseFloat(kondisiLingkungan.kelembapan_tanah)
                },
                gejala: gejalaDipilih
            };

            console.log('Sending data to API:', JSON.stringify(requestData, null, 2));

            const response = await $.ajax({
                url: `${this.baseUrl}/naive-bayes/diagnosa/create`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                }
            });

            console.log('API Response:', response);
            return response;

        } catch (error) {
            console.error('Full error object:', error);
            console.error('Error status:', error.status);
            console.error('Error response:', error.responseJSON);
            console.error('Error responseText:', error.responseText);

            // Provide detailed error message
            let errorMessage = 'Terjadi kesalahan pada server';

            if (error.responseJSON) {
                if (error.responseJSON.errors) {
                    const errorMessages = Object.values(error.responseJSON.errors).flat();
                    errorMessage = errorMessages.join(', ');
                } else if (error.responseJSON.message) {
                    errorMessage = error.responseJSON.message;
                }
            } else if (error.responseText) {
                try {
                    const parsedError = JSON.parse(error.responseText);
                    if (parsedError.errors) {
                        const errorMessages = Object.values(parsedError.errors).flat();
                        errorMessage = errorMessages.join(', ');
                    }
                } catch (e) {
                    errorMessage = error.responseText;
                }
            }

            throw new Error(errorMessage);
        }
    }

    /**
     * Get riwayat diagnosa
     */
    async getRiwayat() {
        try {
            const response = await $.ajax({
                url: `${this.baseUrl}/naive-bayes/diagnosa/riwayat`,
                method: 'GET'
            });

            return response;
        } catch (error) {
            console.error('Error loading riwayat:', error);
            throw error;
        }
    }

    /**
     * Validate input values against parameter ideal ranges
     */
    validateInput(value, parameter) {
        const min = parseFloat(parameter.nilai_ideal_min);
        const max = parseFloat(parameter.nilai_ideal_max);

        if (value < min * 0.5 || value > max * 2) {
            return {
                status: 'danger',
                message: 'Nilai di luar batas wajar'
            };
        }

        if (value < min || value > max) {
            return {
                status: 'warning',
                message: 'Nilai di luar range ideal'
            };
        }

        return {
            status: 'success',
            message: 'Nilai optimal'
        };
    }

    /**
     * Validate data before sending
     */
    validateDataBeforeSend(kondisiLingkungan) {
        const errors = [];

        // Check all required fields are present
        const requiredFields = [
            'suhu_udara',
            'kelembapan_udara',
            'ph_tanah',
            'intensitas_cahaya',
            'curah_hujan',
            'kelembapan_tanah'
        ];

        requiredFields.forEach(field => {
            if (!kondisiLingkungan[field] && kondisiLingkungan[field] !== 0) {
                errors.push(`${this.formatFieldName(field)} harus diisi`);
            } else if (isNaN(parseFloat(kondisiLingkungan[field]))) {
                errors.push(`${this.formatFieldName(field)} harus berupa angka`);
            }
        });

        // Specific validations
        if (kondisiLingkungan.suhu_udara && (kondisiLingkungan.suhu_udara < 0 || kondisiLingkungan.suhu_udara > 50)) {
            errors.push('Suhu udara harus antara 0-50°C');
        }

        if (kondisiLingkungan.kelembapan_udara && (kondisiLingkungan.kelembapan_udara < 0 || kondisiLingkungan.kelembapan_udara > 100)) {
            errors.push('Kelembapan udara harus antara 0-100%');
        }

        if (kondisiLingkungan.ph_tanah && (kondisiLingkungan.ph_tanah < 0 || kondisiLingkungan.ph_tanah > 14)) {
            errors.push('pH tanah harus antara 0-14');
        }

        if (kondisiLingkungan.kelembapan_tanah && (kondisiLingkungan.kelembapan_tanah < 0 || kondisiLingkungan.kelembapan_tanah > 100)) {
            errors.push('Kelembapan tanah harus antara 0-100%');
        }

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
}
