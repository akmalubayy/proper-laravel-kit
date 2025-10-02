<x-master-layout>
    @section('title')
    Create User
    @endsection
    <div class="container-xxl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row g-0 h-100">
                            <div class="col-lg-12">
                                <h4 class="card-title fs-16 mb-0 pt-3 ps-4">Create User</h4>

                                <form action="{{ route('users.store') }}" class="p-4 pt-3" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-2 mb-lg-1">
                                        <label for="name" class="form-label mt-2">Full Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            aria-describedby="fullName" placeholder="Your Full Name"
                                            value="{{ old('name') }}" required>
                                    </div>
                                    <!--end form-group-->

                                    <div class="form-group mb-2 mb-lg-1">
                                        <label for="email" class="form-label mt-2">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            aria-describedby="email" placeholder="Your Email" value="{{ old('email') }}"
                                            required>
                                    </div>
                                    <!--end form-group-->

                                    <div class="form-group mb-2 mb-lg-1">
                                        <label for="password" class="form-label mt-2">Password</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            aria-describedby="password" placeholder="********" required>
                                    </div>
                                    <!--end form-group-->

                                    <div class="form-group mb-2 mb-lg-1">
                                        <label for="projectName" class="form-label mt-2">Role</label>
                                        <select name="roles" class="form-control @error('roles') is-invalid @enderror"
                                            id="roles" required>
                                            <option value="" disabled selected>Choose...</option>
                                            @forelse ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}</option>
                                            @empty
                                            <option value="" disabled selected>-- Data not found --</option>
                                            @endforelse
                                        </select>
                                        @error('roles')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </small>
                                        </span>
                                        @enderror
                                    </div>
                                    <!--end form-group-->
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </form>
                                <!--end form-->
                            </div>
                            <!--end col-->

                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</x-master-layout>