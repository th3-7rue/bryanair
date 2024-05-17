@if (Route::has('login'))
    <x-guest-layout class="m-0">


        <div class="absolute right-0 top-0 z-10 mb-4 w-full rounded-b-2xl bg-royal-blue p-6 text-right">
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
        <div class="mt-8 bg-slate-100">
            <livewire:seats>
        </div>
    </x-guest-layout>
@endif
