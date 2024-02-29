<?php

use function Livewire\Volt\{layout, state, title, rules};
use function Livewire\Volt\{computed};
use App\Models\Location;
use Illuminate\Support\Carbon;

layout('layouts.home');

title('Itinerary');

state([
    'locations' => [],
    'pickup_location' => session('pickup_location'),
    'pickup_date' => session('pickup_date'),
    'pickup_time' => session('pickup_time'),
    'return_date' => session('return_date'),
    'return_time' => session('return_time'),
    'code' => '',
]);

rules([
    'pickup_location' => ['required', 'string', 'max:255', 'exists:locations,name'],
    'pickup_date' => ['required', 'string', 'max:255'],
    'pickup_time' => ['required', 'string', 'max:255'],
    'return_date' => ['required', 'string', 'max:255'],
    'return_time' => ['required', 'string', 'max:255'],
    'code' => ['string', 'max:255'],
])->messages([
    'pickup_location.exists' => 'Choose a location below.',
]);

$rental_days = function () {
    $pickupDate = Carbon::parse(session('pickup_date'));
    $returnDate = Carbon::parse(session('return_date'));

    return $returnDate->diffInDays($pickupDate);
};

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

$continue = function () {
    $validated = $this->validate();

    session([
        'pickup_location' => $this->pickup_location,
        'pickup_date' => $this->pickup_date,
        'pickup_time' => $this->pickup_time,
        'return_date' => $this->return_date,
        'return_time' => $this->return_time,
    ]);

    $this->redirect('/reserve/choose-vehicle', navigate: true);
};

?>

<div class="lg:py-16 py-14 px-4 lg:px-20">
    {{-- Menu --}}
    <div class="pt-5">
        <p>Menus</p>
    </div>

    {{-- Itinerary Form and Your Reserve --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-4">
        <div class="lg:col-span-3">
            <p class="text-2xl font-bold">Your Itinerary</p>

            <div class="mt-5 w-full p-5 bg-gray-200 rounded-md">
                <div>
                    <div class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>

                        <p class="font-bold">Pickup</p>
                    </div>

                    <div class="lg:flex gap-3">
                        <div class="lg:w-1/2 relative">
                            <label for="first_name" class="block mb-2 text-black dark:text-white">Pickup
                                Location</label>
                            <input type="text" wire:model='pickup_location' wire:keyup='searchLocations'
                                class="bg-gray-50 border w-full h-12 border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Where do you want to rent?" required />
                            <div>
                                @error('pickup_location')
                                    {{ $message }}
                                @enderror
                            </div>

                            @if (sizeof($this->locations) > 0 && strlen($this->pickup_location) >= 1)
                                <div x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute z-20 mt-2 font-normal bg-white rounded-lg shadow w-full py-2">

                                    @foreach ($this->locations as $location)
                                        <div class="p-2 text-lg hover:bg-gray-100 cursor-pointer rounded-md"
                                            wire:click='chooseLocation({{ $location }})'>
                                            {{ $location->name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="lg:w-1/2 mt-4 lg:mt-0">
                            <label for="first_name" class="block mb-2 text-black dark:text-white">Pickup
                                Date
                                and
                                Time</label>

                            <div class="flex">
                                <div class="w-2/3">
                                    <input type="date" id="first_name" wire:model='pickup_date'
                                        class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-l-lg block p-2.5"
                                        placeholder="John" required />

                                    <div>
                                        @error('pickup_date')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-1/3">
                                    <select id="first_name" wire:model='pickup_time'
                                        class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-r-lg block p-2.5"
                                        placeholder="John" required>
                                        <option value="00:00">00:00</option>
                                        <option value="00:30">00:30</option>
                                        <option value="01:00">01:00</option>
                                    </select>

                                    <div>
                                        @error('pickup_time')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-5">
                    <div class="h-0.5 w-full rounded-full bg-blue-600"></div>
                </div>

                <div>
                    <div class="flex gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>

                        <p class="font-bold">Return</p>
                    </div>

                    <div class="lg:flex gap-3">
                        <div class="lg:w-1/2 relative">
                            <label for="first_name" class="block mb-2 text-black dark:text-white">Return
                                Location</label>
                            <input type="text" wire:model='pickup_location' wire:keyup='searchLocations'
                                class="bg-gray-50 border w-full h-12 border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Where do you want to rent?" required />
                            <div>
                                @error('pickup_location')
                                    {{ $message }}
                                @enderror
                            </div>

                            @if (sizeof($this->locations) > 0 && strlen($this->pickup_location) >= 1)
                                <div x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute z-20 mt-2 font-normal bg-white rounded-lg shadow w-full py-2">

                                    @foreach ($this->locations as $location)
                                        <div class="p-2 text-lg hover:bg-gray-100 cursor-pointer rounded-md"
                                            wire:click='chooseLocation({{ $location }})'>
                                            {{ $location->name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="lg:w-1/2 mt-4 lg:mt-0">
                            <label for="first_name" class="block mb-2 text-black dark:text-white">Return
                                Date
                                and
                                Time</label>

                            <div class="flex">
                                <div class="w-2/3">
                                    <input type="date" id="first_name" wire:model='return_date'
                                        class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-l-lg block p-2.5"
                                        placeholder="John" required />

                                    <div>
                                        @error('return_date')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="w-1/3">
                                    <select id="first_name" wire:model='return_time'
                                        class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-r-lg block p-2.5"
                                        placeholder="John" required>
                                        <option value="00:00">00:00</option>
                                        <option value="00:30">00:30</option>
                                        <option value="01:00">01:00</option>
                                    </select>

                                    <div>
                                        @error('return_time')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-5">
                    <div class="h-0.5 w-full rounded-full bg-blue-600"></div>
                </div>

                <div>
                    <p class="mb-2">Promotional Code</p>

                    <div class="lg:flex gap-3">
                        <div class="lg:w-1/2 mt-4 lg:mt-0">
                            <div class="flex">
                                <input type="text" id="first_name" wire:model='code'
                                    class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-lg block p-2.5"
                                    placeholder="John" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <p class="text-2xl font-bold">Your Reserve</p>

            <div class="mt-5 p-3 bg-gray-200 rounded-md">
                <div class="flex justify-between">
                    <p class="font-bold">Rental Days</p>
                    <p>{{ $this->rental_days() }} days</p>
                </div>

                <p class="mt-4">Itinerary</p>

                <div class="mt-2">
                    <div class="flex justify-between">
                        <div class="flex gap-1 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>

                            <p class="text-black font-bold">
                                Pickup
                            </p>
                        </div>

                        <p>Edit</p>
                    </div>

                    <div class="lg:ml-6">
                        <p class="font-bold mb-1">{{ $this->pickup_location }}</p>

                        <div class="flex gap-2">
                            <div class="flex gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>

                                <p>{{ $this->pickup_date }}</p>
                            </div>

                            <div class="flex gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <p>{{ $this->pickup_time }}H</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex justify-between">
                        <div class="flex gap-1 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>

                            <p class="text-black font-bold">
                                Return
                            </p>
                        </div>

                        <p>Edit</p>
                    </div>

                    <div class="lg:ml-6">
                        <p class="font-bold mb-1">{{ $this->pickup_location }}</p>

                        <div class="flex gap-2">
                            <div class="flex gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>

                                <p>{{ $this->return_date }}</p>
                            </div>

                            <div class="flex gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <p>{{ $this->return_time }}H</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4">
                    <button wire:click="continue"
                        class="bg-blue-600 px-5 text-center text-white py-2 rounded-lg w-full">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
