<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use App\Models\Slot;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // form fields
    public $kategori, $judul, $penulis, $penerbit, $isbn, $tahun, $jumlah, $cari;
    public $id, $sampul, $sinopsis, $slot_id, $status;

    public function render()
    {
        // daftar buku (search)
        if ($this->cari != "") {
            $data['buku'] = Buku::where('judul', 'like', '%' . $this->cari . '%')->paginate(10);
        } else {
            $data['buku'] = Buku::paginate(10);
        }

        // dropdown data: semua rak beserta slotnya (urut)
        $data['raks'] = Rak::with(['slots' => function ($q) {
            $q->orderBy('kode_slot');
        }])->orderBy('kode_rak')->get();

        // kategori (untuk select kategori)
        $data['categori'] = Kategori::all();

        $layout['title'] = 'Kelola Buku';
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
            'sampul' => 'required|image|max:2048',
            'slot_id' => 'required|exists:slot,id_slot',
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
            'slot_id.required' => 'Slot tidak boleh kosong',
            'slot_id.exists' => 'Slot tidak valid',
            'status.required' => 'Status Tidak Boleh Kosong',
            'sinopsis.required' => 'Sinopsis Tidak Boleh Kosong'
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
            'slot_id' => $this->slot_id,
            'status' => $this->status,
            'sinopsis' => $this->sinopsis,
            'sampul' => $sampulPath,
        ]);

        $this->reset(['kategori', 'judul', 'penulis', 'penerbit', 'isbn', 'tahun', 'jumlah', 'sampul', 'slot_id', 'status', 'sinopsis', 'id']);
        session()->flash('success', 'Berhasil Simpan!');
        return redirect()->route('buku');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $this->id = $buku->id;
        $this->judul = $buku->judul;
        $this->kategori = $buku->kategori_id;
        $this->penulis = $buku->penulis;
        $this->penerbit = $buku->penerbit;
        $this->tahun = $buku->tahun;
        $this->isbn = $buku->isbn;
        $this->jumlah = $buku->jumlah;
        // note: sampul in DB is string path; Livewire file input can't be prefilled.
        $this->sampul = $buku->sampul;
        $this->slot_id = $buku->slot_id; // penting
        $this->sinopsis = $buku->sinopsis;
        $this->status = $buku->status;
    }

    public function update()
    {
        $rules = [
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'isbn' => 'required',
            'jumlah' => 'required',
            'slot_id' => 'required|exists:slot,id_slot',
            'status' => 'required',
            'sinopsis' => 'required',
        ];

        // validasi sampul hanya kalau ada file baru
        if ($this->sampul && is_object($this->sampul)) {
            $rules['sampul'] = 'image|max:2048';
        }

        $this->validate($rules, [
            'slot_id.required' => 'Slot tidak boleh kosong',
            'slot_id.exists' => 'Slot tidak valid',
        ]);

        $buku = Buku::findOrFail($this->id);

        $updateData = [
            'judul' => $this->judul,
            'kategori_id' => $this->kategori,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah,
            'slot_id' => $this->slot_id,
            'status' => $this->status,
            'sinopsis' => $this->sinopsis,
        ];

        // kalau ada upload baru → simpan
        if ($this->sampul && is_object($this->sampul) && method_exists($this->sampul, 'store')) {
            $path = $this->sampul->store('sampul', 'public');
            $updateData['sampul'] = $path;
        }

        $buku->update($updateData);

        $this->reset(['kategori', 'judul', 'penulis', 'penerbit', 'isbn', 'tahun', 'jumlah', 'sampul', 'slot_id', 'status', 'sinopsis', 'id']);
        session()->flash('success', 'Berhasil Ubah!');
        return redirect()->route('buku');
    }


    public function confirm($id)
    {
        $this->id = $id;
    }

    public function destroy()
    {
        $buku = Buku::findOrFail($this->id);
        $buku->delete();
        $this->reset();
        session()->flash('success', 'Berhasil Hapus!');
        return redirect()->route('buku');
    }
}
