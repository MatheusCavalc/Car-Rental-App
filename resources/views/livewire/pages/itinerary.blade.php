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
                        <x-app.icons.pin-icon class="w-5 h-5" />
                        <p class="font-bold">Pickup</p>
                    </div>

                    <div class="lg:flex gap-3">
                        <div class="lg:w-1/2 relative">
                            <x-app.input-label :value="__('Pickup Location')" />
                            <x-app.text-input type="text" wire:model='pickup_location' wire:keyup='searchLocations'
                                required placeholder="Where do you want to rent?" />
                            <x-app.input-error :messages="$errors->get('pickup_location')" class="mt-2" />


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
                            <x-app.input-label :value="__('Pickup Date and Time')" />

                            <div class="flex">
                                <div class="w-2/3">
                                    <x-app.text-input type="date" wire:model='pickup_date' required />
                                    <x-app.input-error :messages="$errors->get('pickup_date')" class="mt-2" />
                                </div>

                                <div class="w-1/3">
                                    <select id="first_name" wire:model='pickup_time'
                                        class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-r-lg block p-2.5"
                                        placeholder="John" required>
                                        <option value="00:00">00:00</option>
                                        <option value="00:30">00:30</option>
                                        <option value="01:00">01:00</option>
                                    </select>

                                    <x-app.input-error :messages="$errors->get('pickup_time')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-app.horizontal-line />

                <div>
                    <div class="flex gap-1">
                        <x-app.icons.pin-icon class="w-5 h-5" />
                        <p class="font-bold">Return</p>
                    </div>

                    <div class="lg:flex gap-3">
                        <div class="lg:w-1/2 relative">
                            <x-app.input-label :value="__('Return Location')" />
                            <x-app.text-input type="text" wire:model='pickup_location' wire:keyup='searchLocations'
                                required placeholder="Where do you want to rent?" />
                            <x-app.input-error :messages="$errors->get('pickup_location')" class="mt-2" />

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
                            <x-app.input-label :value="__('Return Date and Time')" />

                            <div class="flex">
                                <div class="w-2/3">
                                    <x-app.text-input type="date" wire:model='return_date' required />
                                    <x-app.input-error :messages="$errors->get('return_date')" class="mt-2" />
                                </div>

                                <div class="w-1/3">
                                    <select id="first_name" wire:model='return_time'
                                        class="bg-gray-50 w-full h-12 border border-gray-300 text-gray-900 rounded-r-lg block p-2.5"
                                        placeholder="John" required>
                                        <option value="00:00">00:00</option>
                                        <option value="00:30">00:30</option>
                                        <option value="01:00">01:00</option>
                                    </select>

                                    <x-app.input-error :messages="$errors->get('return_time')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-app.horizontal-line />

                <div>
                    <x-app.input-label :value="__('Promotional Code')" />

                    <div class="lg:w-1/2 mt-4 lg:mt-0">
                        <x-app.text-input type="text" wire:model='code' placeholder="Promotional Code" required />
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
                            <x-app.icons.pin-icon class="w-5 h-5" />
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
                                <x-app.icons.calendar-icon class="w-5 h-5" />
                                <p>{{ $this->pickup_date }}</p>
                            </div>

                            <div class="flex gap-1">
                                <x-app.icons.clock-icon class="w-5 h-5" />
                                <p>{{ $this->pickup_time }}H</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex justify-between">
                        <div class="flex gap-1 text-blue-600">
                            <x-app.icons.pin-icon class="w-5 h-5" />
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
                                <x-app.icons.calendar-icon class="w-5 h-5" />
                                <p>{{ $this->return_date }}</p>
                            </div>

                            <div class="flex gap-1">
                                <x-app.icons.clock-icon class="w-5 h-5" />
                                <p>{{ $this->return_time }}H</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-4">
                    <x-app.primary-button wire:click="continue"
                        class=" px-5 py-2">
                        Continue
                    </x-app.primary-button>
                </div>
            </div>
        </div>
    </div>

</div>
