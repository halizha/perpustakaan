<?php

namespace App\Livewire;

use App\Models\DetailPinjam;
use Livewire\Component;
use App\Models\Pinjam;

class DetailPinjamComponent extends Component
{
    public $pinjamId;
    public $pinjam;
    public $editId, $editKeterangan;
    public $deleteId;

    public function mount($id)
    {
        $this->pinjamId = $id;
        $this->pinjam = Pinjam::with(['user', 'detail.buku'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.detail-pinjam-component', [
            'pinjam' => $this->pinjam
        ]);
    }

    public function edit($id)
    {
        $detail = DetailPinjam::findOrFail($id);
        $this->editId = $detail->id;
        $this->editKeterangan = $detail->keterangan;
    }

    public function update()
    {
        $this->validate([
            'editKeterangan' => 'required|string'
        ]);

        $detail = DetailPinjam::findOrFail($this->editId);
        $detail->keterangan = $this->editKeterangan;
        $detail->save();

        session()->flash('success', 'Data berhasil diperbarui.');
        $this->reset(['editId', 'editKeterangan']);
        $this->mount($this->pinjamId); // refresh data
        $this->dispatch('close-modal', 'editPage');
    }

    public function confirm($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        DetailPinjam::findOrFail($this->deleteId)->delete();
        session()->flash('success', 'Data berhasil dihapus.');
        $this->deleteId = null;
        $this->mount($this->pinjamId); // refresh data
        $this->dispatch('close-modal', 'deletePage');
    }
}
