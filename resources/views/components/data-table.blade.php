<!-- Start Content -->
<div class="container-xxl">
    @if($showBulkActions)
    <div class="mb-3 card-body">
        <div class="row">
            <div class="col-12 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                <div class="action-btn show-btn" style="display: none">
                    <button class="delete-multiple btn-danger btn me-2 text-white d-flex align-items-center font-medium"
                        id="btnDeleteAll-{{ $tableId }}">
                        <i class="ti ti-trash text-danger me-1 fs-5"></i> Delete All
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">{{ $cardTitle }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <section class="datatables">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive m-t-40">
                                            <table class="table display table-bordered table-striped no-wrap"
                                                id="{{ $tableId }}">
                                                <thead>
                                                    {{ $slot }}
                                                </thead>
                                                <tbody>
                                                    <!-- DataTables -->
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="token-{{ $tableId }}" name="_token"
                                                value="{{ csrf_token() }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@push('addon-style')
<link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@push('addon-script')
<script src="{{ asset('init/modules/action.js') }}?v={{ filemtime(public_path('init/modules/action.js')) }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        let {{ $tableId }} = $('#{{ $tableId }}').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            autoWidth: false,
            scrollX: false,
            aaSorting: [],
            ajax: {
                url: '{{ $ajaxUrl }}',
            },
            columns: {!! json_encode($columns) !!}
        });

        // STATUS CHANGE Handler
        @if($statusChangeRoute)
        $('body').on('change', '#{{ $tableId }} .statusChange', function() {
            const status = $(this).prop('checked') == true ? 1 : 0;
            let id = $(this).attr('data-id');
            const name = $(this).attr('data-name');
            const route = "{{ $statusChangeRoute }}"

            $.ajax({
                type: "GET",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: route,
                data: {
                    'is_active': status,
                    'id': id
                },
                success: function (data) {
                    swal({
                        title: "Success!",
                        text: "Status " + name + " Berhasil diubah",
                        icon: "success",
                        buttons: false,
                        timer: '2000',
                    });
                }
            });
        });
        @endif

        // Inisialisasi Action.js
        @if($moduleName)
        action.init({
            tableId: '{{ $tableId }}',
            moduleName: '{{ $moduleName }}',
            singleDeleteRoute: "{{ $singleDeleteRoute }}",
            multipleDeleteRoute: "{{ $multipleDeleteRoute }}",
        });
        @endif
    });
</script>
@endpush