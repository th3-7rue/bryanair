<div>
    @foreach ($bookings as $booking)
        <div class="dark:bg-gray-800 mt-2 overflow-hidden bg-white shadow-xl sm:rounded-lg">
            <div class="dark:border-gray-700 border-b border-gray-200 p-6 sm:px-20">
                <div class="flex items-center justify-around">
                    <div class="flex flex-col items-center">
                        <div wire:transition
                            class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">

                            <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                                <div class="flex-col text-center">
                                    <p class="text-gray-400">Operato da</p>
                                    <p class="text-lg font-semibold text-petrol-blue">{{ $booking->goAirline }}
                                    </p>
                                </div>
                                <div class="flex items-center pl-2">
                                    <div class="flex-col text-center">

                                        <p class="text-lg font-semibold text-petrol-blue">
                                            {{ // keep only time(H:m) from datetime
                                                Carbon\Carbon::parse($booking->goDepartureDatetime)->format('d-m-y H:i') }}
                                        </p>
                                        <p class="text-gray-400">{{ $booking->goDeparture }}</p>
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
                                            
                                                Carbon\Carbon::parse($booking->goDepartureDatetime)->diff($booking->goArrivalDatetime)->format('%h') .
                                                    ' h ' .
                                                    Carbon\Carbon::parse($booking->goDepartureDatetime)->diff($booking->goArrivalDatetime)->format('%i') .
                                                    ' m' }}
                                        </p>

                                    </div>
                                    <svg class="fill-gray-300" height="24" viewBox="0 -960 960 960" width="24">
                                        <path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z" />
                                    </svg>
                                    <div class="flex-col text-center">
                                        <p class="text-lg font-semibold text-petrol-blue">
                                            {{ // keep only time(H:m) from datetime
                                                Carbon\Carbon::parse($booking->goArrivalDatetime)->format('d-m-y H:i') }}
                                        </p>
                                        <p class="text-gray-400">{{ $booking->goArrival }}</p>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if ($booking->backDeparture != null)
                            <div wire:transition
                                class="m-4 flex flex-col items-center justify-center space-y-6 rounded-lg bg-white p-4 shadow-lg">
                                <div class="flex flex-row items-center justify-center space-x-3 divide-x divide-dashed">
                                    <div class="flex-col text-center">
                                        <p class="text-gray-400">Operato da</p>
                                        <p class="text-lg font-semibold text-petrol-blue">{{ $booking->backAirline }}
                                        </p>
                                    </div>

                                    <div class="flex items-center pl-2">
                                        <div class="flex-col text-center">

                                            <p class="text-lg font-semibold text-petrol-blue">
                                                {{ // keep only time(H:m) from datetime
                                                    Carbon\Carbon::parse($booking->backDepartureDatetime)->format('d-m-y H:i') }}
                                            </p>
                                            <p class="text-gray-400">{{ $booking->backDeparture }}</p>
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
                                                
                                                    Carbon\Carbon::parse($booking->backDepartureDatetime)->diff($booking->backArrivalDatetime)->format('%h') .
                                                        ' h ' .
                                                        Carbon\Carbon::parse($booking->backDepartureDatetime)->diff($booking->backArrivalDatetime)->format('%i') .
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
                                                    Carbon\Carbon::parse($booking->backArrivalDatetime)->format('d-m-y H:i') }}
                                            </p>
                                            <p class="text-gray-400">{{ $booking->backArrival }}</p>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

                    </div>
                    <div>
                        Prezzo: {{ $booking->price }} €
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
