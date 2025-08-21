<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Buku;

class BukuDetail extends Component
{
    public $idBuku;

    public function mount($id)
    {
        $this->idBuku = $id;
    }

    public function render()
    {
        $buku = Buku::findOrFail($this->idBuku);

        return view('livewire.frontend.buku-detail', [
            'buku' => $buku,
        ])->layout('frontend.layouts.main');
    }
}
