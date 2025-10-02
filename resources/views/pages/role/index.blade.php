<x-master-layout>
    @section('title')
    Role & Permission
    @endsection
    <div class="container-xxl">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">List of Role</h6>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn bg-gradient-primary btn-primary btn-sm mb-0"
                                data-bs-toggle="modal" data-bs-target="#addRole">
                                Create
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="accordion" id="accordionExample">
                        @foreach ($roles as $role)
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            @include('pages.role.permission', [
                            'roleName' => $role->name. ' Permission',
                            'options' => strtolower($role->name) != 'admin' ? null : ['disabled'],
                            'showButton' => true,
                            'model' => strtolower($role->name) != 'admin' ? $role : '',
                            ])
                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" required
                                value="{{ old('name') }}" placeholder="Name">
                            @error('name')
                            <span class="invalid-feedback text-danger text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-secondary" style="color:#FFFFFF !important;"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-primary" style="color:#FFFFFF !important;">Add Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @push('addon-script')
    <script src="{{ asset('init/widget/role/app.js') }}?v={{ filemtime(public_path('init/widget/role/app.js')) }}">
    </script>
    @endpush
</x-master-layout>