<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Rak;
use App\Models\Slot;

class SlotComponent extends Component
{
    use WithPagination;

    public $rak_id;
    public $rak;
    public $cari;

    public $id_slot, $kode_slot, $nama_slot;

    protected $paginationTheme = 'bootstrap';

    public function mount($id)
    {
        $this->rak_id = $id;
        $this->rak = Rak::findOrFail($id);
    }

    public function render()
    {
        $query = Slot::where('rak_id', $this->rak_id);

        if ($this->cari) {
            $query->where(function ($q) {
                $q->where('kode_slot', 'like', '%' . $this->cari . '%')
                    ->orWhere('nama_slot', 'like', '%' . $this->cari . '%');
            });
        }

        $slots = $query->paginate(10);

        return view('livewire.slot-component', [
            'slots' => $slots,
            'rak' => $this->rak
        ]);
    }

    public function store()
    {
        $this->validate([
            'kode_slot' => 'required',
            'nama_slot' => 'required',
        ]);

        Slot::create([
            'rak_id' => $this->rak_id,
            'kode_slot' => $this->kode_slot,
            'nama_slot' => $this->nama_slot
        ]);


        $this->reset(['kode_slot', 'nama_slot']);
        session()->flash('success', 'Berhasil tambah slot!');
       return redirect()->route('rak.detail', $this->rak_id);
    }

    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $this->id_slot = $slot->id_slot;
        $this->kode_slot = $slot->kode_slot;
        $this->nama_slot = $slot->nama_slot;
    }

    public function update()
    {
        $this->validate([
            'kode_slot' => 'required',
            'nama_slot' => 'required',
        ]);

        $slot = Slot::findOrFail($this->id_slot);
        $slot->update([
            'kode_slot' => $this->kode_slot,
            'nama_slot' => $this->nama_slot
        ]);

        $this->reset(['kode_slot', 'nama_slot', 'id_slot']);
        session()->flash('success', 'Berhasil ubah slot!');
    }

    public function confirm($id)
    {
        $this->id_slot = $id;
    }

    public function destroy()
    {
        $slot = Slot::findOrFail($this->id_slot);
        $slot->delete();

        $this->reset(['id_slot']);
        session()->flash('success', 'Berhasil hapus slot!');
    }
}
