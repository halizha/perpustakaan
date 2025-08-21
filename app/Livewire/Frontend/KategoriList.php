<?php

namespace App\Livewire\Frontend;

use App\Models\Kategori;
use Livewire\Component;

class KategoriList extends Component
{
    public function render()
    {
        $kategori = Kategori::orderBy('nama')->get();

        return view('livewire.frontend.kategori-list', compact('kategori'));
    }
}

