<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="dduploader"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">

        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='GoCardless Invoice Processing'></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('{{ asset('assets') }}/img/gocardlessbackground.jpg');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>

            <!-- HEADER -->
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                GoCardless Direct Debit Processor
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                Prepare GoCardless Weekly Direct Debits For Upload.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="container-fluid py-4">
            <div class="row">


                <div class="col-5 mt-3">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <h6 class="mb-0">Upload CSVs</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-outline-primary btn-sm mb-0">Upload</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pb-0">
                            <div class="row mb-3">
                                <div>
                                    <div class="mb-3 position-relative">
                                        <label class="form-label" for="file">PsP Unpaid Invoices:</label>
                                        <input type="file" class="form-control form-control-sm border border-2 p-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-7 mt-3">
                    <div class="card h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-6 d-flex align-items-center">
                                    <i class="material-icons text-s my-auto me-1">class</i>
                                    <h6 class="mb-0">Guide</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3 pb-0">
                            <div class="row mb-3">
                                <div>
                                    <div class="mb-3 position-relative">
                                        <span style="font-weight: bold">PsP Unpaid Invoices</span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <x-footers.auth></x-footers.auth>
        </div>

        <x-plugins></x-plugins>
</x-layout>
