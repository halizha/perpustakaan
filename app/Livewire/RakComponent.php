<?php

namespace App\Livewire;

use App\Models\Rak;
use Livewire\Component;
use Livewire\WithPagination;

class RakComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $kode_rak, $nama_rak, $id_rak, $cari;

    public function render()
    {
        if ($this->cari != "") {
            $data['rak'] = Rak::where('nama_rak', 'like', '%' . $this->cari . '%')->paginate(10);
        } else {
            $data['rak'] = Rak::paginate(10);
        }
        $layout['title'] = 'Kelola Rak';
        return view('livewire.rak-component', $data)->layoutData($layout);
    }

    public function store()
    {
        $this->validate([
            'kode_rak' => 'required',
            'nama_rak' => 'required'
        ]);

        Rak::create([
            'kode_rak' => $this->kode_rak,
            'nama_rak' => $this->nama_rak
        ]);

        $this->reset();
        session()->flash('success', 'Berhasil simpan!');
        return redirect()->route('rak');
    }

    public function edit($id)
    {
        $rak = Rak::find($id);
        $this->id_rak = $rak->id_rak;
        $this->kode_rak = $rak->kode_rak;
        $this->nama_rak = $rak->nama_rak;
    }

    public function update()
    {
        $rak = Rak::find($this->id_rak);
        $rak->update([
            'kode_rak' => $this->kode_rak,
            'nama_rak' => $this->nama_rak
        ]);

        $this->reset();
        session()->flash('success', 'Berhasil ubah!');
        return redirect()->route('rak');
    }

    public function confirm($id)
    {
        $this->id_rak = $id;
    }

    public function destroy()
    {
        $rak = Rak::find($this->id_rak);
        $rak->delete();
        $this->reset();
        session()->flash('success', 'Berhasil hapus!');
        return redirect()->route('rak');
    }
}
