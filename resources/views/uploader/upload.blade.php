<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="upload"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='PSP Data Upload'></x-navbars.navs.auth>
        <!-- End Navbar -->
        @push('preloader')
            <div id="preloader"
                style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); z-index: 9999;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p style="text-align: center; margin-top: 1rem;">Loading...</p>
                </div>
            </div>
        @endpush

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
                <div class="col-lg-12">
                    <div class="card h-100">
                        <form action="{{ route('psp.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-6 d-flex align-items-center">
                                        <h6 class="mb-0">Client Data, Pet Data & Vet Data</h6>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="submit"
                                            class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 pb-0">
                                <div class="row mb-3">
                                    <div class="col-lg-4">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="file">Select Client CSV file to
                                                upload:</label>
                                            <input type="file"
                                                class="form-control form-control-sm border border-2 p-2 @error('clients_file') is-invalid @enderror"
                                                name="clients_file" id="clients_file">
                                            @error('clients_file')
                                                <div class="invalid-feedback" style="font-size: 0.77em">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div
                                                class="d-flex position-absolute bottom-35 end-0 mt-1 {{ $client['class'] }}">
                                                <i class="material-icons text-xs my-auto me-1">schedule</i>
                                                <p class="mb-0 text-xs">{{ $client['info'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3  position-relative">
                                            <label class="form-label" for="vets_file">Select Vet CSV file to
                                                upload:</label>
                                            <input type="file"
                                                class="form-control form-control-sm border border-2 p-2 @error('vets_file') is-invalid @enderror"
                                                name="vets_file" id="vets_file">
                                            @error('vets_file')
                                                <div class="invalid-feedback" style="font-size: 0.77em">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div
                                                class="d-flex position-absolute bottom-35 end-0 mt-1 {{ $vet['class'] }}">
                                                <i class="material-icons text-xs my-auto me-1">schedule</i>
                                                <p class="mb-0 text-xs">{{ $vet['info'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="pets_file">Select Pet CSV file to
                                                upload:</label>
                                            <input type="file"
                                                class="form-control form-control-sm border border-2 p-2 @error('pets_file') is-invalid @enderror"
                                                name="pets_file" id="pets_file">
                                            @error('pets_file')
                                                <div class="invalid-feedback" style="font-size: 0.77em">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div
                                                class="d-flex position-absolute bottom-35 end-0 mt-1 {{ $pet['class'] }}">
                                                <i class="material-icons text-xs my-auto me-1">schedule</i>
                                                <p class="mb-0 text-xs">{{ $pet['info'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- SERVICE DATA UPLOAD CARD -->
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <form action="{{ route('upload.services') }}" method="POST" enctype="multipart/form-data">
                                @csrf {{-- CSRF token for security --}}
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-6 d-flex align-items-center">
                                            <h6 class="mb-0">Service Data</h6>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3 pb-0">
                                    <div class="row mb-3">
                                        <div class="mb-3 position-relative">
                                            <label class="form-label" for="file">Select Services CSV file to
                                                upload:</label>
                                            <input type="file"
                                                class="form-control form-control-sm border border-2 p-2 @error('csv_file') is-invalid @enderror"
                                                name="csv_file" id="file">
                                            @error('csv_file')
                                                <div class="invalid-feedback" style="font-size: 0.77em">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <div
                                                class="d-flex position-absolute bottom-35 end-3 mt-1 {{ $service['class'] }}">
                                                <i class="material-icons text-xs my-auto me-1">schedule</i>
                                                <p class="mb-0 text-xs">
                                                    {{ $service['info'] }}</p>
                                            </div>
                                        </div>
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

        @push('header-script')
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const myPreloader = document.querySelector("#preloader");
                    myPreloader.style.display = "block"; // Tampilkan preloader saat halaman dimuat

                    // Event listener untuk mendeteksi ketika seluruh halaman selesai dimuat
                    window.addEventListener("load", function() {
                        setTimeout(function() {
                            myPreloader.remove(); // Hapus preloader setelah selesai dimuat
                        }, 500); // Tambahkan penundaan jika diperlukan
                    });
                });
            </script>
        @endpush
        @push('script')
            <script>
                // Event listener untuk menampilkan preloader saat form disubmit
                document.addEventListener("submit", function(event) {
                    const myPreloader = document.querySelector("#preloader");
                    myPreloader.style.display = "block"; // Tampilkan preloader saat form disubmit
                });
            </script>
        @endpush
</x-layout>
