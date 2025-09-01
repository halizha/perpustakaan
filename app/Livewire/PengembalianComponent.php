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
    public $statusEksemplar = 'tersedia'; // default
    public $dendaManual = null; // untuk input manual


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
        $detail = DetailPinjam::with('buku', 'pinjam.user', 'eksemplar')->find($detailId);
        $this->detail_pinjam_id = $detail->id;

        $this->judul = $detail->buku->judul ?? 'Tidak ditemukan';
        $this->member = $detail->pinjam->user->nama ?? 'Tidak ditemukan';
        $this->tgl_kembali = $detail->tgl_kembali;
        $this->id = $detail->pinjam->id;

        $jatuhTempo = new DateTime($this->tgl_kembali);
        $hariIni = new DateTime();
        $selisih = $hariIni->diff($jatuhTempo);

        $this->status = $hariIni > $jatuhTempo;
        $this->lama = $this->status ? $selisih->days : 0;

        // default
        $this->statusEksemplar = 'tersedia';
        $this->dendaManual = null;
    }


    // Fungsi simpan pengembalian

public function store()
{
    // Validasi dasar
    $rules = [
        'detail_pinjam_id' => 'required',
        'tgl_kembali'      => 'required|date',
    ];

    // Kalau status hilang/rusak → wajib isi denda manual
    if (in_array($this->statusEksemplar, ['hilang', 'rusak'])) {
        $rules['dendaManual'] = 'required|numeric|min:1';
    }

    $this->validate($rules);

    $detail = DetailPinjam::with(['eksemplar', 'buku'])->find($this->detail_pinjam_id);

    if (!$detail) {
        session()->flash('error', 'Detail pinjam tidak ditemukan.');
        return;
    }

    // ✅ Tentukan jumlah denda
    if ($this->statusEksemplar === 'tersedia') {
        $denda = $this->status ? $this->lama * 500 : 0;
    } else {
        $denda = $this->dendaManual ?? 0;
    }

    // ✅ Simpan data pengembalian
    Pengembalian::create([
        'pinjam_id'        => $detail->pinjam_id,
        'detail_pinjam_id' => $detail->id,
        'tgl_kembali'      => now(),
        'denda'            => $denda,
    ]);

    // ✅ Update status eksemplar
    if ($detail->eksemplar) {
        $detail->eksemplar->update([
            'status' => $this->statusEksemplar === 'tersedia' ? 'tersedia' : $this->statusEksemplar
        ]);
    }

    // ✅ Update stok buku
    if ($detail->buku) {
        $buku = $detail->buku;
        $buku->jumlah = $buku->eksemplars()->where('status', 'tersedia')->count();
        $buku->status = $buku->jumlah > 0 ? 'tersedia' : 'habis';
        $buku->save();
    }

    // ✅ Update status pinjam kalau semua buku sudah kembali
    $pinjamId = $detail->pinjam_id;
    $totalBuku = DetailPinjam::where('pinjam_id', $pinjamId)->pluck('id')->toArray();
    $bukuDikembalikan = Pengembalian::where('pinjam_id', $pinjamId)->pluck('detail_pinjam_id')->toArray();

    if (empty(array_diff($totalBuku, $bukuDikembalikan))) {
        $pinjam = Pinjam::find($pinjamId);
        if ($pinjam) {
            $pinjam->update(['status' => 'kembali']);
        }
    }

    // ✅ Reset form
    $this->reset([
        'detail_pinjam_id', 
        'tgl_kembali', 
        'dendaManual', 
        'statusEksemplar',
        'lama',
        'status',
    ]);

    session()->flash('success', 'Pengembalian berhasil disimpan.');
    return redirect()->route('pengembalian');
}


}
