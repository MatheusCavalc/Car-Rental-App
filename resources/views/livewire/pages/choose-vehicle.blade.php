<?php

use function Livewire\Volt\{layout, state, title, rules};
use App\Models\Location;
use App\Models\Car;
use Illuminate\Support\Carbon;

state([
    'pickup_location' => session('pickup_location'),
    'pickup_date' => session('pickup_date'),
    'pickup_time' => session('pickup_time'),
    'return_date' => session('return_date'),
    'return_time' => session('return_time'),

    //'location_id' => fn () => Location::where('name', session('pickup_location'))->first()
]);

layout('layouts.home');

title(fn() => 'Rental Vehicles in ' . $this->pickup_location);

$vehicles = function () {
    $location_id = Location::where('name', session('pickup_location'))->first();
    return Car::where('location_id', $location_id->id)->get();
};

$rental_days = function () {
    $pickupDate = Carbon::parse(session('pickup_date'));
    $returnDate = Carbon::parse(session('return_date'));

    return $returnDate->diffInDays($pickupDate);
};

$pickup_location_info = function ($location) {
    $location_info = Location::where('name', $location)->first();

    return $location_info->address;
};
?>

<div class="lg:py-16 py-14 px-4 lg:px-20 relative">
    {{-- Menu --}}
    <div class="mt-24 lg:mt-5">
        <p>Menu</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-4">
        <div class="lg:col-span-3 order-2 lg:order-1">
            <p class="text-lg lg:text-2xl font-bold">Choose Your Vehicle</p>

            <div class="mt-5 grid grid-cols-1 gap-8">
                @foreach ($this->vehicles() as $car)
                    <div class="w-full bg-white rounded-md border">
                        <div class="bg-gray-300 rounded-t-md p-2 lg:p-4">
                            <p class="text-base lg:text-xl">
                                {{ $car->brand }} {{ $car->model }} {{ $car->year }}
                            </p>
                        </div>

                        <div class="lg:flex justify-between px-6 py-8">
                            <div class="flex justify-center">
                                <img class="h-32 object-cover"
                                    src="https://w7.pngwing.com/pngs/723/547/png-transparent-chevrolet-onix-car-general-motors-vehicle-chevrolet.png" />
                            </div>

                            <div class="pt-3 pb-6 px-2 border rounded-md mt-5 lg:mt-0">
                                <p class="text-2xl font-bold text-center">
                                    <span class="text-lg font-normal">R$</span>
                                    {{ $car->daily_price }}
                                </p>

                                <div class="flex justify-center mt-5">
                                    <x-app.primary-button
                                        class="text-sm px-12 py-2">
                                        Pay Now
                                    </x-app.primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="fixed lg:relative z-20 top-16 mt-2 lg:mt-0 lg:top-0 left-0 lg:col-span-1 order-1 lg:order-2 w-full">
            <div x-data="{ open_reserve: false }" class="px-6 py-4 lg:px-0 lg:py-0 bg-white shadow-2xl lg:shadow-none">
                <div class="flex justify-between cursor-pointer lg:cursor-default"
                    @click="open_reserve = ! open_reserve">
                    <p class="text-lg lg:text-2xl font-bold">Your Reserve</p>

                    <p :class="{ '-rotate-180': open_reserve, '': !open_reserve }"
                        class="lg:hidden transition-transform">
                        <x-app.icons.arrow-down-icon class="w-6 h-6 mt-1" />
                    </p>
                </div>

                <div :class="{ 'md:block': open_reserve, 'hidden md:block': !open_reserve }"
                    class="mt-5 p-3 bg-gray-200 rounded-md">
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

                            <p class="text-gray-700 mb-1">{{ $this->pickup_location_info($this->pickup_location) }}</p>

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

                            <p class="text-gray-700 mb-1">{{ $this->pickup_location_info($this->pickup_location) }}
                            </p>

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
                </div>
            </div>
        </div>
    </div>
</div>
