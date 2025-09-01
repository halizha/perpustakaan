<?php

namespace App\Livewire;

use App\Models\DetailPinjam;
use Livewire\Component;
use App\Models\Pinjam;

class DetailPinjamComponent extends Component
{
    public $pinjamId;
    public $pinjam;
    public $editId, $editTglKembali;
    public $deleteId;

    public function mount($id)
    {
        $this->pinjamId = $id;
        $this->pinjam = Pinjam::with([
            'user',
            'detail.buku',
            'detail.eksemplar'
        ])->findOrFail($id);
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
        $this->editTglKembali = $detail->tgl_kembali
            ? \Carbon\Carbon::parse($detail->tgl_kembali)->format('Y-m-d')
            : null;
    }

    public function update()
{
    $this->validate([
        'editTglKembali' => 'required|date',
    ]);

    $detail = DetailPinjam::findOrFail($this->editId);
    $detail->tgl_kembali = $this->editTglKembali;
    $detail->save();

    return redirect()
        ->route('pinjam.detail', $this->pinjamId) // ganti sesuai route
        ->with('success', 'Tanggal kembali berhasil diperbarui.');
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
