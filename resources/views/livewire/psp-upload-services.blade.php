<div>
    <div id="preloader-service" wire:loading
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p style="text-align: center; margin-top: 1rem;">Loading...</p>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
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
                    <div class="row mb-3">
                        <div class="mb-3 position-relative">
                            <label class="form-label" for="file">Select Services CSV file to
                                upload:</label>
                            <input type="file"
                                class="form-control form-control-sm border border-2 p-2 @error('csv_file') is-invalid @enderror"
                                wire:model="csv_file" id="file">
                            @error('csv_file')
                                <div class="invalid-feedback" style="font-size: 0.77em">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="d-flex position-absolute bottom-35 end-3 mt-1 {{ $service['class'] }}">
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
