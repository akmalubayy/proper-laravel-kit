$(document).ready(function () {
    // Ambil CSRF token dari meta tag
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Gunakan event delegation
    $(document).on('click', '.delete-role', function () {
        const button = $(this);
        const roleId = button.data('role-id');
        const roleName = button.data('role-name');
        const deleteUrl = button.data('delete-url');

        if (!roleId || !deleteUrl) {
            console.error('Missing role ID or delete URL');
            return;
        }

        swal({
            title: 'Yakin?',
            text: `Role "${roleName}" akan dihapus permanen!`,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((confirmed) => {
            if (confirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        _token: csrfToken,      // ✅ Ambil dari meta tag
                        _method: 'DELETE'
                    },
                    success: function (response) {
                        swal({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Role berhasil dihapus.',
                            buttons: false,
                            timer: 1500,
                        }).then(() => {
                            button.closest('.accordion-item').fadeOut(300, function () {
                                $(this).remove();
                            });
                        });
                    },
                    error: function (xhr) {
                        let errorMsg = 'Gagal menghapus role.';
                        if (xhr.responseJSON?.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        swal({
                            icon: 'error',
                            title: 'Oops!',
                            text: errorMsg
                        });
                    }
                });
            }
        });
    });
});
