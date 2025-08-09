<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $kategori, $judul, $penulis, $penerbit, $isbn, $tahun, $jumlah, $cari, $id, $sampul, $sinopsis, $kode_rak, $status;
    public function render()
    {
        if ($this->cari != "") {
            $data['buku'] = Buku::where('judul', 'like', '%' . $this->cari . '%')->paginate(10);
        } else {
            $data['buku'] = Buku::paginate(10);
        }
        $data['categori'] = Kategori::all();
        $layout['title'] = 'Kelola  Buku';
        return view('livewire.buku-component', $data)->layoutData($layout);
    }
    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'isbn' => 'required',
            'jumlah' => 'required',
            'sampul' => 'required|image|max:2048', // max 2MB
            'kode_rak' => 'required',
            'status' => 'required',
            'sinopsis' => 'required',
        ], [
            'judul.required' => 'Judul Lengkap Tidak Boleh Kosong!',
            'kategori.required' => 'Kategori Tidak Boleh Kosong!',
            'penulis.required' => 'Penulis Tidak Boleh Kosong!',
            'penerbit.required' => 'Penerbit Tidak Boleh Kosong!',
            'tahun.required' => 'Tahun Tidak Boleh Kosong!',
            'isbn.required' => 'ISBN Tidak Boleh Kosong!',
            'jumlah.required' => 'Jumlah Tidak Boleh Kosong!',
            'sampul.max' => 'Ukuran gambar maksimal 2MB!',
            'kode_rak' => 'Kode Rak Tidak Boleh Kosong',
            'status' => 'Status Tidak Boleh Kosong',
            'sinopsis' => 'Sinopsis Tidak Boleh Kosong'
        ]);
        $sampulPath = null;
        if ($this->sampul) {
            $sampulPath = $this->sampul->store('sampul', 'public');
        }
        Buku::create([
            'judul' => $this->judul,
            'kategori_id' => $this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah,
            'kode_rak' => $this->kode_rak,
            'status' => $this->status,
            'sinopsis' => $this->sinopsis,
            'sampul' => $sampulPath,
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil Simpan!');
        return redirect()->route('buku');
    }
    public function edit($id)
    {
        $buku = Buku::find($id);
        $this->id = $buku->id;
        $this->judul = $buku->judul;
        $this->kategori = $buku->kategori->id;
        $this->penulis = $buku->penulis;
        $this->penerbit = $buku->penerbit;
        $this->tahun = $buku->tahun;
        $this->isbn = $buku->isbn;
        $this->jumlah = $buku->jumlah;
        $this->sampul = $buku->sampul;
        $this->kode_rak = $buku->kode_rak;
        $this->sinopsis = $buku->sinopsis;
        $this->status = $buku->status;
    }
    public function update()
    {
        $buku = Buku::find($this->id);
        $buku->update([
            'judul' => $this->judul,
            'kategori_id' => $this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah,
            'kode_rak' => $this->kode_rak,
            'status' => $this->status,
            'sinopsis' => $this->sinopsis,
            
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil Ubah!');
        return redirect()->route('buku');
    }
    public function confirm($id)
    {
        $this->id = $id;
    }
    public function destroy()
    {
        $buku = Buku::find($this->id);
        $buku->delete();
        $this->reset();
        session()->flash('success', 'Berhasil Hapus!');
        return redirect()->route('buku');
    }
}
