<div class="flex justify-center">
    <div class="mt-24 max-w-max">
        {{-- mostra info ricerca --}}
        <div class="flex items-center justify-around rounded-lg bg-white p-4 shadow-lg">
            <div class="flex flex-col items-center justify-center space-y-6">
                <div class="flex items-center space-x-2">

                    <div class="text-lg font-semibold text-petrol-blue">
                        {{ $goDepartureAirportName . ' (' . $departureIATA . ')' }}
                    </div>

                    <svg class="size-4 fill-royal-blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                        <path
                            d="M624-104 520-280H400q-17 0-28.5-11.5T360-320q0-17 11.5-28.5T400-360h120l104-176h44l-52 176h114l30-40h40l-24 80 24 80h-40l-30-40H616l52 176h-44ZM292-424l52-176H230l-30 40h-40l24-80-24-80h40l30 40h114l-52-176h44l104 176h120q17 0 28.5 11.5T600-640q0 17-11.5 28.5T560-600H440L336-424h-44Z" />
                    </svg>
                    <div class="text-lg font-semibold text-petrol-blue">
                        {{ $goArrivalAirportName . ' (' . $arrivalIATA . ')' }}
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center space-x-3">
                    <p class="text-gray-400">
                        {{ $travelType == 'one-way' ? 'Solo andata' : 'Andata e ritorno' }}</p>
                    <div class="text-amber">
                        {{-- dot --}}
                        •
                    </div>
                    <p class="text-gray-400">
                        {{ // format day and short month
                            Carbon\Carbon::parse($departureDate)->format('d M') }}
                        -
                        {{ Carbon\Carbon::parse($returnDate)->format('d M') }}</p>
                    <div class="text-amber">
                        {{-- dot --}}
                        •
                    </div>
                    <div class="flex space-x-1 divide-x divide-dashed">
                        <div>
                            @if ($adults > 0)
                                <p class="text-gray-400">
                                    {{ $adults }} {{ $adults == 1 ? 'adulto' : 'adulti' }}
                                </p>
                            @endif
                        </div>
                        <div>
                            @if ($children > 0)
                                <p class="pl-1 text-gray-400">{{ $children }}
                                    {{ $children == 1 ? 'bambino' : 'bambini' }}</p>
                            @endif
                        </div>
                        <div>
                            @if ($infants > 0)
                                <p class="pl-1 text-gray-400">{{ $infants }}
                                    {{ $infants == 1 ? 'neonato' : 'neonati' }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <button wire:click.stop='showSearch()' class="button">Modifica ricerca</button>
        </div>
        <div class="mt-9 flex items-center space-x-2">
            <button {{ $goFlightId != null || $departureDate == date('Y-m-d') ? 'disabled' : '' }}
                wire:click="goDateBefore()"
                class="flex-col whitespace-nowrap rounded-full bg-white p-5 text-lg font-semibold text-petrol-blue shadow-lg">
                <div>
                    {{ // day before
                        Carbon\Carbon::parse($departureDate)->subDay()->format('j M') }}
                </div>
                <svg class="size-4 w-full fill-royal-blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                    <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                </svg>
            </button>
            <div
                class="flex w-full items-center space-x-2 rounded-lg bg-white p-4 text-lg font-semibold text-petrol-blue shadow-lg">
                <svg class="size-5 fill-royal-blue" viewBox="0 0 19 13" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17.737 1.076c-1.21-.656-2.586-.308-3.526.1l-2.804 1.217L6.585.136 3.714.251l3.981 3.757-2.537 1.121-2.64-.935-1.768.767 1.597 1.846c-.168.188-.321.451-.182.728.18.362.717.545 1.596.545.18 0 .375-.008.584-.023.965-.071 2.012-.3 2.666-.584l10.022-4.35c.865-.375 1.296-.77 1.318-1.205.01-.226-.087-.556-.614-.842zM.75 11.533h17.602v.662H.75z">
                    </path>
                </svg>
                <div>
                    {{ $goDepartureAirportName }} a {{ $goArrivalAirportName }}
                </div>
            </div>
            <button {{ $goFlightId != null || $departureDate == $returnDate ? 'disabled' : '' }}
                wire:click="goDateAfter()"
                class="flex-col whitespace-nowrap rounded-full bg-white p-5 text-lg font-semibold text-petrol-blue shadow-lg">
                <div>
                    {{ // day after
                        Carbon\Carbon::parse($departureDate)->addDay()->format('j M') }}
                </div>
                <svg class="size-4 w-full fill-royal-blue" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                    <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                </svg>
            </button>
        </div>
        <div>
            @if (count($goFlights) == 0)
                <div class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">
                    <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                        <div class="flex-col text-center">
                            <p class="text-lg font-semibold text-petrol-blue">Nessun volo disponibile</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div>
            @if ($goFlightId != null)
                <div wire:transition
                    class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">

                    <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                        <div class="flex-col text-center">
                            <p class="text-gray-400">Operato da</p>
                            <p class="text-lg font-semibold text-petrol-blue">{{ $selectedGoFlight->airline_name }}
                            </p>
                        </div>
                        <div class="flex items-center pl-2">
                            <div class="flex-col text-center">

                                <p class="text-lg font-semibold text-petrol-blue">
                                    {{ // keep only time(H:m) from datetime
                                        Carbon\Carbon::parse($selectedGoFlight->departure_datetime)->format('H:i') }}
                                </p>
                                <p class="text-gray-400">{{ $goDepartureAirportName }}</p>
                            </div>
                            <svg class="fill-gray-300" xmlns="http://www.w3.org/2000/svg" height="24"
                                viewBox="0 -960 960 960" width="24">
                                <path d="M160-440v-80h640v80H160Z" />
                            </svg>
                            <div class="flex-col">
                                <svg class="size-3 w-full fill-amber" viewBox="0 0 24 11"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m23.1618494 1.26214095c-1.6504761-.88158798-3.5258375-.41328823-4.8082073.13474428l-3.8227532 1.6336838-6.57463364-3.03056903-3.91538504.1541681 5.42911193 5.04421721-3.45998247 1.50631968-3.59979471-1.25557579-2.41020497 1.02996062 2.17815617 2.47886909c-.23012206.25160415-.43865474.6058512-.24934007.97793738.24726511.48591251.97809285.73077041 2.17687167.73077041.24583241 0 .51137686-.0102779.79638634-.0309242 1.3159148-.0952628 2.74259252-.4031009 3.63467367-.78433304l13.66484342-5.83977894c1.1802525-.50443077 1.7681556-1.03408082 1.7973037-1.619331.0151175-.30353684-.1178276-.74611927-.8370455-1.13015857z">
                                    </path>
                                </svg>
                                <p class="text-lg font-semibold text-petrol-blue">
                                    {{-- add a horizontal line --}}
                                    {{ // durata del volo (H:m), truncate hours decimal and 0
                                        // remove leading 0 from minutes and hours
                                    
                                        Carbon\Carbon::parse($selectedGoFlight->departure_datetime)->diff($selectedGoFlight->arrival_datetime)->format('%h') .
                                            ' h ' .
                                            Carbon\Carbon::parse($selectedGoFlight->departure_datetime)->diff($selectedGoFlight->arrival_datetime)->format('%i') .
                                            ' m' }}
                                </p>

                            </div>
                            <svg class="fill-gray-300" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                            </svg>
                            <div class="flex-col text-center">
                                <p class="text-lg font-semibold text-petrol-blue">
                                    {{ // keep only time(H:m) from datetime
                                        Carbon\Carbon::parse($selectedGoFlight->arrival_datetime)->format('H:i') }}
                                </p>
                                <p class="text-gray-400">{{ $goArrivalAirportName }}</p>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 pl-2">
                            <p class="text-lg font-semibold text-petrol-blue">{{ $selectedGoFlight->base_price }}€
                            </p>
                            <button wire:click="deselectGoFlight()"
                                class="button text-lg font-semibold">Deseleziona</button>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($goFlights as $flight)
                    <div wire:key="go-flight-{{ $flight->id }}">
                        @if (
                            ($returnFlightId == null ||
                                !Carbon\Carbon::parse($flight->arrival_datetime)->gt(Carbon\Carbon::parse($selectedReturnFlight->departure_datetime))) && // date of the flight > now +1h
                                Carbon\Carbon::parse($flight->departure_datetime)->gt(Carbon\Carbon::now()->addHour()))
                            <div wire:transition
                                class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">

                                <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                                    <div class="flex-col text-center">
                                        <p class="text-gray-400">Operato da</p>
                                        <p class="text-lg font-semibold text-petrol-blue">{{ $flight->airline_name }}
                                        </p>
                                    </div>
                                    <div class="flex items-center pl-2">
                                        <div class="flex-col text-center">

                                            <p class="text-lg font-semibold text-petrol-blue">
                                                {{ // keep only time(H:m) from datetime
                                                    Carbon\Carbon::parse($flight->departure_datetime)->format('H:i') }}
                                            </p>
                                            <p class="text-gray-400">{{ $goDepartureAirportName }}</p>
                                        </div>
                                        <svg class="fill-gray-300" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 -960 960 960" width="24">
                                            <path d="M160-440v-80h640v80H160Z" />
                                        </svg>
                                        <div class="flex-col">
                                            <svg class="size-3 w-full fill-amber" viewBox="0 0 24 11"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="m23.1618494 1.26214095c-1.6504761-.88158798-3.5258375-.41328823-4.8082073.13474428l-3.8227532 1.6336838-6.57463364-3.03056903-3.91538504.1541681 5.42911193 5.04421721-3.45998247 1.50631968-3.59979471-1.25557579-2.41020497 1.02996062 2.17815617 2.47886909c-.23012206.25160415-.43865474.6058512-.24934007.97793738.24726511.48591251.97809285.73077041 2.17687167.73077041.24583241 0 .51137686-.0102779.79638634-.0309242 1.3159148-.0952628 2.74259252-.4031009 3.63467367-.78433304l13.66484342-5.83977894c1.1802525-.50443077 1.7681556-1.03408082 1.7973037-1.619331.0151175-.30353684-.1178276-.74611927-.8370455-1.13015857z">
                                                </path>
                                            </svg>
                                            <p class="text-lg font-semibold text-petrol-blue">
                                                {{-- add a horizontal line --}}
                                                {{ // durata del volo (H:m), truncate hours decimal and 0
                                                    // remove leading 0 from minutes and hours
                                                
                                                    Carbon\Carbon::parse($flight->departure_datetime)->diff($flight->arrival_datetime)->format('%h') .
                                                        ' h ' .
                                                        Carbon\Carbon::parse($flight->departure_datetime)->diff($flight->arrival_datetime)->format('%i') .
                                                        ' m' }}
                                            </p>

                                        </div>
                                        <svg class="fill-gray-300" height="24" viewBox="0 -960 960 960"
                                            width="24">
                                            <path
                                                d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                        </svg>
                                        <div class="flex-col text-center">
                                            <p class="text-lg font-semibold text-petrol-blue">
                                                {{ // keep only time(H:m) from datetime
                                                    Carbon\Carbon::parse($flight->arrival_datetime)->format('H:i') }}
                                            </p>
                                            <p class="text-gray-400">{{ $goArrivalAirportName }}</p>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 pl-2">
                                        <p class="text-lg font-semibold text-petrol-blue">{{ $flight->base_price }}€
                                        </p>
                                        <button wire:click="selectGoFlight({{ $flight->id }})"
                                            class="button text-lg font-semibold">Seleziona</button>
                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        {{-- ritorno --}}
        <div>
            @if ($travelType == 'two-ways')
                <div class="mt-9 flex items-center space-x-2">

                    <button {{ $returnFlightId != null || $returnDate == $departureDate ? 'disabled' : '' }}
                        wire:click="returnDateBefore()"
                        class="flex-col whitespace-nowrap rounded-full bg-white p-5 text-lg font-semibold text-petrol-blue shadow-lg">
                        <div>
                            {{ // day before
                                Carbon\Carbon::parse($returnDate)->subDay()->format('j M') }}
                        </div>
                        <svg class="size-4 w-full fill-royal-blue" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 -960 960 960">
                            <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                        </svg>
                    </button>
                    <div
                        class="flex w-full items-center space-x-2 rounded-lg bg-white p-4 text-lg font-semibold text-petrol-blue shadow-lg">
                        <svg class="size-5 fill-royal-blue" viewBox="0 0 19 13" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.737 1.076c-1.21-.656-2.586-.308-3.526.1l-2.804 1.217L6.585.136 3.714.251l3.981 3.757-2.537 1.121-2.64-.935-1.768.767 1.597 1.846c-.168.188-.321.451-.182.728.18.362.717.545 1.596.545.18 0 .375-.008.584-.023.965-.071 2.012-.3 2.666-.584l10.022-4.35c.865-.375 1.296-.77 1.318-1.205.01-.226-.087-.556-.614-.842zM.75 11.533h17.602v.662H.75z">
                            </path>
                        </svg>
                        <div> {{ $returnDepartureAirportName }} a {{ $returnArrivalAirportName }}
                        </div>
                    </div>
                    <button {{ $returnFlightId != null ? 'disabled' : '' }} wire:click="returnDateAfter()"
                        class="flex-col whitespace-nowrap rounded-full bg-white p-5 text-lg font-semibold text-petrol-blue shadow-lg">
                        <div>
                            {{ // day after
                                Carbon\Carbon::parse($returnDate)->addDay()->format('j M') }}
                        </div>
                        <svg class="size-4 w-full fill-royal-blue" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 -960 960 960">
                            <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                        </svg>
                    </button>
                </div>
                <div>
                    @if (count($returnFlights) == 0)
                        <div
                            class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">
                            <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                                <div class="flex-col text-center">
                                    <p class="text-lg font-semibold text-petrol-blue">Nessun volo disponibile</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    @if ($returnFlightId != null)
                        <div wire:transition
                            class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">

                            <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                                <div class="flex-col text-center">
                                    <p class="text-gray-400">Operato da</p>
                                    <p class="text-lg font-semibold text-petrol-blue">
                                        {{ $selectedReturnFlight->airline_name }}
                                    </p>
                                </div>
                                <div class="flex items-center pl-2">
                                    <div class="flex-col text-center">

                                        <p class="text-lg font-semibold text-petrol-blue">
                                            {{ // keep only time(H:m) from datetime
                                                Carbon\Carbon::parse($selectedReturnFlight->departure_datetime)->format('H:i') }}
                                        </p>
                                        <p class="text-gray-400">{{ $returnDepartureAirportName }}</p>
                                    </div>
                                    <svg class="fill-gray-300" xmlns="http://www.w3.org/2000/svg" height="24"
                                        viewBox="0 -960 960 960" width="24">
                                        <path d="M160-440v-80h640v80H160Z" />
                                    </svg>
                                    <div class="flex-col">
                                        <svg class="size-3 w-full fill-amber" viewBox="0 0 24 11"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m23.1618494 1.26214095c-1.6504761-.88158798-3.5258375-.41328823-4.8082073.13474428l-3.8227532 1.6336838-6.57463364-3.03056903-3.91538504.1541681 5.42911193 5.04421721-3.45998247 1.50631968-3.59979471-1.25557579-2.41020497 1.02996062 2.17815617 2.47886909c-.23012206.25160415-.43865474.6058512-.24934007.97793738.24726511.48591251.97809285.73077041 2.17687167.73077041.24583241 0 .51137686-.0102779.79638634-.0309242 1.3159148-.0952628 2.74259252-.4031009 3.63467367-.78433304l13.66484342-5.83977894c1.1802525-.50443077 1.7681556-1.03408082 1.7973037-1.619331.0151175-.30353684-.1178276-.74611927-.8370455-1.13015857z">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-semibold text-petrol-blue">
                                            {{-- add a horizontal line --}}
                                            {{ // durata del volo (H:m), truncate hours decimal and 0
                                                // remove leading 0 from minutes and hours
                                            
                                                Carbon\Carbon::parse($selectedReturnFlight->departure_datetime)->diff($selectedReturnFlight->arrival_datetime)->format('%h') .
                                                    ' h ' .
                                                    Carbon\Carbon::parse($selectedReturnFlight->departure_datetime)->diff($selectedReturnFlight->arrival_datetime)->format('%i') .
                                                    ' m' }}
                                        </p>

                                    </div>
                                    <svg class="fill-gray-300" height="24" viewBox="0 -960 960 960"
                                        width="24">
                                        <path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                    </svg>
                                    <div class="flex-col text-center">
                                        <p class="text-lg font-semibold text-petrol-blue">
                                            {{ // keep only time(H:m) from datetime
                                                Carbon\Carbon::parse($selectedReturnFlight->arrival_datetime)->format('H:i') }}
                                        </p>
                                        <p class="text-gray-400">{{ $returnArrivalAirportName }}</p>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 pl-2">
                                    <p class="text-lg font-semibold text-petrol-blue">
                                        {{ $selectedReturnFlight->base_price }}€
                                    </p>
                                    <button wire:click="deselectReturnFlight()"
                                        class="button text-lg font-semibold">Deseleziona</button>
                                </div>
                            </div>
                        </div>
                    @else
                        @foreach ($returnFlights as $flight)
                            <div wire:key="return-flight-{{ $flight->id }}">
                                @if (
                                    $goFlightId == null ||
                                        !Carbon\Carbon::parse($flight->departure_datetime)->lt(Carbon\Carbon::parse($selectedGoFlight->arrival_datetime)))
                                    <div wire:transition
                                        class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">

                                        <div
                                            class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                                            <div class="flex-col text-center">
                                                <p class="text-gray-400">Operato da</p>
                                                <p class="text-lg font-semibold text-petrol-blue">
                                                    {{ $flight->airline_name }}</p>
                                            </div>
                                            <div class="flex items-center pl-2">
                                                <div class="flex-col text-center">

                                                    <p class="text-lg font-semibold text-petrol-blue">
                                                        {{ // keep only time(H:m) from datetime
                                                            Carbon\Carbon::parse($flight->departure_datetime)->format('H:i') }}
                                                    </p>
                                                    <p class="text-gray-400">{{ $returnDepartureAirportName }}</p>
                                                </div>
                                                <svg class="fill-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                    height="24" viewBox="0 -960 960 960" width="24">
                                                    <path d="M160-440v-80h640v80H160Z" />
                                                </svg>
                                                <div class="flex-col">
                                                    <svg class="size-3 w-full fill-amber" viewBox="0 0 24 11"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="m23.1618494 1.26214095c-1.6504761-.88158798-3.5258375-.41328823-4.8082073.13474428l-3.8227532 1.6336838-6.57463364-3.03056903-3.91538504.1541681 5.42911193 5.04421721-3.45998247 1.50631968-3.59979471-1.25557579-2.41020497 1.02996062 2.17815617 2.47886909c-.23012206.25160415-.43865474.6058512-.24934007.97793738.24726511.48591251.97809285.73077041 2.17687167.73077041.24583241 0 .51137686-.0102779.79638634-.0309242 1.3159148-.0952628 2.74259252-.4031009 3.63467367-.78433304l13.66484342-5.83977894c1.1802525-.50443077 1.7681556-1.03408082 1.7973037-1.619331.0151175-.30353684-.1178276-.74611927-.8370455-1.13015857z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-lg font-semibold text-petrol-blue">
                                                        {{ // durata del volo (H:m), truncate hours decimal and 0
                                                            // remove leading 0 from minutes and hours
                                                        
                                                            Carbon\Carbon::parse($flight->departure_datetime)->diff($flight->arrival_datetime)->format('%h') .
                                                                ' h ' .
                                                                Carbon\Carbon::parse($flight->departure_datetime)->diff($flight->arrival_datetime)->format('%i') .
                                                                ' m' }}
                                                    </p>

                                                </div>
                                                <svg class="fill-gray-300" height="24" viewBox="0 -960 960 960"
                                                    width="24">
                                                    <path
                                                        d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                                </svg>
                                                <div class="flex-col text-center">
                                                    <p class="text-lg font-semibold text-petrol-blue">
                                                        {{ // keep only time(H:m) from datetime
                                                            Carbon\Carbon::parse($flight->arrival_datetime)->format('H:i') }}
                                                    </p>
                                                    <p class="text-gray-400">{{ $returnArrivalAirportName }}</p>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2 pl-2">
                                                <p class="text-lg font-semibold text-petrol-blue">
                                                    {{ $flight->base_price }}€</p>
                                                <button wire:click="selectReturnFlight({{ $flight->id }})"
                                                    class="button text-lg font-semibold">Seleziona</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
        <div>
            @if (($goFlightId != null && $returnFlightId != null) || ($goFlightId != null && $travelType == 'one-way'))
                {{-- passeggeri --}}
                <div class="mt-9 flex-col items-center justify-around rounded-lg bg-white p-4 shadow-lg">

                    <div class="text-lg font-semibold text-royal-blue">
                        Passeggeri
                    </div>
                    <div class="text-royal-blue">
                        Inserisci i nomi come indicati sul passaporto o sulla documentazione di viaggio
                    </div>
                </div>
                <form wire:submit="goToSeats">
                    @for ($i = 0; $i < $adults; $i++)
                        <div class="mt-4 flex-col items-center justify-around rounded-lg bg-white p-4 shadow-lg">
                            <p class="text-lg font-semibold text-petrol-blue">Adulto
                                {{ $i + 1 }}</p>
                            <div class="flex space-x-2">
                                <div class="flex-col">
                                    <p class="text-royal-blue">Nome</p>
                                    <input required class="rounded text-royal-blue" type="text"
                                        wire:model.blur="adultsNames.{{ $i }}.name">
                                    <div class="text-red-600">
                                        @error('adultsNames.' . $i . '.name')
                                            Almeno 2 lettere
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col">
                                    <p class="text-royal-blue">Cognome</p>
                                    <input required class="rounded text-royal-blue" type="text"
                                        wire:model.blur="adultsNames.{{ $i }}.surname">
                                    <div class="text-red-600">
                                        @error('adultsNames.' . $i . '.surname')
                                            Almeno 2 lettere
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                    @for ($i = 0; $i < $children; $i++)
                        <div class="mt-4 flex-col items-center justify-around rounded-lg bg-white p-4 shadow-lg">
                            <p class="text-lg font-semibold text-petrol-blue">Bambino
                                {{ $i + 1 }}</p>
                            <div class="flex space-x-2">
                                <div class="flex-col">
                                    <p class="text-royal-blue">Nome</p>
                                    <input required class="rounded text-royal-blue" type="text"
                                        wire:model.blur="childrenNames.{{ $i }}.name">
                                    <div class="text-red-600">
                                        @error('childrenNames.' . $i . '.name')
                                            Almeno 2 lettere
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col">
                                    <p class="text-royal-blue">Cognome</p>
                                    <input required class="rounded text-royal-blue" type="text"
                                        wire:model.blur="childrenNames.{{ $i }}.surname">
                                    <div class="text-red-600">
                                        @error('childrenNames.' . $i . '.surname')
                                            Almeno 2 lettere
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                    @for ($i = 0; $i < $infants; $i++)
                        <div class="mt-4 flex-col items-center justify-around rounded-lg bg-white p-4 shadow-lg">
                            <p class="text-lg font-semibold text-petrol-blue">Neonato
                                {{ $i + 1 }}</p>
                            <div class="flex space-x-2">
                                <div class="flex-col">
                                    <p class="text-royal-blue">Nome</p>
                                    <input required class="rounded text-royal-blue" type="text"
                                        wire:model.blur="infantsNames.{{ $i }}.name">
                                    <div class="text-red-600">
                                        @error('infantsNames.' . $i . '.name')
                                            Almeno 2 lettere
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex-col">
                                    <p class="text-royal-blue">Cognome</p>
                                    <input required class="rounded text-royal-blue" type="text"
                                        wire:model.blur="infantsNames.{{ $i }}.surname">
                                    <div class="text-red-600">
                                        @error('infantsNames.' . $i . '.surname')
                                            Almeno 2 lettere
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <button class="button m-2 text-lg font-semibold">Prosegui per
                        {{ $this->calcPrice() }}€</button>
                </form>

        </div>
        @endif
    </div>
