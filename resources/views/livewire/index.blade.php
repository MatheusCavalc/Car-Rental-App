<?php

use function Livewire\Volt\{layout, state, title};

layout('layouts.home');

title('Home');

//

?>

<div class="pt-16">
    <!-- Form rental -->
    <div class="bg-blue-800 py-14 px-20">

        <div class="pb-5">
            <p class="text-lg text-white font-bold">
                Rent a car
            </p>
        </div>

        <div class="flex gap-3 w-full">
            <div class="w-5/12">
                <label for="first_name" class="block mb-2 text-white font-medium dark:text-white">Pickup Location</label>
                <input type="text" id="first_name"
                    class="bg-gray-50 border w-full h-12 border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Where do you want to rent?" required />
            </div>

            <div class="w-3/12">
                <label for="first_name" class="block mb-2 text-white font-medium dark:text-white">Pickup Date and
                    Time</label>

                <div class="flex">
                    <input type="date" id="first_name"
                        class="bg-gray-50 w-2/3 h-12 text-gray-900 rounded-l-lg block p-2.5" placeholder="John"
                        required />

                    <select id="first_name" class="bg-gray-50 w-1/3 h-12 text-gray-900 rounded-r-lg block p-2.5"
                        placeholder="John" required>
                        <script>
                            for (let horas = 0; horas < 24; horas++) {
                                for (let minutos = 0; minutos < 60; minutos += 30) {
                                    const horaFormatada = `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}`;
                                    document.write(`<option value="${horaFormatada}">${horaFormatada}</option>`);
                                }
                            }
                        </script>
                    </select>
                </div>
            </div>

            <div class="w-3/12">
                <label for="first_name" class="block mb-2 text-white font-medium dark:text-white">Data e Hora de
                    Devolução</label>

                <div class="flex">
                    <input type="date" id="first_name"
                        class="bg-gray-50 w-2/3 h-12 text-gray-900 rounded-l-lg block p-2.5" placeholder="John"
                        required />

                    <select id="first_name" class="bg-gray-50 w-1/3 h-12 text-gray-900 rounded-r-lg block p-2.5"
                        placeholder="John" required>
                        <script>
                            for (let horas = 0; horas < 24; horas++) {
                                for (let minutos = 0; minutos < 60; minutos += 30) {
                                    const horaFormatada = `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}`;
                                    document.write(`<option value="${horaFormatada}">${horaFormatada}</option>`);
                                }
                            }
                        </script>
                    </select>
                </div>
            </div>

            <div class="w-1/12 mt-10">
                <a href="/login" wire:navigate type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg w-full px-4 py-3 text-center">
                    Search
                </a>
            </div>
        </div>
    </div>

    <!-- Why rental on this site -->
    <div>

    </div>

    <!-- Promos -->
    <div>

    </div>
</div>
