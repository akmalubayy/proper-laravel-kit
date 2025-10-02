<x-master-layout>
    @push('addon-style')
    <link rel="stylesheet" href="{{ asset('assets/libs/listree/listree.min.css') }}" />
    @endpush

    @section('title') Permission Tree @endsection

    <div class="container-xxl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Permission Tree</h4>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addPermission">
                                    + Tambah Permission
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        @if($grouped['models']->isEmpty() && $grouped['manual']->isEmpty())
                        <div class="text-center py-5 text-muted">
                            Belum ada permission.
                        </div>
                        @else
                        <ul class="listree" id="permissionTree">
                            {{-- Group: Berdasarkan Model --}}
                            @foreach($grouped['models'] as $model => $permissions)
                            <li>
                                <div class="listree-submenu-heading">
                                    {{ ucfirst($model) }}
                                    <span class="badge bg-secondary ms-2">{{ $permissions->count() }}</span>
                                </div>
                                <ul class="listree-submenu-items">
                                    @foreach($permissions as $perm)
                                    <li>
                                        <a href="#"
                                            onclick="deletePermission({{ $perm->id }}, '{{ addslashes($perm->name) }}'); return false;">
                                            {{ $perm->name }}
                                            <i class="fas fa-trash text-danger ms-2" title="Hapus"></i>
                                        </a>
                                    </li>
                                    @endforeach
                                    <li>
                                        <a href="#"
                                            onclick="deleteModelPermissions('{{ addslashes($model) }}'); return false;"
                                            class="text-danger">
                                            <i class="fas fa-trash me-1"></i> Hapus Semua Permission Model Ini
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endforeach

                            @if($grouped['manual']->isNotEmpty())
                            <li>
                                <div class="listree-submenu-heading">
                                    Lainnya
                                    <span class="badge bg-secondary ms-2">{{ $grouped['manual']->count() }}</span>
                                </div>
                                <ul class="listree-submenu-items">
                                    @foreach($grouped['manual'] as $perm)
                                    <li>
                                        <a href="#"
                                            onclick="deletePermission({{ $perm->id }}, '{{ addslashes($perm->name) }}'); return false;">
                                            {{ $perm->name }}
                                            <i class="fas fa-trash text-danger ms-2" title="Hapus"></i>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Tambah Permission --}}
    <div class="modal fade" id="addPermission" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="permissionForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipe Permission</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" value="manual" id="typeManual"
                                    checked>
                                <label class="form-check-label" for="typeManual">Manual</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" value="model" id="typeModel">
                                <label class="form-check-label" for="typeModel">Berdasarkan Model</label>
                            </div>
                        </div>

                        <div class="mb-3" id="manualField">
                            <label for="permName" class="form-label">Nama Permission</label>
                            <input type="text" class="form-control" name="name" id="permName"
                                placeholder="manage_settings">
                        </div>

                        <div class="mb-3 d-none" id="modelField">
                            <label for="modelName" class="form-label">Nama Model (singular)</label>
                            <input type="text" class="form-control" name="model_name" id="modelName"
                                placeholder="post, user, category">
                            <small class="text-muted">
                                Contoh: <code>post</code> → menghasilkan
                                <code>view_posts</code>, <code>add_posts</code>, <code>edit_posts</code>,
                                <code>delete_posts</code>.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assign ke Role (opsional)</label>
                            <div class="row" id="roleCheckboxes">
                                @foreach($roles as $role)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="assign_to_roles[]"
                                            value="{{ $role->id }}" id="role-{{ $role->id }}">
                                        <label class="form-check-label" for="role-{{ $role->id }}">{{ $role->name
                                            }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('addon-script')
    <script src="{{ asset('assets/libs/listree/listree.umd.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            listree();

            // Toggle field berdasarkan tipe
            document.getElementById('typeModel').addEventListener('change', toggleFields);
            document.getElementById('typeManual').addEventListener('change', toggleFields);
            toggleFields();

            // Submit form modal
            document.getElementById('permissionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch("{{ route('permissions.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // refresh tree
                    } else {
                        alert('Error: ' + (data.message || 'Gagal menyimpan permission.'));
                    }
                })
                .catch(err => {
                    alert('Terjadi kesalahan jaringan.');
                });
            });
        });

        function toggleFields() {
            const isModel = document.getElementById('typeModel').checked;
            document.getElementById('manualField').classList.toggle('d-none', isModel);
            document.getElementById('modelField').classList.toggle('d-none', !isModel);
            document.getElementById('permName').required = !isModel;
            document.getElementById('modelName').required = isModel;
        }

        // HAPUS PERMISSION INDIVIDU
        function deletePermission(id, name) {
            if (!confirm(`Hapus permission "${name}"?`)) return;

            fetch("{{ route('permissions.destroy', ':id') }}".replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus permission.');
                }
            })
            .catch(() => alert('Terjadi kesalahan.'));
        }

        // HAPUS SEMUA PERMISSION MODEL
        function deleteModelPermissions(model) {
            if (!confirm(`Hapus SEMUA permission untuk model "${model}"?`)) return;

            fetch("{{ route('permissions.deletes', ':model') }}".replace(':model', model), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus permission model.');
                }
            })
            .catch(() => alert('Terjadi kesalahan.'));
        }
    </script>
    @endpush
</x-master-layout>