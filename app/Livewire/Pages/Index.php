<?php

namespace App\Livewire\Pages;

use App\Models\Location;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{
    public $locations = [];

    public $pickup_location = '';

    public $pickup_date = '';

    public $pickup_time = '';

    public $return_date = '';

    public $return_time = '';

    public function test()
    {
        if (strlen($this->pickup_location) >= 1) {
            $this->locations = Location::where('name', 'LIKE', "%{$this->pickup_location}%")
                ->limit(5)
                ->get();
        }
    }

    public function chooseLocation ($location)
    {
        $this->pickup_location = $location['name'];
        $this->locations = [];
    }

    public function search()
    {
        $validated = $this->validate();

        //dd($this->pickup_location, $this->pickup_date, $this->pickup_time, $this->return_date, $this->return_time);
        //dd($validated);

        //$this->redirect('/reserve/itinerary', navigate: true, ['data' => $validated]);
    }

    #[Layout('layouts.home')]
    #[Title('Home')]
    public function render()
    {
        sleep(10);

        return view('livewire.pages.index');
    }
}
