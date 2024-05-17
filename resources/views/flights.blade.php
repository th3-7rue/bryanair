@if (Route::has('login'))
    <x-guest-layout class="m-0">

        <div class="absolute z-10 w-full mb-4 bg-royal-blue rounded-b-2xl p-6 text-right sm:right-0 sm:top-0">
            @auth
                <a wire:navigate.hover href="{{ url('/dashboard') }}"
                    class="font-semibold text-white hover:text-gray-900 focus:rounded-sm focus:outline focus:outline-2 focus:outline-petrol-blue">Dashboard</a>
            @else
                <a wire:navigate.hover href="{{ route('login') }}"
                    class="font-semibold text-white hover:text-gray-900 focus:rounded-sm focus:outline focus:outline-2 focus:outline-petrol-blue">{{ __('Log in') }}</a>

                @if (Route::has('register'))
                    <a wire:navigate.hover href="{{ route('register') }}"
                        class="ml-4 font-semibold text-white hover:text-gray-900 focus:rounded-sm focus:outline focus:outline-2 focus:outline-petrol-blue">{{ __('Register') }}</a>
                @endif
            @endauth
        </div>
        <div class="bg-slate-100 min-h-svh   mt-8  ">
            <livewire:flights>
        </div>
    </x-guest-layout>
@endif
