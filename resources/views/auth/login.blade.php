<x-auth-layout>
    @section('title')
    Login
    @endsection
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
                                <div class="card-body pt-3">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" type="email" name="email" :value="old('email')"
                                                :class="$errors->get('email') ? 'is-invalid' : ''" required autofocus
                                                autocomplete="username" />
                                            <x-input-error :messages="$errors->get('email')" />
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group">
                                            <x-input-label for="password" :value="__('Password')" />
                                            <x-text-input id="password" type="password" name="password"
                                                :class="$errors->get('password') ? 'is-invalid' : ''" required
                                                autocomplete="current-password" />

                                            <x-input-error :messages="$errors->get('password')" />
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group row mt-3">
                                            <div class="col-sm-6">
                                                <div class="form-check form-switch form-switch-success">
                                                    <input id="remember_me" type="checkbox" class="form-check-input"
                                                        name="remember">
                                                    <label for="remember_me" class="form-check-label">
                                                        {{ __('Remember me') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-sm-6 text-end">
                                                @if (Route::has('password.request'))
                                                <a class="text-secondary" href="{{ route('password.request') }}">
                                                    {{ __('Forgot your password?') }}
                                                </a>
                                                @endif
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <x-primary-button>
                                                        {{ __('Log in') }}
                                                    </x-primary-button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->
                                    </form>
                                    <!--end form-->
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
</x-auth-layout>