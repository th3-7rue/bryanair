<div wire:click="hideAirports">
    <form wire:submit= "search">
        <div class="flex rounded-full bg-white">
            <button type="button" wire:click="updateTravelType('two-ways')"
                class="text-nowrap {{ $travelType != 'one-way' ? 'active' : '' }} basis-1/2 rounded-full px-5 py-1 text-xs font-semibold uppercase tracking-widest text-gray-400 md:py-3">Andata
                e Ritorno</button>
            <button type="button" wire:click="updateTravelType('one-way')"
                class="{{ $travelType != 'two-ways' ? 'active' : '' }} basis-1/2 rounded-full px-5 text-xs font-semibold uppercase tracking-widest text-gray-500 md:py-3">Solo
                Andata</button>
        </div>
        <div class="flex flex-row">
            <div class="flex grow flex-col p-3">
                {{-- Be like water. --}}
                <div class="relative inline-block text-left">
                    <div>
                        <div>Da</div>
                        <input wire:click.stop="toggleDeparture" type="text" wire:model.live='searchTerm'
                            placeholder="Partenza"
                            class="w-full border-none bg-transparent p-3 text-royal-blue focus:ring-0" />
                        <div>
                            @error('selectedAirportId')
                                <span class="text-red-600">{{ __('Scegli prima un aeroporto di partenza') }}</span>
                            @enderror
                        </div>
                        <hr>
                    </div>

                    @if ($showDeparture)

                        <ul wire:transition
                            class="absolute right-0 z-10 mt-2 w-full origin-top-right rounded-3xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            @foreach ($airports as $airport)
                                <li class="cursor-pointer p-2 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl hover:bg-amber hover:text-black"
                                    wire:click="selectAirport('{{ $airport->id }}')">
                                    {{ $airport->IATA }}, {{ $airport->location }}, {{ $airport->name }}
                                </li>

                                <hr class="last-of-type:hidden">
                            @endforeach
                        </ul>
                    @endif

                </div>
                <br>
                <div class="relative inline-block text-left">
                    <div>

                        <div>A</div>
                        <input wire:click.stop="toggleArrival" type="text" wire:model.live='searchTermA'
                            placeholder="Arrivo"
                            class="w-full border-none bg-transparent p-3 text-royal-blue focus:ring-0" />
                        <div>
                            @error('selectedAirportIdA')
                                <span class="text-red-600">{{ __('Scegli prima un aeroporto di arrivo') }}</span>
                            @enderror
                        </div>

                    </div>
                    @if ($showArrival)

                        <ul wire:transition
                            class="absolute right-0 z-10 mt-2 w-full origin-top-right rounded-3xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            @foreach ($airportsA as $airportA)
                                <li class="cursor-pointer p-2 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl hover:bg-amber hover:text-black"
                                    wire:click="selectAirportA('{{ $airportA->id }}')">
                                    {{ $airportA->IATA }}, {{ $airportA->location }}, {{ $airportA->name }}
                                </li>
                                <hr class="last-of-type:hidden">
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
            <button type="button" wire:click='swap' class="mb-auto mt-auto rounded-full bg-royal-blue p-3"><svg
                    class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                    <path
                        d="M336.155-453.847v-291.231L222.77-631.693l-42.769-42.153 186.153-186.153 186.153 186.153-42.768 42.153-113.385-113.385v291.231h-59.999Zm257.306 353.846L407.308-286.154l42.768-42.153 113.386 113.385v-291.231h59.998v291.231l113.386-113.385 42.768 42.153-186.153 186.153Z" />
                </svg></button>

        </div>
        <div class="flex">
            <div class="flex flex-col">
                <div>{{ __('Outbound') }}</div>
                <input min="{{ date('Y-m-d') }}" {{ $returnDate != null ? 'max=' . $returnDate : '' }} type="date"
                    class="border-none bg-transparent shadow-none" label="{{ __('') }}"
                    placeholder="{{ __('') }}" wire:model.live="departureDate" />
                <div>
                    @error('departureDate')
                        <span class="mr-2 text-red-600">{{ __('Scegli una data di andata') }}</span>
                    @enderror
                </div>

            </div>
            <div>
                @if ($travelType == 'two-ways')
                    <div wire:transition class="flex flex-col">
                        <div>{{ __('Return') }}</div>
                        <input {{ $departureDate != null ? 'min=' . $departureDate : 'min=' . date('Y-m-d') }}
                            type="date" class="border-none bg-transparent shadow-none" label="{{ __('') }}"
                            placeholder="{{ __('') }}" wire:model.live="returnDate" />
                        <div>
                            @error('returnDate')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col">
            <div>Passeggeri</div>

            <div>
                <div class="flex flex-row">
                    <div class="w-full grow p-4 text-gray-800">
                        {{-- se 1 usa singolare --}}
                        <ul class="list-inside list-disc">
                            @if ($adults == 1)
                                <li>{{ $adults }} {{ __('Adult') }}</li>
                            @elseif ($adults == 0)
                                <li>{{ __('No adults') }}</li>
                            @else
                                <li>{{ $adults }} {{ __('Adults') }}</li>
                            @endif
                            @if ($children == 1)
                                <li>{{ $children }} {{ __('Child') }}</li>
                            @elseif ($children == 0)
                                <li>{{ __('No children') }}</li>
                            @else
                                <li>{{ $children }} {{ __('Children') }}</li>
                            @endif
                            @if ($infants == 1)
                                <li>{{ $infants }} {{ __('Infant') }}</li>
                            @elseif ($infants == 0)
                                <li>{{ __('No infants') }}</li>
                            @else
                                <li>{{ $infants }} {{ __('Infants') }}</li>
                            @endif
                        </ul>
                    </div>
                    <div>
                        <div>
                            @if (!$showingPassengers)
                                <button type="button" wire:click="showPassengers"
                                    class="mb-auto mt-auto rounded-full bg-royal-blue p-3">
                                    <svg class="size-6 fill-white" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 -960 960 960">
                                        <path
                                            d="M450.001-450.001h-230v-59.998h230v-230h59.998v230h230v59.998h-230v230h-59.998v-230Z" />
                                    </svg>
                                </button>
                            @else
                                <button type="button" wire:click="closePassengers"
                                    class="button">{{ __('Close') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    @if ($showingPassengers)
                        <div wire:transition class="relative mb-3 rounded-3xl bg-white p-3">
                            <div name="content">

                                <div class="flex flex-row space-x-6">
                                    <div class="flex flex-col">
                                        <div>{{ __('Adults') }} (16+)</div>
                                        <div class="flex flex-row">

                                            <button type="button" @if ($adults == 0 || $adults + $children == 1 || $adults == $infants) disabled @endif
                                                wire:click="decrementAdults"
                                                class="rounded-full bg-gray-200 p-2">-</button>
                                            <div class="p-2">{{ $adults }}</div>

                                            <button type="button" wire:click="incrementAdults"
                                                class="rounded-full bg-gray-200 p-2">+</button>
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <div>{{ __('Children') }} (3-15)</div>
                                        <div class="flex flex-row">
                                            <button type="button" @if ($children == 0 || $children + $adults == 1) disabled @endif
                                                wire:click="decrementChildren"
                                                class="rounded-full bg-gray-200 p-2">-</button>
                                            <div class="p-2">{{ $children }}</div>
                                            <button type="button" wire:click="incrementChildren"
                                                class="rounded-full bg-gray-200 p-2">+</button>
                                        </div>
                                    </div>


                                    <div class="flex flex-col">
                                        <div>{{ __('Infants') }} (0-2)</div>
                                        <div class="flex flex-row">
                                            <button type="button" @if ($infants == 0) disabled @endif
                                                wire:click="decrementInfants"
                                                class="rounded-full bg-gray-200 p-2">-</button>
                                            <div class="p-2">{{ $infants }}</div>
                                            <button type="button" @if ($infants == $adults) disabled @endif
                                                wire:click="incrementInfants"
                                                class="rounded-full bg-gray-200 p-2">+</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <button type="submit" class="button">Cerca</button>
    </form>
</div>
