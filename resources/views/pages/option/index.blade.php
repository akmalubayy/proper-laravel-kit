<x-master-layout>
    @section('title')
    Option
    @endsection
    <div class="container-xxl">
        <div class="row row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="card-title">Site Information</h4>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-header-->
                    <div class="card-body pt-0">
                        <form action="{{ route('options.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3 row">
                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Site
                                    Title</label>
                                <div class="col-lg-9 col-xl-8">
                                    <input class="form-control @error('sitetitle') is-invalid @enderror" type="text"
                                        value="{{ $option->sitetitle ?? old('sitetitle') }}" name="sitetitle"
                                        id="sitetitle">
                                    @error('sitetitle')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Site
                                    Url</label>
                                <div class="col-lg-9 col-xl-8">
                                    <input class="form-control @error('siteurl') is-invalid @enderror" type="text"
                                        value="{{ $option->siteurl ?? old('siteurl') }}" name="siteurl" id="siteUrl">
                                    @error('siteurl')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Home
                                    Url</label>
                                <div class="col-lg-9 col-xl-8">
                                    <input class="form-control @error('homeurl') is-invalid @enderror" type="text"
                                        value="{{ $option->homeurl ?? old('homeurl') }}" name="homeurl" id="homeUrl">
                                    @error('homeurl')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <label
                                    class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Logo</label>
                                <div class="col-lg-9 col-xl-8">
                                    <input id="sitelogo" name="sitelogo" type="file"
                                        class="form-control @error('sitelogo') is-invalid @enderror">
                                </div>
                                @error('sitelogo')
                                <span class="invalid-feedback text-danger" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-9 col-xl-8 offset-lg-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-danger">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end card-body-->
                </div>
            </div>
        </div>
    </div>
</x-master-layout>