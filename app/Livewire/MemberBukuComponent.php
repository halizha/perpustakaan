<?php

namespace App\Livewire;

use App\Models\Buku;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class MemberBukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $cari;

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function render()
    {
        $x['title'] ="Daftar Buku";
        $buku = Buku::where('judul', 'like', '%' . $this->cari . '%')
            ->orWhereHas('kategori', function ($query) {
                $query->where('nama', 'like', '%' . $this->cari . '%');
            })
            ->paginate(10);

        return view('livewire.member-buku-component', [
            'buku' => $buku,
        ])->layoutData($x);
    }
}
