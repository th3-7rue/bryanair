@if (Route::has('login'))
    <x-guest-layout class="m-0">
        <img src="landing.webp" alt="" class="fixed left-0 top-0 z-0 m-0 h-screen w-screen object-cover" />

        <div class="absolute z-10 p-6 text-right sm:top-0 tall:sm:right-0">
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
        <div class="absolute m-0 flex h-screen w-screen flex-row justify-center md:justify-start">
            <div style="background: rgb(255, 255, 255,0.5)"
                class="mb-auto mt-auto flex flex-col justify-start rounded-2xl p-3 text-gray-500 backdrop-blur-sm md:ml-auto md:mr-12 md:p-14">
                <livewire:landing>
            </div>
        </div>
    </x-guest-layout>
@endif
