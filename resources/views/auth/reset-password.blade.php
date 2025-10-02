<x-auth-layout>
    <div class="container-xxl">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="javascript:void(0);" class="logo logo-admin">
                                            <img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Let's Get Started Rizz</h4>
                                        <p class="text-muted fw-medium mb-0">Sign in to continue to Rizz.</p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form method="POST" action="{{ route('password.store') }}">
                                        @csrf

                                        <!-- Password Reset Token -->
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        <div class="form-group mt-3 mb-3 row">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <div class="input-group">
                                                <x-text-input id="email" type="email" name="email"
                                                    :value="old('email', $request->email)"
                                                    :class="$errors->get('email') ? 'is-invalid' : ''" required
                                                    autofocus autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')" />
                                            </div>
                                        </div>
                                        <!-- Password -->
                                        <div class="form-group mb-3 row">
                                            <x-input-label for="password" :value="__('Password')" />
                                            {{--
                                            <x-text-input id="password" type="password" name="password"
                                                :class="$errors->get('password') ? 'is-invalid' : ''" required
                                                autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" /> --}}
                                            <div class="input-group">
                                                <input
                                                    class="form-control password-field @error('password') is-invalid @enderror"
                                                    id="password" type="password" name="password" placeholder="********"
                                                    required />
                                                <span class="input-group-text password-toggle" data-target="password">
                                                    <i data-feather="eye" style="cursor: pointer"></i>
                                                </span>
                                                <x-input-error :messages="$errors->get('password')" />
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="form-group mb-3 row">
                                            <x-input-label for="password_confirmation"
                                                :value="__('Confirm Password')" />
                                            <div class="input-group">
                                                <input
                                                    class="form-control password-field @error('password_confirmation') is-invalid @enderror"
                                                    id="password_confirmation" type="password"
                                                    name="password_confirmation" placeholder="********" required />
                                                <span class="input-group-text password-toggle"
                                                    data-target="password_confirmation">
                                                    <i data-feather="eye" style="cursor: pointer"></i>
                                                </span>
                                                <x-input-error :messages="$errors->get('password_confirmation')" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-12 p-0 text-end">
                                                <button type="submit" class="btn btn-primary">Reset Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div><!-- container -->
    @push('addon-script')
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>
    <script>
        feather.replace({ 'aria-hidden': 'true' });

        $(".password-toggle").click(function (e) {
            e.preventDefault();

            // Cari input password terkait (sibling dalam input-group)
            var $input = $(this).siblings("input");
            var type = $input.attr("type");

            // Cari ikon FEATHER di dalam toggle ini (bukan di seluruh halaman!)
            var $icon = $(this).find("svg");

            if (type === "password") {
                // Ganti ikon eye → eye-off
                $icon.replaceWith(feather.icons["eye-off"].toSvg({ 'aria-hidden': 'true', 'style': 'cursor: pointer' }));
                $input.attr("type", "text");
            } else if (type === "text") {
                // Ganti ikon eye-off → eye
                $icon.replaceWith(feather.icons["eye"].toSvg({ 'aria-hidden': 'true', 'style': 'cursor: pointer' }));
                $input.attr("type", "password");
            }
        });
    </script>
    @endpush
</x-auth-layout>