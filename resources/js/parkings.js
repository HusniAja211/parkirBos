const scanInput = document.getElementById('member_id')
const printButton = document.getElementById('printButton')
const messageBox = document.getElementById('messageBox')

function showMessage(text, isError = false) {
    Swal.fire({
        title: isError ? 'Gagal!' : 'Berhasil!',
        text: text,
        icon: isError ? 'error' : 'success',
        timer: 2500,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    })
}

// Handler untuk tombol "Cetak Karcis"
printButton.addEventListener('click', () => {
    // Logika simulasi cetak karcis (misalnya, panggil API endpoint)
    console.log('Permintaan cetak karcis terkirim...')
    showMessage('Karcis masuk sedang dicetak. Silakan ambil!', false)
})

//Untuk menangani scan
let submitted = false;
document.getElementById("member_id").addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("scan-form").submit();
    }
});

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

const parkingForm = document.getElementById('parkingForm')