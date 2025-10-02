<div class="accordion-item m-1">
    <h5 class="accordion-header m-0" id="heading-{{ Str::slug($roleName) }}">
        <button class="accordion-button fw-semibold collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#role-{{ Str::slug($roleName) }}" aria-expanded="false"
            aria-controls="role-{{ Str::slug($roleName) }}">
            {{ $roleName }}
        </button>
    </h5>

    <div id="role-{{ Str::slug($roleName) }}" class="accordion-collapse collapse"
        aria-labelledby="heading-{{ Str::slug($roleName) }}" data-bs-parent="#accordionExample" style="">
        <div class="accordion-body">
            <div class="row">
                @foreach ($permissions as $permission)
                @php
                $per_found = null;
                if (isset($role)) {
                $per_found = $role->hasPermissionTo($permission->name);
                }
                @endphp
                <div class="col-md-3 col-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $per_found
                                ? 'checked' : '' }} @disabled(!empty($options))>
                            <span
                                class="lbl text-{{ Str::contains($permission->name, 'delete') ? 'danger' : 'primary' }}">
                                {{ str_replace('_', ' ', $permission->name) }}
                            </span>
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="clearfix form-actions p-4 {{ $role->name == 'Admin' ? 'd-none' : '' }}">
            <div class="col-md-12 text-end">
                <input type="submit" class="btn btn-primary btn-sm" value="Save">

                <button type="button" class="btn btn-danger btn-sm delete-role" data-role-id="{{ $role->id }}"
                    data-role-name="{{ $role->name }}" data-delete-url="{{ route('roles.destroy', $role->id) }}">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>