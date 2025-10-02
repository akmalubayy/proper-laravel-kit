window.action = {
    init: function (options) {
        this.tableId = options.tableId;
        this.moduleName = options.moduleName;
        this.singleDeleteRoute = options.singleDeleteRoute;
        this.multipleDeleteRoute = options.multipleDeleteRoute;
        this.checkboxName = options.checkboxName || 'column_checkbox';
        this.mainCheckboxSelector = options.mainCheckboxSelector || 'input[name="main_checkbox"]';
        this.deleteButtonSelector = options.deleteButtonSelector || `button#btnDeleteAll-${options.tableId}`;
        this.deleteWrapperSelector = options.deleteWrapperSelector || '.show-btn';

        this.token = $('meta[name="csrf-token"]').attr('content');
        this.table = $('#' + this.tableId);

        this.bindEvents();
    },

    bindEvents: function () {
        const self = this;

        // Delete single item
        $('body').on('click', '.delete', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            let route = self.singleDeleteRoute.replace(':id', id);

            swal({
                title: 'Yakin?',
                text: `Hapus ${self.moduleName} ${name}?`,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    $.ajax({
                        type: 'POST',
                        url: route,
                        data: { _token: self.token, _method: "DELETE" },
                        success: function (response) {
                            if (response.code === 200) {
                                self.table.DataTable().ajax.reload(null, false);
                                toastr.success(`${self.moduleName} berhasil dihapus`);
                            } else {
                                toastr.error(response.message)
                            }
                        },
                        error: function () {
                            toastr.error(`Gagal menghapus ${self.moduleName}`);
                        }
                    });
                }
            });
        });

        // Delete multiple items
        $(document).on('click', self.deleteButtonSelector, function () {
            const ids = $(`input[name="${self.checkboxName}"]:checked`).map(function () {
                return $(this).data('id');
            }).get();

            if (ids.length === 0) {
                toastr.warning(`Pilih minimal satu ${self.moduleName} untuk dihapus`);
                return;
            }

            swal({
                title: 'Yakin?',
                text: `Hapus ${ids.length} ${self.moduleName}?`,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    $.ajax({
                        url: self.multipleDeleteRoute,
                        type: 'DELETE',
                        data: {
                            _token: self.token,
                            ids: ids,
                        },
                        success: function (response) {
                            if (response.code === 200) {
                                self.table.DataTable().ajax.reload(null, false);
                                toastr.success(response.message);
                                $(self.deleteWrapperSelector).hide();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            toastr.error(`Gagal menghapus ${self.moduleName}`);
                        }
                    });
                }
            });
        });

        // Checkbox toggle
        $(document).on('click', self.mainCheckboxSelector, function () {
            const checked = this.checked;
            $(`input[name="${self.checkboxName}"]`).prop('checked', checked);
            self.toggleDeleteAllBtn();
        });

        $(document).on('change', `input[name="${self.checkboxName}"]`, function () {
            const all = $(`input[name="${self.checkboxName}"]`).length;
            const checked = $(`input[name="${self.checkboxName}"]:checked`).length;
            $(self.mainCheckboxSelector).prop('checked', all === checked);
            self.toggleDeleteAllBtn();
        });
    },

    toggleDeleteAllBtn: function () {
        const total = $(`input[name="${this.checkboxName}"]`).length;
        const checked = $(`input[name="${this.checkboxName}"]:checked`).length;
        const $btn = $(this.deleteButtonSelector);
        const $wrapper = $(this.deleteWrapperSelector);

        if (checked > 0) {
            $wrapper.show();
            const trashIcon = '<i class="ti ti-trash text-danger me-1 fs-5"></i>';
            if (checked === total) {
                $btn.html(`${trashIcon} Delete All`);
            } else {
                $btn.html(`${trashIcon} Delete (${checked})`);
            }
        } else {
            $wrapper.hide();
        }
    }
};
