<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Buku;
use App\Models\Kategori;

class BukuByKategori extends Component
{
    use WithPagination;

    public $idKategori;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    // Reset pagination jika search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id)
    {
        $this->idKategori = $id;
    }

    public function searchBooks()
    {
        $this->resetPage(); // Reset pagination jika diperlukan
    }

    public function render()
    {
        $kategori = Kategori::findOrFail($this->idKategori);

        $search = strtolower($this->search);

        $buku = Buku::where('kategori_id', $this->idKategori)
            ->when($this->search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereRaw('LOWER(judul) like ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(penulis) like ?', ["%{$search}%"])
                      ->orWhereRaw('LOWER(penerbit) like ?', ["%{$search}%"]);
                });
            })
            ->paginate(8);

        return view('livewire.frontend.buku-by-kategori', [
            'kategori' => $kategori,
            'buku' => $buku,
        ])->layout('frontend.layouts.main');
    }
}
