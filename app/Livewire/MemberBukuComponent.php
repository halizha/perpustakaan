<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class MemberBukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $cari;
    public $kategoriId;

    // Ambil id kategori dari parameter route
    public function mount($id)
    {
        $this->kategoriId = $id;
    }

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Buku::query()
            ->where('kategori_id', $this->kategoriId);

        if ($this->cari) {
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . $this->cari . '%')
                  ->orWhereHas('kategori', function ($query) {
                      $query->where('nama', 'like', '%' . $this->cari . '%');
                  });
            });
        }

        $buku = $query->paginate(10);

        $kategori = Kategori::find($this->kategoriId);

        $x['title'] = "Daftar Buku - " . ($kategori ? $kategori->nama : 'Kategori');

        return view('livewire.member-buku-component', compact('buku'))
            ->layoutData($x);
    }
}
