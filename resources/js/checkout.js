console.log("checkout.js loaded!");

document.addEventListener('DOMContentLoaded', function () {
    const kategoriSelect = document.getElementById('kategori');
    const totalFeeEl = document.getElementById('totalFee');

    // Ambil durasi parkir dari data attribute
    const durationMinutes = parseInt(document.getElementById('parkingData').dataset.duration);

    function calculateFee(durationMinutes, kategori) {
        let hours = Math.ceil(durationMinutes / 60);
        let baseHours = 3, baseRate, extraRate, maxFee;

        if (kategori === 'mobil') {
            baseRate = 3000 * 2;
            extraRate = 2000 * 2;
            maxFee = 10000 * 2;
        } else {
            baseRate = 3000;
            extraRate = 2000;
            maxFee = 10000;
        }

        let fee = hours <= baseHours ? baseRate : baseRate + (hours - baseHours) * extraRate;
        return Math.min(fee, maxFee);
    }

    function updateFee() {
        const kategori = kategoriSelect.value;
        if (!kategori) {
            totalFeeEl.textContent = 'Rp 0';
            return;
        }
        const fee = calculateFee(durationMinutes, kategori);
        totalFeeEl.textContent = 'Rp ' + fee.toLocaleString('id-ID');
    }

    // Update saat load
    updateFee();

    // Update saat kategori berubah
    kategoriSelect.addEventListener('change', updateFee);
});
