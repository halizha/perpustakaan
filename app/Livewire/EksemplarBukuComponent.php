<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Buku;
use App\Models\EksemplarBuku;

class EksemplarBukuComponent extends Component
{
    public $bukuId;
    public $buku;
    public $deleteId; // simpan id eksemplar yang mau dihapus

    public function mount($bukuId)
    {
        $this->bukuId = $bukuId;
        $this->buku = Buku::with('eksemplars')->findOrFail($bukuId);
    }

    public function render()
    {
        $layout['title'] = 'Eksemplar Buku';

        $this->buku->load('eksemplars');
        return view('livewire.eksemplar-buku-component', [
            'buku' => $this->buku
        ])->layoutData($layout);
    }

    public function updateStatus($eksemplarId, $status)
    {
        $eksemplar = EksemplarBuku::findOrFail($eksemplarId);
        $eksemplar->update(['status' => $status]);
        session()->flash('success', 'Status eksemplar berhasil diperbarui!');
    }

    public function confirmDelete($eksemplarId)
    {
        $this->deleteId = $eksemplarId;
    }

    public function deleteEksemplar()
    {
        $eksemplar = EksemplarBuku::findOrFail($this->deleteId);
        $buku = $eksemplar->buku;

        $eksemplar->delete();

        // update jumlah buku
        $buku->jumlah = $buku->eksemplars()->count();
        $buku->save();

        $this->deleteId = null;
        session()->flash('success', 'Eksemplar berhasil dihapus!');
        
    }
}
