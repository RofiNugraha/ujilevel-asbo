<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>
<style>
/* Custom SweetAlert styles for white and yellow theme */
.custom-swal-container {
    background-color: rgba(255, 255, 255, 0.9);
}

.custom-swal-popup {
    background-color: white;
    border: 2px solid #FFD700;
    border-radius: 20px;
}

.custom-swal-title {
    color: #212E80;
}

.custom-swal-content {
    color: #333;
}

.custom-swal-confirm {
    background-color: #FFD700 !important;
    color: #212E80 !important;
    border-radius: 10px !important;
    font-weight: bold !important;
}

.custom-swal-cancel {
    background-color: #f1f1f1 !important;
    color: #333 !important;
    border-radius: 10px !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for flash messages
    if (session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('
            success ') }}',
            icon: 'success',
            customClass: {
                container: 'custom-swal-container',
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                content: 'custom-swal-content',
                confirmButton: 'custom-swal-confirm'
            },
            buttonsStyling: false
        });
    endif

    if (session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: '{{ session('
            error ') }}',
            icon: 'error',
            customClass: {
                container: 'custom-swal-container',
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                content: 'custom-swal-content',
                confirmButton: 'custom-swal-confirm'
            },
            buttonsStyling: false
        });
    endif
});
</script>