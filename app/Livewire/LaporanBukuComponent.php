<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Buku;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanBukuComponent extends Component
{
    use WithPagination;

    public $kategori = '';
    public $status = '';
    public $tanggalMulai = '';
    public $tanggalAkhir = '';
    public $showTable = false;
    public $judul = 'Laporan Buku';

    protected $paginationTheme = 'bootstrap';

    public function tampilkan()
    {
        $this->showTable = true;
        $this->judul = 'Laporan Buku';

        if ($this->status) {
            $this->judul .= ' ' . ucfirst($this->status);
        }

        if ($this->kategori) {
            $kat = Kategori::find($this->kategori);
            if ($kat) {
                $this->judul .= " (Kategori: " . $kat->nama . ")";
            }
        }
    }

    public function render()
    {
        $x['title'] = "Laporan Buku";

        $query = Buku::with('kategori');

        // filter kategori
        if ($this->kategori) $query->where('kategori_id', $this->kategori);

        // filter tanggal
        if ($this->tanggalMulai && $this->tanggalAkhir) {
            $query->whereBetween('created_at', [$this->tanggalMulai, $this->tanggalAkhir]);
        }

        if ($this->status) {
            if ($this->status === 'dipinjam') {
                // hanya buku yang sedang dipinjam
                $query->whereHas('detail', function ($q) {
                    $q->where('status', 'dipinjam');
                })
                    ->withCount(['detail as jumlah' => function ($q) {
                        $q->where('status', 'dipinjam');
                    }]);
            } else {
                // buku tersedia / rusak / hilang → jumlah ambil dari kolom buku langsung
                $query->where('status', $this->status);
                // kita bisa pakai select raw untuk menambahkan alias jumlah = kolom jumlah
                $query->select('*', 'jumlah as jumlah');
            }
        } else {
            // semua status → jumlah = kolom jumlah
            $query->select('*', 'jumlah as jumlah');
        }

        $buku = $this->showTable ? $query->paginate(10) : collect();

        return view('livewire.laporan-buku-component', [
            'buku' => $buku,
            'kategoriList' => Kategori::all(),
        ])->layoutData($x);
    }

    public function exportPdf()
    {
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');
        mb_internal_encoding("UTF-8");

        $query = Buku::with('kategori');

        if ($this->kategori) $query->where('kategori_id', $this->kategori);
        if ($this->tanggalMulai && $this->tanggalAkhir)
            $query->whereBetween('created_at', [$this->tanggalMulai, $this->tanggalAkhir]);

        if ($this->status) {
            if ($this->status === 'dipinjam') {
                $query->whereHas('detail', fn($q) => $q->where('status', 'dipinjam'))
                    ->withCount(['detail as jumlah' => fn($q) => $q->where('status', 'dipinjam')]);
            } else {
                $query->where('status', $this->status)
                    ->select('*', 'jumlah as jumlah'); // ambil jumlah dari kolom buku
            }
        } else {
            $query->select('*', 'jumlah as jumlah'); // semua buku
        }

        $buku = $query->get();

        $pdf = Pdf::loadView('pdf.laporan-buku', [
            'judul' => $this->judul,
            'buku' => $buku,
            'tanggalMulai' => $this->tanggalMulai ?: '-',
            'tanggalAkhir' => $this->tanggalAkhir ?: '-',
        ])->setPaper('a4', 'potrait');

        return response()->streamDownload(fn() => print($pdf->output()), 'laporan-buku.pdf');
    }
}
