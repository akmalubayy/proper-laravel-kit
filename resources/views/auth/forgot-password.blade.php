<x-auth-layout>
    @section('title')
    Forgot Password
    @endsection
    <div class="container-xxl">
        <!-- Session Status -->
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <div class="card">
                                <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                    <div class="text-center p-3">
                                        <a href="javascript:void(0);" class="logo logo-admin">
                                            <img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Reset Password</h4>
                                        <p class="text-muted fw-medium mb-0">Enter your Email and instructions will be
                                            sent to you!</p>
                                    </div>
                                </div>
                                <div class="card-body pt-3">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <x-input-label for="email" :value="__('Email')" />
                                            <x-text-input id="email" type="email" name="email" :value="old('email')"
                                                :class="$errors->get('email') ? 'is-invalid' : ''" required autofocus />
                                            <x-input-error :messages="$errors->get('email')" />
                                        </div>
                                        <!--end form-group-->

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <x-primary-button>
                                                        {{ __('Reset') }}<i class="fas fa-sign-in-alt ms-1"></i>
                                                    </x-primary-button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end form-group-->
                                    </form>
                                    <!--end form-->
                                    <div class="text-center mt-4 mb-2">
                                        <p class="text-muted">Remember It ? <a href="{{ route('login') }}"
                                                class="text-primary ms-2">Sign in here</a></p>
                                    </div>
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
    </div>
</x-auth-layout>