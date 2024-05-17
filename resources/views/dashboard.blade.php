<x-app-layout>
    <x-slot name="header">
        <h2 class="dark:text-gray-200 text-xl font-semibold leading-tight text-gray-800">
            {{ __('Le mie prenotazioni') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:dashboard>
            </div>
        </div>
    </div>
</x-app-layout>
