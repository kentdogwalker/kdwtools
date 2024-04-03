<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="upload"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='PSP Data Upload'></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('{{ asset('assets') }}/img/petsitterplusbackground.jpg');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>

            <!-- HEADER -->
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                PSP Data Uploader
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                Upload exported CSVs from Pet Sitter Plus here.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="container-fluid py-4">
            <div class="row">
                <!-- CLIENT DATA UPLOAD CARD -->
                <div class="col-lg-4">
                    <div class="card h-100">
                        <form action="{{ route('psp.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf {{-- CSRF token for security --}}
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Client Data</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pb-0">
                            <div class="mb-3">
                                <label class="form-label" for="file">Select Client CSV file to upload:</label>
                                <input type="file" class="form-control form-control-sm border border-2 p-2" name="csv_file" id="file" required>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>

                <!-- PET DATA UPLOAD CARD -->
                <div class="col-lg-4">
                    <div class="card h-100">
                        <form action="{{ route('pets.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf {{-- CSRF token for security --}}
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Pet Data</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pb-0">
                            <div class="mb-3">
                                <label class="form-label" for="pets_file">Select Pet CSV file to upload:</label>
                                <input type="file" class="form-control form-control-sm border border-2 p-2" name="pets_file" id="pets_file" required>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <!-- VET DATA UPLOAD CARD -->
                <div class="col-lg-4">
                    <div class="card h-100">
                        <form action="{{ route('upload.vets') }}" method="POST" enctype="multipart/form-data">
                            @csrf {{-- CSRF token for security --}}
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Vet Data</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pb-0">
                            <div class="mb-3">
                                <label class="form-label" for="vets_csv">Select Vet CSV file to upload:</label>
                                <input type="file" class="form-control form-control-sm border border-2 p-2" name="vets_csv" id="vets_csv" required>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>


                <div class="row mt-3">
                    <!-- SERVICE DATA UPLOAD CARD -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf {{-- CSRF token for security --}}
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Service Data</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="submit" class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 pb-0">
                                <div class="mb-3">
                                    <label class="form-label" for="file">Select Services CSV file to upload:</label>
                                    <input type="file" class="form-control form-control-sm border border-2 p-2" name="csv_file" id="file" required>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>


            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
