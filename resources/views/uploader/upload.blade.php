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
                @livewire('PspUploads')

                <div class="row mt-3">
                    <!-- SERVICE DATA UPLOAD CARD -->
                    @livewire('PspUploadServices')
                </div>

            </div>
            <x-footers.auth></x-footers.auth>
        </div>

        <x-plugins></x-plugins>
</x-layout>
