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
                                    <button
                                        class="text-center text-sm text-white w-full px-12 py-2 rounded-md bg-blue-600">
                                        Pay Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

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
                                    <button
                                        class="text-center text-sm text-white w-full px-12 py-2 rounded-md bg-blue-600">
                                        Pay Now
                                    </button>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 mt-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
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

                            <p class="text-gray-700 mb-1">{{ $this->pickup_location_info($this->pickup_location) }}</p>

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

                            <p class="text-gray-700 mb-1">{{ $this->pickup_location_info($this->pickup_location) }}
                            </p>

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
                </div>
            </div>
        </div>
    </div>
</div>
