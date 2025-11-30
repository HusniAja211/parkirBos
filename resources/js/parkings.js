const scanInput = document.getElementById('member_id')
const printButton = document.getElementById('printButton')
const messageBox = document.getElementById('messageBox')

// Fungsi untuk menampilkan pesan status
function showMessage(text, isError = false) {
    messageBox.textContent = text
    messageBox.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700')
    if (isError) {
        messageBox.classList.add('bg-red-100', 'text-red-700')
        messageBox.classList.remove('bg-blue-100', 'text-blue-700')
    } else {
        messageBox.classList.add('bg-blue-100', 'text-blue-700')
        messageBox.classList.remove('bg-red-100', 'text-red-700')
    }
    setTimeout(() => {
        messageBox.classList.add('hidden')
    }, 3000)
}

// Handler untuk tombol "Cetak Karcis"
printButton.addEventListener('click', () => {
    // Logika simulasi cetak karcis (misalnya, panggil API endpoint)
    console.log('Permintaan cetak karcis terkirim...')
    showMessage('Karcis masuk sedang dicetak. Silakan ambil!', false)
})

// Handler untuk input scan kode
function handleScan(event) {
    if (event.key === 'Enter') {
        const code = scanInput.value.trim()
        scanInput.value = '' // Kosongkan input setelah di-scan/input

        if (code) {
            // Logika simulasi verifikasi kode
            console.log('Kode terdeteksi:', code)
            if (code.length > 5 && code.startsWith('TKT')) {
                // Contoh verifikasi yang lebih spesifik
                showMessage(`Kode Tiket '${code}' berhasil diverifikasi. Selamat Jalan!`, false)
            } else {
                showMessage(`Kode Tiket '${code}' tidak valid atau sudah kedaluwarsa.`, true)
            }
        }
    }
}

// Pastikan input selalu fokus untuk perangkat scanner/keyboard
scanInput.focus()
// Menambahkan event listener pada body untuk mengembalikan fokus ke input
document.body.addEventListener('click', () => {
    if (document.activeElement !== scanInput) {
        scanInput.focus()
    }
})
document.body.addEventListener('touchstart', () => {
    if (document.activeElement !== scanInput) {
        scanInput.focus()
    }
})

const dropdown = document.getElementById('kategoriDropdown')
const kategoriInput = document.getElementById('kategoriInput')
const parkingForm = document.getElementById('parkingForm')

// Saat tombol Cetak Karcis diklik → tampilkan dropdown
printButton.addEventListener('click', () => {
    dropdown.classList.toggle('hidden')
})

// Saat memilih kategori → submit form
dropdown.querySelectorAll('button[data-kategori]').forEach((button) => {
    button.addEventListener('click', () => {
        kategoriInput.value = button.dataset.kategori
        parkingForm.submit()
    })
})

// Jika scanner otomatis menekan Enter
    document.getElementById('member_id').addEventListener('change', function() {
        document.getElementById('scan-form').submit();
    });