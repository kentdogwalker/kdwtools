<div>
    @push('css')
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @endpush
    <div id="preloader-service" wire:loading
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 255, 255, 0.8); z-index: 9999;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p style="text-align: center; margin-top: 1rem;">Loading...</p>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <form wire:submit.prevent="filter" style="margin-bottom: -111px;">
            <div class="row">
                <div class="col-8">
                    <div class="row p-4">
                        <label for="date_filter"
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-80">Date
                            Filter</label>
                        <div class="form-group">
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                style="position: relative;right: 73px;" wire:click="previousWeek">
                                < </button><input type="text" wire:model="date_filter" name="date_filter"
                                        onchange="this.dispatchEvent(new InputEvent('input'))"
                                        style="border: 1px solid #d2d6da;padding: 0.2rem 10px;position: relative;bottom: 46px;right: 27px;"
                                        class="form-control" id="date_filter" /><button
                                        class="btn btn-outline-secondary btn-sm"
                                        style="position: relative; bottom: 78px;left: 185px;" wire:click="nextWeek"> >
                                    </button>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row mt-5">
                        <button type="submit" class="btn btn-sm btn-primary" style="margin-top: 0px">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row p-4">
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap overflow-hidden"
                style="border-color: rgba(166, 175, 171, 0.66);margin-bottom: 10px; border-collapse: collapse;">
                <thead style="background-color: #ef3472" class="text-white">
                    <tr>
                        <th style="width: 10%;">Room</th>
                        @for ($i = 0; $i < 7; $i++)
                            <th style="width: 12%;">
                                {{ \Carbon\Carbon::parse($startDate)->addDays($i)->format('D d M') }}
                            </th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="text-white">
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td class="text-dark" style="border: 1px solid #c3c7cc; width:10%;">
                                {{ '[' . $schedule['room_id'] . '] ' . $schedule['room_name'] }}
                            </td>
                            @foreach ($schedule['booking'] as $item)
                                @if (!empty($item['clients']))
                                    @php
                                        $colspan = $item['clients']['duration'] ?? 1;
                                    @endphp
                                    <td colspan="{{ $colspan }}" style="border: 1px solid #c3c7cc; width:12%;">
                                        <div class="card" style="background-color: #f1437d">
                                            <div class="card-body">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row text-sm text-white">
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="d-flex px-2 py-1">
                                                                @php
                                                                    if ($item['clients']['dog_photo'] === null) {
                                                                        $breed = strtolower($item['clients']['breed']);
                                                                        $breed_images_path = public_path(
                                                                            'assets/img/dogs/breeds/',
                                                                        );
                                                                        $arr = scandir($breed_images_path);
                                                                        $maxSimilarity = 43;
                                                                        $matching_file = null;

                                                                        foreach ($arr as $value) {
                                                                            similar_text($breed, $value, $similarity);
                                                                            if ($similarity > $maxSimilarity) {
                                                                                $maxSimilarity = $similarity;
                                                                                $matching_file = $value;
                                                                            }
                                                                        }

                                                                        if (!empty($matching_file)) {
                                                                            $src_image = asset(
                                                                                'assets/img/dogs/breeds/' .
                                                                                    $matching_file,
                                                                            );
                                                                        } else {
                                                                            $src_image = asset(
                                                                                'assets/img/dogs/breeds/default.jpg',
                                                                            );
                                                                        }
                                                                    } else {
                                                                        $src_image = asset(
                                                                            'storage/dog-photos/' .
                                                                                $item['clients']['dog_photo'],
                                                                        );
                                                                    }
                                                                @endphp
                                                                <div>
                                                                    <img src="{{ $src_image }}"
                                                                        class="avatar avatar-sm me-3 border-radius-lg"
                                                                        alt="{{ $item['clients']['dog_name'] }}">
                                                                </div>
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm text-white">
                                                                        {{ $item['clients']['dog_name'] }}
                                                                        @if ($item['clients']['breed'] !== null)
                                                                            <i
                                                                                class="material-icons text-xm my-auto me-1">{{ strtolower($item['clients']['gender']) }}</i>
                                                                        @endif
                                                                    </h6>
                                                                    <p class="text-xs text-white mb-0">
                                                                        {{ '(' . $item['clients']['breed'] . ')' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="d-flex justify-content-end"
                                                                style="top: -11px;position: relative;">
                                                                <p style="font-size: 0.68rem" class="text-capitalize">
                                                                    {{ $item['clients']['owner_name'] }}
                                                                </p>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <p style="font-size: 0.7rem;position: absolute;bottom: -15px;"
                                                                    class="text-bold">
                                                                    {{ $item['clients']['status'] ?? '' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td style="border: 1px solid #c3c7cc; width:12%;">
                                        <div class="card" style="box-shadow: none;">
                                            <div class="card-body">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row mb-3">
                                                        <p></p>
                                                    </div>
                                                    <div class="row">
                                                        <p></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('js')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $(function() {
                let dateInterval = getQueryParameter('date_filter');
                let start = moment().startOf('last Monday');
                let end = moment().endOf('this Sunday');
                if (dateInterval) {
                    dateInterval = dateInterval.split(' - ');
                    start = dateInterval[0];
                    end = dateInterval[1];
                }
                $('#date_filter').daterangepicker({
                    startDate: start,
                    endDate: end,
                    locale: {
                        format: 'DD/MM/YYYY',
                        firstDay: 1,
                    }
                });
            });

            function getQueryParameter(name) {
                const url = window.location.href;
                name = name.replace(/[\[\]]/g, "\\$&");
                const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                    results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, " "));
            }
        </script>
    @endpush
</div>
