<x-master-layout>
    @section('title')
    Edit Menu
    @endsection
    <div class="container-xxl">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Edit Menu</h4>
                        <form action="{{ route('menus.update', $data->id) }}" id="addContactModalTitle" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2 title">
                                        <input type="text" id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Title" name="title" value="{{ old('title') ?? $data->title }}">
                                        @error('title')
                                        <span class="validation-text text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 url">
                                        <input type="text" name="url" id="url"
                                            class="form-control @error('url') is-invalid @enderror" placeholder="URL"
                                            value="{{ old('url') ?? $data->url }}">
                                        @error('url')
                                        <span class="validation-text text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 icon">
                                        <input type="text" name="icon" id="icon"
                                            class="form-control @error('icon') is-invalid @enderror" placeholder="Icon"
                                            value="{{ old('icon') ?? $data->icon }}">
                                        @error('icon')
                                        <span class="validation-text text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-check py-2">
                                        <input class="form-check-input parent" type="checkbox" id="parentMenu"
                                            name="is_parent" {{ $data->is_parent ? 'checked' : '' }}>
                                        <label class="form-check-label" for="parentMenu">
                                            Is Parent
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check py-2">
                                        <input class="form-check-input parent" type="checkbox" id="hasChild"
                                            name="has_child" {{ $data->has_child ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hasChild">
                                            Has Child
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check py-2">
                                        <input class="form-check-input parent" type="checkbox" id="isActive"
                                            name="is_active" @checked((int)$data->is_active)>
                                        <label class="form-check-label" for="isActive">
                                            Active
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="parentId">
                                    <div class="mb-2 contact-phone">
                                        <select name="parent_id"
                                            class="form-control @error('parent_id') is-invalid @enderror">
                                            <option value="" disabled selected>-- Parent Menu --</option>
                                            @foreach ($menus->where('parent_id', null) as $menu)
                                            <option value="{{ $menu->id }}" @selected($menu->id == $data->parent_id)>{!!
                                                $menu->title !!}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                        <span class="validation-text text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-2 contact-phone">
                                        <input type="number" name="order" id="editOrder"
                                            class="form-control @error('order') is-invalid @enderror"
                                            placeholder="Order" value="{{ old('order') ?? $data->order }}">
                                        @error('order')
                                        <span class="validation-text text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12" id="forRole">
                                    <label for="roles" class="mb-2">Visible for role</label>

                                    <!-- Check All Checkbox -->
                                    <div class="form-check form-checkbox-outline form-check-primary mb-2">
                                        <input class="form-check-input" type="checkbox" id="checkAllRoles">
                                        <label class="form-check-label" for="checkAllRoles">
                                            <strong>Pilih Semua</strong>
                                        </label>
                                    </div>

                                    <!-- List Roles -->
                                    <div class="row" id="roleCheckboxes">
                                        @foreach($roles as $role)
                                        <div class="col-3">
                                            <div class="form-check form-checkbox-outline form-check-primary mb-2">
                                                <input class="form-check-input role-checkbox" type="checkbox"
                                                    name="roles[]" value="{{ $role->id }}"
                                                    id="roleLabel-{{ $role->id }}"
                                                    @checked($data->roles()->find($role->id))>
                                                <label class="form-check-label" for="roleLabel-{{ $role->id }}">
                                                    {{ ucfirst($role->name) }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary w-md">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    </div>

    @push('addon-script')
    <script>
        $(document).ready(function () {
            $('#hasChild').on('change', function() {
                if ($(this).is(':checked')) {
                // Jika checkbox dalam keadaan checked
                $('#parentId').css('display', 'none');
                } else {
                // Jika checkbox tidak checked
                $('#parentId').css('display', 'block');
                }
            });

            const checkAll = document.getElementById('checkAllRoles');
            const checkboxes = document.querySelectorAll('.role-checkbox');

            // Ketika "Check All" diklik
            checkAll.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = checkAll.checked);
            });

            // Ketika salah satu checkbox berubah
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                checkAll.checked = allChecked;
                });
            });
        });
    </script>
    @endpush
</x-master-layout>