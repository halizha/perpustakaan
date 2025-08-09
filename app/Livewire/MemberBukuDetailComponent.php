<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Buku;

class MemberBukuDetailComponent extends Component
{
    public $buku;

    public function mount($id)
    {
        $this->buku = Buku::with('kategori')->findOrFail($id);
    }

    public function render()
    {
        $x['title'] ="Detail Buku";
        return view('livewire.member-buku-detail-component')->layoutData($x);
    }
}
