<x-master-layout>
    @section('title')
    Home
    @endsection
    {{-- <div class="container-sm mb-2">
        <div class="row">
            <div class="col-12">
                <div class="alert  border-2 border-danger text-danger alert-dismissible fade show mb-0" role="alert">
                    <div
                        class="d-inline-flex justify-content-center align-items-center thumb-xs bg-danger rounded-circle mx-auto me-1">
                        <i class="fas fa-xmark align-self-center mb-0 text-white "></i>
                    </div>
                    <strong>Oh snap!</strong> Change a few things up and try submitting again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pb-3">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold fs-14">Domains</p>
                                <h3 class="mt-2 mb-0 fw-bold">850</h3>
                            </div>
                            <!--end col-->
                            <div class="col-3 align-self-center">
                                <div
                                    class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                    <i class="fab fa-grav h1 align-self-center mb-0 text-secondary"></i>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pb-3">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold fs-14">Certificate Totals</p>
                                <h3 class="mt-2 mb-0 fw-bold">600</h3>
                            </div>
                            <!--end col-->
                            <div class="col-3 align-self-center">
                                <div
                                    class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                    <i class="icofont-dart h1 align-self-center mb-0 text-secondary"></i>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center pb-3">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold fs-14">Expiring within 30 days</p>
                                <h3 class="mt-2 mb-0 fw-bold">124</h3>
                            </div>
                            <!--end col-->
                            <div class="col-3 align-self-center">
                                <div
                                    class="d-flex justify-content-center align-items-center thumb-xl bg-light rounded-circle mx-auto">
                                    <i class="iconoir-clock h1 align-self-center mb-0 text-secondary"></i>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-8">
                <div class="card card-h-100">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Latest Update</h4>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-header-->
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-top-0">Domain</th>
                                        <th class="border-top-0">Certificate</th>
                                        <th class="border-top-0">Valid To</th>
                                        <th class="border-top-0">Algorithm</th>
                                    </tr>
                                    <!--end tr-->
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href class="text-primary">domain.com</a>
                                        </td>
                                        <td>Digicert
                                        </td>
                                        <td>7/15/2026
                                        </td>
                                        <td>RSA 2048
                                        </td>
                                    </tr>
                                    <!--end tr-->
                                    <tr>
                                        <td>
                                            <a href class="text-primary">domain2.com</a>
                                        </td>
                                        <td>Digicert
                                        </td>
                                        <td>7/15/2026
                                        </td>
                                        <td>RSA 2048
                                        </td>
                                    </tr>
                                    <!--end tr-->
                                    <tr>
                                        <td>
                                            <a href class="text-primary">domain3.com</a>
                                        </td>
                                        <td>Digicert
                                        </td>
                                        <td>7/15/2026
                                        </td>
                                        <td>RSA 2048
                                        </td>
                                    </tr>
                                    <!--end tr-->
                                    <tr>
                                        <td>
                                            <a href class="text-primary">domain4.com</a>
                                        </td>
                                        <td>Digicert
                                        </td>
                                        <td>7/15/2026
                                        </td>
                                        <td>RSA 2048
                                        </td>
                                    </tr>
                                    <!--end tr-->
                                    <tr>
                                        <td>
                                            <a href class="text-primary">domain5.com</a>
                                        </td>
                                        <td>Digicert
                                        </td>
                                        <td>7/15/2026
                                        </td>
                                        <td>RSA 2048
                                        </td>
                                    </tr>
                                    <!--end tr-->
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                        <!--end /div-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <p class="text-dark mb-0 fw-semibold fs-14">In Errors</p>
                                <h2 class="mt-0 mb-0 fw-bold">5</h2>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                        <div id="visitors_report" class="apex-charts mb-2"></div>
                        <button type="button" class="btn btn-primary w-100 btn-lg fs-14">More Detail <i
                                class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</x-master-layout>