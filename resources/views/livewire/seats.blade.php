<div>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 1fr max-content 1fr;
            /* Define three columns: fixed width, auto width, fixed width */
        }
    </style>
    <div class="relative mt-20 flex flex-row justify-center overflow-hidden border md:ml-20 md:mr-20">
        @if (!$showBackSeats)
            {{ $goAircraft }}
            <div class="grid-container mt-52 md:mt-0">
                <svg class="self-center" height="636" viewBox="0 0 817 636" width="817"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                    transform="matrix(-1,0,0,1,0,0)">
                    <mask id="a" fill="#fff">
                        <path d="m0 0h820v655h-820z" fill="#fff" fill-rule="evenodd"></path>
                    </mask>
                    <g fill="none" fill-rule="evenodd" mask="url(#a)" opacity=".384794" transform="translate(0 -12)">
                        <g transform="matrix(-1 0 0 1 814 -35)">
                            <path
                                d="m889.257415 3.26083412v430.20930488c0 3.050847-2.374456 6.003233-5.357631 6.661755l-323.309925 71.369136c-2.549497.562789-6.668731 1.361078-9.237394 1.790363-1.498813.250487-1.498813.250487-5.995253 1.001949-2.37467.396864-2.37467.396864-4.307789.719934-53.836639 8.997386-133.717731 30.355619-232.721586 61.157661-19.639618 6.110271-39.860831 12.540939-60.575256 19.254665-57.468633 18.626085-116.173444 38.583001-172.9650326 58.539944-19.8770706 6.984935-38.0950777 13.470907-54.2603966 19.291578-5.6576699 2.037165-10.65457089 3.845633-14.94150125 5.404611-1.50031053.5456-2.80467876 1.021031-3.90695453 1.423694-.66120388.241539-1.10801554.405112-1.33428483.48812l-1.36651642.501315 1.18151992-77.382861 551.20676131-371.694727c2.13195-1.437636 5.586362-3.805481 7.697436-5.2763l324.788001-226.28507721c2.77882-1.93604869 5.405802-.56424036 5.405802 2.82493533z"
                                fill="#efefef" stroke="#d2d6d9" stroke-width="2"></path>
                            <path d="m414.466211 481.494542 18.491024 58.290292 422.36633-93.08963v-83.328034z"
                                fill="#e3e3e3" stroke="#d2d6d9" stroke-width="2"></path>
                            <path
                                d="m801.657576 58.9199601 41.393223-28.7227622 25.314049 413.8524401-66.707272 15.630602z"
                                fill="#828790" opacity=".157708"></path>
                        </g>
                    </g>
                </svg>
                <div
                    class="grid grid-cols-7 gap-1 rounded-b-[100px] rounded-t-3xl border-2 border-t-0 border-gray-400 p-3 pb-40 pt-20">
                    <div class="p-2 text-center font-semibold text-gray-500">A</div>
                    <div class="p-2 text-center font-semibold text-gray-500">B</div>
                    <div class="p-2 text-center font-semibold text-gray-500">C</div>
                    <div class="p-2 text-center font-semibold text-gray-500"> </div>
                    <div class="p-2 text-center font-semibold text-gray-500">D</div>
                    <div class="p-2 text-center font-semibold text-gray-500">E</div>
                    <div class="p-2 text-center font-semibold text-gray-500">F</div>
                    @foreach ($this->goSeats as $row)
                        {{-- if iteration in array corridoio, leave blank --}}
                        @if (in_array($loop->iteration, $corridoio))
                            <div class="p-2 text-center font-semibold text-gray-500">{{ ($loop->iteration + 2) / 6 }}
                            </div>
                        @endif
                        <button {{ in_array($row->number, $occupiedGoSeats) ? 'disabled' : '' }}
                            wire:click="selectGoSeat({{ $row->id }}, '{{ $row->number }}')"
                            class="size-10 rounded-xl bg-royal-blue p-2 text-center uppercase tracking-widest text-white">

                            @if (in_array($row->number, $selectedGoSeats))
                                {{ $passengers[array_search($row->number, $selectedGoSeats)]['initials'] }}
                            @endif
                        </button>
                    @endforeach
                </div>

                <svg class="self-center" height="636" viewBox="0 0 817 636" width="817"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <mask id="a" fill="#fff">
                        <path d="m0 0h820v655h-820z" fill="#fff" fill-rule="evenodd" />
                    </mask>
                    <g fill="none" fill-rule="evenodd" mask="url(#a)" opacity=".384794" transform="translate(0 -12)">
                        <g transform="matrix(-1 0 0 1 814 -35)">
                            <path
                                d="m889.257415 3.26083412v430.20930488c0 3.050847-2.374456 6.003233-5.357631 6.661755l-323.309925 71.369136c-2.549497.562789-6.668731 1.361078-9.237394 1.790363-1.498813.250487-1.498813.250487-5.995253 1.001949-2.37467.396864-2.37467.396864-4.307789.719934-53.836639 8.997386-133.717731 30.355619-232.721586 61.157661-19.639618 6.110271-39.860831 12.540939-60.575256 19.254665-57.468633 18.626085-116.173444 38.583001-172.9650326 58.539944-19.8770706 6.984935-38.0950777 13.470907-54.2603966 19.291578-5.6576699 2.037165-10.65457089 3.845633-14.94150125 5.404611-1.50031053.5456-2.80467876 1.021031-3.90695453 1.423694-.66120388.241539-1.10801554.405112-1.33428483.48812l-1.36651642.501315 1.18151992-77.382861 551.20676131-371.694727c2.13195-1.437636 5.586362-3.805481 7.697436-5.2763l324.788001-226.28507721c2.77882-1.93604869 5.405802-.56424036 5.405802 2.82493533z"
                                fill="#efefef" stroke="#d2d6d9" stroke-width="2" />
                            <path d="m414.466211 481.494542 18.491024 58.290292 422.36633-93.08963v-83.328034z"
                                fill="#e3e3e3" stroke="#d2d6d9" stroke-width="2" />
                            <path
                                d="m801.657576 58.9199601 41.393223-28.7227622 25.314049 413.8524401-66.707272 15.630602z"
                                fill="#828790" opacity=".157708" />
                        </g>
                    </g>
                </svg>
            </div>
        @else
            {{ $backAircraft }}

            <div class="grid-container mt-52 md:mt-0">
                <svg class="self-center" height="636" viewBox="0 0 817 636" width="817"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                    transform="matrix(-1,0,0,1,0,0)">
                    <mask id="a" fill="#fff">
                        <path d="m0 0h820v655h-820z" fill="#fff" fill-rule="evenodd"></path>
                    </mask>
                    <g fill="none" fill-rule="evenodd" mask="url(#a)" opacity=".384794" transform="translate(0 -12)">
                        <g transform="matrix(-1 0 0 1 814 -35)">
                            <path
                                d="m889.257415 3.26083412v430.20930488c0 3.050847-2.374456 6.003233-5.357631 6.661755l-323.309925 71.369136c-2.549497.562789-6.668731 1.361078-9.237394 1.790363-1.498813.250487-1.498813.250487-5.995253 1.001949-2.37467.396864-2.37467.396864-4.307789.719934-53.836639 8.997386-133.717731 30.355619-232.721586 61.157661-19.639618 6.110271-39.860831 12.540939-60.575256 19.254665-57.468633 18.626085-116.173444 38.583001-172.9650326 58.539944-19.8770706 6.984935-38.0950777 13.470907-54.2603966 19.291578-5.6576699 2.037165-10.65457089 3.845633-14.94150125 5.404611-1.50031053.5456-2.80467876 1.021031-3.90695453 1.423694-.66120388.241539-1.10801554.405112-1.33428483.48812l-1.36651642.501315 1.18151992-77.382861 551.20676131-371.694727c2.13195-1.437636 5.586362-3.805481 7.697436-5.2763l324.788001-226.28507721c2.77882-1.93604869 5.405802-.56424036 5.405802 2.82493533z"
                                fill="#efefef" stroke="#d2d6d9" stroke-width="2"></path>
                            <path d="m414.466211 481.494542 18.491024 58.290292 422.36633-93.08963v-83.328034z"
                                fill="#e3e3e3" stroke="#d2d6d9" stroke-width="2"></path>
                            <path
                                d="m801.657576 58.9199601 41.393223-28.7227622 25.314049 413.8524401-66.707272 15.630602z"
                                fill="#828790" opacity=".157708"></path>
                        </g>
                    </g>
                </svg>
                <div
                    class="grid grid-cols-7 gap-1 rounded-b-[100px] rounded-t-3xl border-2 border-t-0 border-gray-400 p-3 pb-40 pt-20">
                    <div class="p-2 text-center font-semibold text-gray-500">A</div>
                    <div class="p-2 text-center font-semibold text-gray-500">B</div>
                    <div class="p-2 text-center font-semibold text-gray-500">C</div>
                    <div class="p-2 text-center font-semibold text-gray-500"> </div>
                    <div class="p-2 text-center font-semibold text-gray-500">D</div>
                    <div class="p-2 text-center font-semibold text-gray-500">E</div>
                    <div class="p-2 text-center font-semibold text-gray-500">F</div>
                    @foreach ($this->backSeats as $row)
                        {{-- if iteration in array corridoio, leave blank --}}
                        @if (in_array($loop->iteration, $corridoio))
                            <div class="p-2 text-center font-semibold text-gray-500">{{ ($loop->iteration + 2) / 6 }}
                            </div>
                        @endif
                        <button {{ in_array($row->number, $occupiedBackSeats) ? 'disabled' : '' }}
                            wire:click="selectBackSeat({{ $row->id }}, '{{ $row->number }}')"
                            class="size-10 rounded-xl bg-royal-blue p-2 text-center uppercase tracking-widest text-white">

                            @if (in_array($row->number, $selectedBackSeats))
                                {{ $passengers[array_search($row->number, $selectedBackSeats)]['initials'] }}
                            @endif
                        </button>
                    @endforeach
                </div>

                <svg class="self-center" height="636" viewBox="0 0 817 636" width="817"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <mask id="a" fill="#fff">
                        <path d="m0 0h820v655h-820z" fill="#fff" fill-rule="evenodd" />
                    </mask>
                    <g fill="none" fill-rule="evenodd" mask="url(#a)" opacity=".384794"
                        transform="translate(0 -12)">
                        <g transform="matrix(-1 0 0 1 814 -35)">
                            <path
                                d="m889.257415 3.26083412v430.20930488c0 3.050847-2.374456 6.003233-5.357631 6.661755l-323.309925 71.369136c-2.549497.562789-6.668731 1.361078-9.237394 1.790363-1.498813.250487-1.498813.250487-5.995253 1.001949-2.37467.396864-2.37467.396864-4.307789.719934-53.836639 8.997386-133.717731 30.355619-232.721586 61.157661-19.639618 6.110271-39.860831 12.540939-60.575256 19.254665-57.468633 18.626085-116.173444 38.583001-172.9650326 58.539944-19.8770706 6.984935-38.0950777 13.470907-54.2603966 19.291578-5.6576699 2.037165-10.65457089 3.845633-14.94150125 5.404611-1.50031053.5456-2.80467876 1.021031-3.90695453 1.423694-.66120388.241539-1.10801554.405112-1.33428483.48812l-1.36651642.501315 1.18151992-77.382861 551.20676131-371.694727c2.13195-1.437636 5.586362-3.805481 7.697436-5.2763l324.788001-226.28507721c2.77882-1.93604869 5.405802-.56424036 5.405802 2.82493533z"
                                fill="#efefef" stroke="#d2d6d9" stroke-width="2" />
                            <path d="m414.466211 481.494542 18.491024 58.290292 422.36633-93.08963v-83.328034z"
                                fill="#e3e3e3" stroke="#d2d6d9" stroke-width="2" />
                            <path
                                d="m801.657576 58.9199601 41.393223-28.7227622 25.314049 413.8524401-66.707272 15.630602z"
                                fill="#828790" opacity=".157708" />
                        </g>
                    </g>
                </svg>
            </div>

        @endif
        <table class="absolute right-0 mr-2 mt-10 h-min table-auto border-separate border-spacing-1 text-black">
            <thead>
                <tr>
                    <th>Passeggeri</th>
                    <th>{{ $originIata }} - {{ $destinationIata }}</th>
                    @if (session('travelType') == 'two-ways')
                        <th>{{ $destinationIata }} - {{ $originIata }}</th>
                    @endif
                </tr>
            </thead>
            <tbody class="">
                @foreach ($passengers as $passenger)
                    <tr>
                        <td wire:click="selectPassenger({{ $loop->index }})"
                            class="cursor-pointer text-center font-semibold">
                            {{ $passenger['initials'] }}
                        </td>
                        <td class="{{ $loop->index == $selectedPassenger && !$showBackSeats ? 'ring' : '' }}">
                            {{ isset($passenger['goSeat']) && $passenger['goSeat'] != null ? $passenger['goSeat'] : 'Non assegnato' }}
                        </td>
                        @if (session('travelType') == 'two-ways')
                            <td class="{{ $loop->index == $selectedPassenger && $showBackSeats ? 'ring' : '' }}">
                                {{ isset($passenger['backSeat']) && $passenger['backSeat'] != null ? $passenger['backSeat'] : 'Non assegnato' }}
                            </td>
                        @endif
                    <tr>
                @endforeach
                <tr>
                    <td class="text-center">
                        <button wire:click="goBack" class="button">Torna indietro</button>
                    </td>


                    @if (($goSeatsAssigned && !$showBackSeats) || ($goSeatsAssigned && $backSeatsAssigned))
                        <td wire:transition class="text-center">
                            <button wire:click="goToNextStep" class="button">Continua</button>
                        </td>
                    @endif

                </tr>

            </tbody>
        </table>
    </div>


</div>
