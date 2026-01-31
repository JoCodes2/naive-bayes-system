// assets/js/helpers/AlertComponent.js

const AlertComponent = {
    // 1. Loading Overlay (Menutup layar saat proses hitung)
    showLoading: function (show = true) {
        if (show) {
            const loader = `
                <div id="loading-overlay" class="fixed inset-0 z-[200] flex flex-col items-center justify-center bg-green-900/60 backdrop-blur-sm transition-opacity duration-300">
                    <div class="relative">
                        <div class="h-24 w-24 rounded-full border-t-4 border-b-4 border-white animate-spin"></div>
                        <i class="fas fa-pepper-hot text-red-500 text-3xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse"></i>
                    </div>
                    <p class="mt-4 text-white font-bold tracking-widest animate-pulse uppercase text-sm">Menghitung Probabilitas...</p>
                </div>`;
            $('body').append(loader);
        } else {
            $('#loading-overlay').fadeOut(300, function () { $(this).remove(); });
        }
    },

    // 2. Toast Notification (Success/Gagal)
    toast: function (message, type = 'success') {
        const id = 'toast-' + Math.random().toString(36).substr(2, 9);
        const config = {
            success: { bg: 'bg-emerald-600', icon: 'fa-check-circle' },
            error: { bg: 'bg-red-600', icon: 'fa-exclamation-circle' },
            warning: { bg: 'bg-amber-500', icon: 'fa-info-circle' }
        };

        const { bg, icon } = config[type];

        const html = `
            <div id="${id}" class="fixed top-5 right-5 z-[300] transform transition-all duration-500 translate-x-full">
                <div class="${bg} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border border-white/20">
                    <i class="fas ${icon} text-xl"></i>
                    <p class="text-sm font-semibold">${message}</p>
                    <button onclick="$('#${id}').addClass('translate-x-full'); setTimeout(()=>$('#${id}').remove(), 500);" class="ml-2 hover:scale-110 transition">
                        <i class="fas fa-times opacity-70"></i>
                    </button>
                </div>
            </div>`;

        $('body').append(html);
        setTimeout(() => $(`#${id}`).removeClass('translate-x-full'), 100);
        setTimeout(() => {
            $(`#${id}`).addClass('translate-x-full');
            setTimeout(() => $(`#${id}`).remove(), 500);
        }, 4000);
    },

    // 3. Validation Message (Inline Tailwind)
    showValidationError: function (message) {
        $('.validation-error-container').remove(); // Hapus yang lama
        const html = `
            <div class="validation-error-container bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl mb-4 flex items-center gap-3 animate-headshake">
                <i class="fas fa-exclamation-triangle"></i>
                <p class="text-xs font-bold uppercase tracking-tight">${message}</p>
            </div>`;
        $(html).insertBefore('#submitBtn');
    }
};

export default AlertComponent;
