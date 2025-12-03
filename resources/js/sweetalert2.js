import Swal from 'sweetalert2';
window.Swal = Swal;

window.showSuccessAlert = function(message) {
    Swal.fire({
        title: "Berhasil!",
        text: message,
        icon: "success",
        timer: 2000,
        showConfirmButton: false
    });
}

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".delete-btn");
    if (!btn) return;

    const form = btn.closest("form");

    Swal.fire({
        title: "Yakin hapus data ini?",
        text: "Data tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
