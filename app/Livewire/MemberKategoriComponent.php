<?php

namespace App\Livewire;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class MemberKategoriComponent extends Component
{
    use WithPagination;

    public $viewMode = 'table'; // default tampilan

    public function render()
    {
        $x['title'] = "Daftar Kategori Buku";
        $kategori = Kategori::with('buku')->paginate(8);

        return view('livewire.member-kategori-component', compact('kategori'))
            ->layoutData($x);
    }
}
