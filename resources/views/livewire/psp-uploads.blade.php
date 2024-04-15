<div>
    <div id="preloader" wire:loading
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p style="text-align: center; margin-top: 1rem;">Loading...</p>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card h-100">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
                {{-- @csrf --}}
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Client Data, Pet Data & Vet Data</h6>
                        </div>
                        <div class="col-6 text-end">
                            <button type="submit" class="btn btn-outline-primary btn-sm mb-0">Upload</button>
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
                                    wire:model="clients_file" id="clients_file">
                                @error('clients_file')
                                    <div class="invalid-feedback" style="font-size: 0.77em">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="d-flex position-absolute bottom-35 end-0 mt-1 {{ $client['class'] }}">
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
                                    wire:model="vets_file" id="vets_file">
                                @error('vets_file')
                                    <div class="invalid-feedback" style="font-size: 0.77em">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="d-flex position-absolute bottom-35 end-0 mt-1 {{ $vet['class'] }}">
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
                                    wire:model="pets_file" id="pets_file">
                                @error('pets_file')
                                    <div class="invalid-feedback" style="font-size: 0.77em">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="d-flex position-absolute bottom-35 end-0 mt-1 {{ $pet['class'] }}">
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
</div>
