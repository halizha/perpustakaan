<?php

namespace App\Livewire;

use Livewire\Component;

class MemberDashboardComponent extends Component
{
    public function render()
    {
        $x['title'] ="Home";
        return view('livewire.member-dashboard-component')->layoutData($x);
    }
}
