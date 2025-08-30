<?php

namespace App\Livewire;

use App\Models\DetailPinjam;
use App\Models\Pengembalian;
use App\Models\Pinjam;
use DateTime;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class PengembalianComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';

    // Variabel-variabel public
    public $id, $judul, $member, $tgl_kembali, $lama, $status, $denda;
    public $detail_pinjam_id, $pinjam_id;
    public $cariPinjam = '';
    public $cariPengembalian = '';

    public function render()
    {
        $layout['title'] = 'Pengembalian Buku';
        $data['pinjam'] = DetailPinjam::whereNotIn('id', function ($query) {
            $query->select('detail_pinjam_id')->from('pengembalians');
        })
            ->whereHas('pinjam.user') // hanya yang user-nya masih ada
            ->with(['buku', 'pinjam.user'])
            ->paginate(10);
        $data['pengembalian'] = Pengembalian::with(['pinjam.user', 'detail.buku'])
            ->whereHas('pinjam.user', function ($q) {
                $q->where('nama', 'like', '%' . $this->cariPengembalian . '%');
            })
            ->paginate(10);
        return view('livewire.pengembalian-component', $data)->layoutData($layout);
    }

    // Ketika tombol "Pilih" ditekan
    public function pilih($detailId)
    {
        $detail = DetailPinjam::with('buku', 'pinjam.user')->find($detailId);
        $this->detail_pinjam_id = $detail->id;

        $this->judul = $detail->buku->judul ?? 'Tidak ditemukan';
        $this->member = $detail->pinjam->user->nama ?? 'Tidak ditemukan';
        $this->tgl_kembali = $detail->pinjam->tgl_kembali;
        $this->id = $detail->pinjam->id; // ini adalah id dari tabel pinjam (digunakan untuk pengembalian)

        $jatuhTempo = new DateTime($this->tgl_kembali);
        $hariIni = new DateTime();
        $selisih = $hariIni->diff($jatuhTempo);

        $this->status = $hariIni > $jatuhTempo;
        $this->lama = $this->status ? $selisih->days : 0;
    }

    // Fungsi simpan pengembalian
    public function store()
    {
        $this->validate([
            'detail_pinjam_id' => 'required',
            'tgl_kembali' => 'required|date',
            'denda' => 'nullable|numeric',
        ]);

        $detail = DetailPinjam::find($this->detail_pinjam_id);

        if (!$detail) {
            session()->flash('error', 'Detail pinjam tidak ditemukan.');
            return;
        }

        Pengembalian::create([
            'pinjam_id' => $detail->pinjam_id,
            'detail_pinjam_id' => $this->detail_pinjam_id,
            'tgl_kembali' => $this->tgl_kembali,
            'denda' => $this->denda ?? 0,
        ]);

        // *** Tambahan untuk balikin stok buku ***
        $buku = $detail->buku;
        $buku->increment('jumlah');
        if ($buku->jumlah > 0) {
            $buku->status = 'tersedia';
            $buku->save();
        }
        $pinjamId = $detail->pinjam_id;
        $totalBuku = DetailPinjam::where('pinjam_id', $pinjamId)->pluck('id')->toArray();
        $bukuDikembalikan = Pengembalian::where('pinjam_id', $pinjamId)->pluck('detail_pinjam_id')->toArray();

        // Kalau semua ID detail pinjam sudah ada di tabel pengembalian
        if (empty(array_diff($totalBuku, $bukuDikembalikan))) {
            $detail->pinjam->update(['status' => 'kembali']);
        }


        $this->reset(['detail_pinjam_id', 'tgl_kembali', 'denda']);
        session()->flash('success', 'Pengembalian berhasil disimpan.');
        return redirect()->route('pengembalian');
    }
}
