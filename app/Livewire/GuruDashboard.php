<?php

namespace App\Livewire;

use Livewire\Component;

class GuruDashboard extends Component
{
    public function render()
    {
        $x['title'] ="Home";
        return view('livewire.guru-dashboard')->layoutData($x);
    }
}
