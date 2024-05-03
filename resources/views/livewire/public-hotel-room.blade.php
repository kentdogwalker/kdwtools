<div wire:poll.900s="pollData">
    <!-- ROOM TITLE AND IMAGE -->

    <!-- ROOM NAME: Will need to add a shorter version of the Room Name to the rooms table.Example: rather than "London Suite" just "London" and that is what will be displayed here.-->
    @if ($roomStatus === 'occupied')
        @if ($booking !== null)
            <div class="row" style="display: flex; width: 100%; position: relative;">
                <!-- Text Content -->
                <div style="flex: 1; z-index: 2; position: relative;">
                    <h1 class="display-3 text-uppercase mb-0 pb-0"
                        style="margin-bottom: 0; padding-bottom: 0; line-height: 1; color: white;">
                        <span style="display: inline-block; position: relative; border-bottom: 1px solid transparent;">
                            {{-- LONDON --}}{{ $room['name'] }}
                            <span
                                style="position: absolute; bottom: -2px; left: 0; width: 100%; border-bottom: 1px solid #FFF;"></span>
                        </span> <!-- Custom thin line under text -->
                    </h1>
                    <h1 class="text-uppercase display-6 mt-0 pt-1"
                        style="color: #E6348B; margin-bottom: 0; padding-bottom: 0; line-height: 1;">SUITE</h1>
                </div>

                <!-- Background with Linear Gradient and Image Adjusted for Vertical Fit -->
                <div
                    style="position: absolute; top: 0;right: 0;bottom: 0;left: 0;z-index: 1;background: linear-gradient(to right, rgba(0, 0, 0, 1) 30%, rgba(0,0,0,0) 100%), url('{{ $room['image'] }}') no-repeat right center / auto 100%;">
                </div>
            </div>

            <!-- DOG OCCUPANT INFORMATION AND STATS -->
            <div class="row mt-5 pt-3" style="display: flex; width: 100%;">

                <div class="bg-image"
                    style=" flex: 20%;background-image: url('{{ $booking['DogPhoto'] }}');background-size: 100% auto;background-repeat: round; background-position: unset; height: 200px; border: 6px solid #E6348B;border-top-left-radius: 35px;border-bottom-right-radius: 35px;">
                </div>

                <div style="flex: 40%;" class="ml-4">
                    <h1 class="display-4 text-uppercase" style="margin-bottom: 0; padding-bottom: 0; line-height: 1;">
                        {{ $booking['DogName'] }}</h1>
                    <p class="lead pt-2" style="margin-bottom: 0; padding-bottom: 0; line-height: 1;">
                        {{ $booking['pets']['Breed'] }}</p>
                    <p class="lead">{{ $booking['Age'] }}</span>
                    <p style="strong; margin-bottom: 0; padding-bottom: 0; line-height: 1.5; color: #A1A0A0">Owner:
                        <span>{{ $booking['Owner'] }}</span>
                    </p>
                    <p style="strong; margin-bottom: 0; padding-bottom: 0; line-height: 1.5; color: #A1A0A0">Tel:
                        <span>{{ $booking['clients']['MobilePhone'] }}</span>
                    </p>

                </div>

                <div style="flex: 20%;">
                    <!-- ENERGY LEVEL -->
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <img src="{{ $booking['EnergyLevel']['src'] ?? '' }}"
                            style="width: 30px; height: 30px; margin-right: 8px;">
                        <span>{{ $booking['EnergyLevel']['status'] ?? '' }}</span>
                    </div>

                    <!-- DISABILITY INDICATOR -->
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <img src="{{ $booking['DisabilitiesIcon'] ?? '' }}"
                            style="width: 30px; height: 30px; margin-right: 8px;">
                        <span>Disabled</span>
                    </div>

                    <!-- ALLERGIES INDICATOR -->
                    <div style="display: flex; align-items: center; margin-bottom: 20px;">
                        <img src="{{ $booking['AllergiesIcon'] ?? '' }}"
                            style="width: 30px; height: 30px; margin-right: 8px;">
                        <span>Known Allergies</span>
                    </div>

                    <!-- VET -->
                    <div style="display: flex; margin-bottom: 10px;">
                        <img src="{{ asset('assets') }}/img/room-icons/vet.png"
                            style="width: 30px; height: 30px; margin-right: 8px; align-self: flex-start;">
                        <!-- Use align-self for specific alignment -->
                        <div style="display: flex; flex-direction: column;">
                            <span>Vet</span>
                            <span
                                style="font-weight: lighter;">{{ $booking['pets']['vets']['Practice_Name'] ?? '' }}<br>
                                {{ $booking['pets']['vets']['Phone'] ?? '' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CHECK IN/OUT DATES -->
            <div class="row mt-3 pt-1" style="display: flex; width: 100%;">
                <div style="flex: 50%;">
                    <span style="font-size: 1.5rem; font-weight: lighter;">Check-In: </span>
                    <span
                        style="font-size: 1.5rem; font-weight: bold;">{{ \Carbon\Carbon::parse($booking['StayStart'])->format('d F Y') }}</span>
                </div>

                <div style="flex: 50%; display: flex; justify-content: flex-end;">
                    <span style="font-size: 1.5rem; font-weight: lighter;">Check-Out: </span>
                    <span
                        style="font-size: 1.5rem; font-weight: bold;">{{ \Carbon\Carbon::parse($booking['StayEnd'])->format('d F Y') }}</span>
                </div>
            </div>

            <!-- CHECK IN/OUT PROGRESS BAR -->
            <div class="row mt-1" style="display: flex; width: 100%;">
                <div class="progress" style="width: 100%; height: 30px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-valuenow="{{ $booking['Progress']['ariaValueNow'] ?? '' }}" aria-valuemin="0"
                        aria-valuemax="100"
                        style="width: {{ $booking['Progress']['percentValue'] ?? '' }}; background-color: #E6348B;">
                        {{ $booking['Progress']['stayInformation'] ?? '' }}
                    </div>
                </div>
            </div>

            <!-- FEEDING INFORMATION -->
            <div class="row mt-5" style="display: flex; width: 100%;">
                <div class="bg-image"
                    style="flex: 14%;background-image: url('{{ asset('assets') }}/img/room-icons/feeding-icon.png');background-size: 70% auto; background-repeat: no-repeat; background-position: center center;height: 100px;">
                </div>

                <div style="flex: 54%;">
                    <h3 style="color: #E6348B;">FEEDING</h3>
                    <span style="font-size: 1rem; font-weight: bold;">INSTRUCTIONS</span>
                    <p>
                        {{-- He likes to have his frozen duck wings in the evenings, 3 or 4. He may not eat at all. Don't worry he
                    can go
                    3/4 days without wanting to eat and that is quite normal for his breed. --}}
                        {{ $booking['pets']['FeedingInstructions'] = $booking['pets']['FeedingInstructions'] === '' || $booking['pets']['FeedingInstructions'] === null ? 'None.' : $booking['pets']['FeedingInstructions'] }}
                    </p>
                </div>

                <div class="pl-4" style="flex: 25%;">
                    <div class="mt-4 pt-3">
                        <span style="font-size: 1rem; font-weight: bold;">FEED TIMES</span>
                    </div>
                    <!-- MORNING -->
                    <div class="pt-2" style="display: flex; align-items: center; margin-bottom: 5px;">
                        <!-- Adjust spacing as needed -->
                        <img src="{{ $booking['HotelFeedTime']['Am'] ?? '' }}"
                            style="width: 20px; height: 20px; margin-right: 8px;">
                        <!-- Adjust icon size as needed -->
                        <span>Morning</span>
                    </div>

                    <!-- AFTERNOON -->
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <!-- Adjust spacing as needed -->
                        <img src="{{ $booking['HotelFeedTime']['Mid'] ?? '' }}"
                            style="width: 20px; height: 20px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
                        <span>Afternoon</span>
                    </div>

                    <!-- EVENING -->
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <!-- Adjust spacing as needed -->
                        <img src="{{ $booking['HotelFeedTime']['Pm'] ?? '' }}"
                            style="width: 20px; height: 20px; margin-right: 8px;">
                        <!-- Adjust icon size as needed -->
                        <span>Evening</span>
                    </div>
                </div>
            </div>

            <!-- ROUTINE INFORMATION -->
            <div class="row mt-2 mb-1" style="display: flex; width: 100%;">
                <div class="bg-image"
                    style="flex: 14%;background-image: url('{{ asset('assets') }}/img/room-icons/routine-icon.png');background-size: 70% auto; background-repeat: no-repeat; background-position: center center; height: 100px;">
                </div>
                <div style="flex: 54%;" class="mt-1">
                    <h3 style="color: #E6348B;">ROUTINE</h3>
                    <span style="font-size: 1rem; font-weight: bold;">INSTRUCTIONS</span>
                    <p>
                        {{ $booking['pets']['PetNotes'] = $booking['pets']['PetNotes'] === '' || $booking['pets']['PetNotes'] === null ? 'None.' : $booking['pets']['PetNotes'] }}
                    </p>
                </div>
                <div class="pl-4" style="flex: 25%;">
                    <div class="mt-1 pt-1">
                        <span style="font-size: 1rem; font-weight: bold;">SLEEP/WAKE TIMES</span>
                    </div>
                    <!-- WAKE TIME -->
                    <div class="pt-2" style="display: flex; align-items: center; margin-bottom: 5px;">
                        <!-- Adjust spacing as needed -->
                        <img src="{{ asset('assets') }}/img/room-icons/sun.png"
                            style="width: 20px; height: 20px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
                        <span style="font-weight: lighter">Wake: </span>
                        @if ($booking['pets']['UsualWakeTime'] === 'Not Specified')
                            <span
                                style="font-weight: bold; font-size: 15px; position: relative; bottom:-1px;">{{ $booking['pets']['UsualWakeTime'] ?? '' }}</span>
                        @else
                            <span style="font-weight: bold">{{ $booking['pets']['UsualWakeTime'] ?? '' }}</span>
                        @endif
                        {{-- <span style="font-weight: bold">7am</span> --}}
                    </div>

                    <!-- BED TIME -->
                    <div style="display: flex; align-items: center; margin-bottom: 5px;">
                        <!-- Adjust spacing as needed -->
                        <img src="{{ asset('assets') }}/img/room-icons/moon.png"
                            style="width: 20px; height: 20px; margin-right: 8px;"> <!-- Adjust icon size as needed -->
                        <span style="font-weight: lighter">Sleep: </span>
                        @if ($booking['pets']['UsualBedTime'] === 'Not Specified')
                            <span
                                style="font-weight: bold; font-size: 15px; position: relative; bottom:-1px;">{{ $booking['pets']['UsualBedTime'] ?? '' }}</span>
                        @else
                            <span style="font-weight: bold">{{ $booking['pets']['UsualBedTime'] ?? '' }}</span>
                        @endif
                        {{-- <span style="font-weight: bold">9:30pm</span> --}}
                    </div>
                </div>
            </div>

            <!-- MEDICAL INFORMATION -->
            <div class="row mt-2 mb-1" style="display: flex; width: 100%;">
                <div class="bg-image"
                    style="flex: 15%;background-image: url('{{ asset('assets') }}/img/room-icons/health-icon.png');background-size: 70% auto; background-repeat: no-repeat; background-position: center center; height: 100px;">
                </div>

                <div style="flex: 83%;" class="mt-1">
                    <!-- H3 moved here, to span above the three columns -->
                    <h3 style="color: #E6348B;">MEDICAL</h3>

                    <div style="display: flex; width: 100%;"> <!-- Make this a flex container -->
                        <div style="flex: 33%; padding-right: 10px;">
                            <span style="font-size: 1rem; font-weight: bold;">ALLERGIES</span>
                            <p>
                                {{ $booking['pets']['AllergiesNotes'] = $booking['pets']['AllergiesNotes'] === '' || $booking['pets']['AllergiesNotes'] === null ? 'None.' : $booking['pets']['AllergiesNotes'] }}
                                {{-- Sensitive to high grain content treats. Can cause loose stools. --}}
                            </p>
                        </div>

                        <div
                            style="flex: 33%; border-left: 1px dotted #FFF; border-right: 1px dotted #FFF; padding-left: 10px; padding-right:10px;">
                            <span style="font-size: 1rem; font-weight: bold;">DISABILITIES</span>
                            <p>
                                {{ $booking['pets']['DisabilitiesNotes'] = $booking['pets']['DisabilitiesNotes'] === '' || $booking['pets']['DisabilitiesNotes'] === null ? 'None.' : $booking['pets']['DisabilitiesNotes'] }}
                                {{-- Rear right leg can get stiff after prolonged laying or intense exercise. --}}
                            </p>
                        </div>


                        <div style="flex: 33%; padding-left: 10px;">
                            <span style="font-size: 1rem; font-weight: bold;">MEDICATION</span>
                            <p>
                                {{ $booking['pets']['MedicationNotes'] = $booking['pets']['MedicationNotes'] === '' || $booking['pets']['MedicationNotes'] === null ? 'None.' : $booking['pets']['MedicationNotes'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    @if ($roomStatus === 'vacant')
        <style>
            /* Style for the container */
            .vacant-container {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
            }

            /* Dotted lines on either side with bigger dots */
            .vacant-container::before,
            .vacant-container::after {
                content: '';
                flex-grow: 1;
                background: repeating-linear-gradient(to right, #E6348B, #E6348B 4px, transparent 4px, transparent 8px);
                height: 4px;
            }

            /* Adjustments to ensure the text is properly aligned without affecting the lines */
            .vacant-text {
                white-space: nowrap;
                padding: 0 20px;
                /* Adjust the spacing around the "VACANT" text */
                color: #FFF;
                /* Text color */
            }
        </style>
        <div
            style="display: flex; flex-direction: column; justify-content: space-around; height: 100vh; text-align: center; color: white;">

            <!-- Top Section: Room Image and Name -->
            <div style="flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <img src="{{ $room['image'] }}" style="width: 300px; max-width: 100%; padding-bottom: 15px;"
                    alt="London Suite">
                <h1 class="display-1 text-uppercase mb-0 pb-0" style="line-height: 1;">
                    {{ $room['name'] }}
                    <span
                        style="display: block; border-bottom: 1px solid #FFF; width: 100%; position: relative;"></span>
                    <!-- Custom thin line under text -->
                </h1>
                <h1 class="text-uppercase display-6 mt-0 pt-1" style="color: #E6348B;">SUITE</h1>
            </div>

            <!-- Middle Section: Vacant Indicator -->
            <div class="vacant-container">
                <h1 class="display-4 text-uppercase vacant-text">VACANT</h1>
            </div>
            <!-- Bottom Section: Next Booking -->
            <div style="flex: 1; display: flex; align-items: center;">
                <div class="bg-image"
                    style="flex: 20%;background-image: url('{{ asset('assets') }}/img/room-icons/vacant-icon.png');background-size: contain;background-repeat: no-repeat;background-position: center center;height: 120px;width: 100%;">
                </div>
                @if ($booking !== null)
                    <div style="flex: 80%; text-align: left;" class="ml-3">
                        <h3 style="color: #E6348B;">NEXT BOOKING</h3>

                        <div style="flex: 1; display: flex; text-align: left;" class="ml-0 pl-0">
                            <div class="bg-image ml-0 pl-0"
                                style="background-image: url('{{ $booking['DogPhoto'] }}');background-size: cover;background-repeat: no-repeat;background-position: center;height: 95px;width: 95px;border: 3px solid #E6348B;border-top-left-radius: 15px;border-bottom-right-radius: 15px;">
                            </div>
                            <div style="flex: 86%">
                                <div style="margin-left: 10px;">
                                    <span
                                        style="font-size: 1.4rem; font-weight: bold; text-transform: uppercase;">{{ $booking['DogName'] }}</span>
                                    <br>
                                    <span
                                        style="font-size: 1rem; font-weight: lighter; text-transform: uppercase; display: block; margin-top: -5px;">{{ $booking['pets']['Breed'] }}</span>
                                    <p style="font-weight: light; margin-top: 5px;" class="text-uppercase">
                                        {{ $booking['BookingDate'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
