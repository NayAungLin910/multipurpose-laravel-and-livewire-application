<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Analytics extends Component
{
    public $days = [];

    public $subscribers = [30, 40, 35, 50, 49, 60, 70, 91, 125];

    public $recentSubscribers = 556;

    public function mount()
    {
        $this->days = collect(range(13, 24))->map(function ($num) {
            return 'June ' . $num;
        });
    }

    public function fetchData()
    {
        $subscribers = array_replace($this->subscribers, [10 => $this->recentSubscribers += 10]);

        $this->emit('refreshChart', ['seriesData' => $subscribers]);
    }

    public function render()
    {
        return view('livewire.analytics')->layout('layouts.realtime');
    }
}
