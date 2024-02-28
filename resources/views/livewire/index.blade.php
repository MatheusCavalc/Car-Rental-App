<?php

use function Livewire\Volt\{layout, state, title, rules};
use App\Models\Location;

layout('layouts.home');

title('Home');

state([
    'locations' => [],
    'pickup_location' => '',
    'pickup_date' => '',
    'pickup_time' => '',
    'return_date' => '',
    'return_time' => '',
]);

$searchLocations = function () {
    if (strlen($this->pickup_location) >= 1) {
        $this->locations = Location::where('name', 'LIKE', "%{$this->pickup_location}%")
            ->limit(5)
            ->get();
    }
};

$chooseLocation = function ($location) {
    $this->pickup_location = $location['name'];
    $this->locations = [];
};

$search = function () {
    session([
        'pickup_location' => $this->pickup_location,
        'pickup_date' => $this->pickup_date,
        'pickup_time' => $this->pickup_time,
        'return_date' => $this->return_date,
        'return_time' => $this->return_time,
    ]);

    $this->redirect('/reserve/itinerary', navigate: true);
};

?>

<div class="lg:py-16 py-14">
    <!-- Form rental -->
    <div class="bg-blue-800 py-10 lg:py-14 px-4 lg:px-20">

        <div class="pb-5">
            <p class="text-lg lg:text-xl text-white font-bold">
                Rent a car
            </p>
        </div>

        <div class="lg:flex lg:gap-3 w-full">
            <div class="lg:w-5/12 relative">
                <label for="first_name" class="block mb-2 text-white font-medium dark:text-white">Pickup Location</label>
                <input type="text" wire:model='pickup_location' wire:keyup='searchLocations'
                    class="bg-gray-50 border w-full h-12 border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Where do you want to rent?" required />

                @if (sizeof($this->locations) > 0 && strlen($this->pickup_location) >= 1)
                    <div x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-20 mt-2 font-normal bg-white rounded-lg shadow w-full py-2">

                        @foreach ($this->locations as $location)
                            <div class="p-2 text-lg" wire:click='chooseLocation({{ $location }})'>
                                {{ $location->name }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="lg:w-3/12 mt-4 lg:mt-0">
                <label for="first_name" class="block mb-2 text-white font-medium dark:text-white">Pickup Date and
                    Time</label>

                <div class="flex">
                    <input type="date" id="first_name" wire:model='pickup_date'
                        class="bg-gray-50 w-2/3 h-12 text-gray-900 rounded-l-lg block p-2.5" placeholder="John"
                        required />

                    <select id="first_name" wire:model='pickup_time'
                        class="bg-gray-50 w-1/3 h-12 text-gray-900 rounded-r-lg block p-2.5" placeholder="John"
                        required>
                        <option value="00:00">00:00</option>
                        <option value="00:30">00:30</option>
                        <option value="01:00">01:00</option>
                    </select>
                </div>
            </div>

            <div class="lg:w-3/12 mt-4 lg:mt-0">
                <label for="first_name" class="block mb-2 text-white font-medium dark:text-white">Return Date
                    and Time</label>

                <div class="flex">
                    <input type="date" id="first_name" wire:model='return_date'
                        class="bg-gray-50 w-2/3 h-12 text-gray-900 rounded-l-lg block p-2.5" placeholder="John"
                        required />

                    <select id="first_name" wire:model='return_time'
                        class="bg-gray-50 w-1/3 h-12 text-gray-900 rounded-r-lg block p-2.5" placeholder="John"
                        required>
                        <option value="00:00">00:00</option>
                        <option value="00:30">00:30</option>
                        <option value="01:00">01:00</option>
                    </select>
                </div>
            </div>

            <div class="lg:w-1/12 mt-10">
                <a wire:click='search' type="button"
                    class="text-white text-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg w-full px-4 py-3 text-center">
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
