<div class="mx-52 mt-20">
    <div class="dark:bg-gray-800 overflow-hidden bg-white shadow-xl sm:rounded-lg">
        <div class="dark:border-gray-700 border-b border-gray-200 p-6 sm:px-20">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div class="ml-4 text-lg font-semibold leading-7">

                        <div class="dark:text-gray-400 mt-2 text-sm text-gray-600">
                            Rivedi il tuo ordine
                        </div>

                        <div class="dark:text-gray-400 mt-2 text-sm text-gray-600">
                            {{ session('totalPrice') }}€
                        </div>
                        <div class="dark:text-gray-400 mt-2 text-sm text-gray-600">

                            @if (!$showPayment)
                                <button wire:click="confirm" class="button">
                                    Conferma e paga
                                </button>
                            @endif
                        </div>
                        <div class="dark:text-gray-400 mt-2 text-sm text-gray-600">
                            @if ($showPayment && !$paid)
                                <button wire:click="fakePay" class="button">
                                    Paga
                                </button>
                            @endif
                        </div>

                        <div class="dark:text-gray-400 mt-2 text-sm text-gray-600">
                            @if (!$paid)
                                <button wire:click="back" class="button">
                                    Torna indietro
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div>
        @if ($paid)
            <x-dialog-modal>
                <x-slot name="title">
                    Pagamento effettuato
                </x-slot>
                <x-slot name="content">
                    Il pagamento è stato effettuato con successo
                </x-slot>
                <x-slot name="footer">
                    <a href="dashboard" class="button">
                        Vai alle tue prenotazioni
                    </a>
                </x-slot>
            </x-dialog-modal>
        @endif
    </div>
</div>
