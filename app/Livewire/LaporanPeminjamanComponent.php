<?php

namespace App\Livewire;

use App\Models\Pinjam;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanPeminjamanComponent extends Component
{
    use WithPagination;

    public $tanggalMulai;
    public $tanggalAkhir;
    public $status;
    public $jenis; // siswa / guru
    public $showTable = false; // default tabel belum tampil

    protected $paginationTheme = 'bootstrap';

    public function tampilkan()
    {
        $this->showTable = true;
        $this->resetPage(); // biar balik ke page 1 saat filter
    }

    public function render()
    {
        $pinjam = collect(); // default kosong

        if ($this->showTable) {
            $query = Pinjam::with(['user', 'detail.buku']);

            // Filter tanggal pinjam
            if ($this->tanggalMulai) {
                $query->whereDate('tgl_pinjam', '>=', $this->tanggalMulai);
            }

            // Filter tanggal kembali
            if ($this->tanggalAkhir) {
                $query->whereDate('tgl_kembali', '<=', $this->tanggalAkhir);
            }

            // Filter status custom
            if ($this->status) {
                if ($this->status === 'aktif') {
                    $query->where('status', 'pinjam')
                          ->whereDate('tgl_kembali', '>=', Carbon::today());
                } elseif ($this->status === 'terlambat') {
                    $query->where('status', 'pinjam')
                          ->whereDate('tgl_kembali', '<', Carbon::today());
                } elseif ($this->status === 'selesai') {
                    $query->where('status', 'kembali');
                }
            }

            // Filter jenis user
            if ($this->jenis) {
                $query->whereHas('user', function ($q) {
                    $q->where('jenis', $this->jenis);
                });
            }

            $pinjam = $query->latest()->paginate(10);
        }

        return view('livewire.laporan-peminjaman-component', compact('pinjam'));
    }

    public function getJudulProperty()
    {
        switch ($this->status) {
            case 'aktif':
                return 'Laporan Peminjaman Aktif';
            case 'terlambat':
                return 'Laporan Peminjaman Terlambat';
            case 'selesai':
                return 'Riwayat Peminjaman';
            default:
                return 'Semua Laporan Peminjaman';
        }
    }

    public function exportPdf()
    {
        // Locale Indonesia
        \Carbon\Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8');
        mb_internal_encoding("UTF-8");

        // Query data sesuai filter
        $query = Pinjam::with(['user', 'detail.buku']);

        if ($this->tanggalMulai) {
            $query->whereDate('tgl_pinjam', '>=', $this->tanggalMulai);
        }

        if ($this->tanggalAkhir) {
            $query->whereDate('tgl_kembali', '<=', $this->tanggalAkhir);
        }

        // Mapping status ke kondisi query
        if ($this->status) {
            if ($this->status === 'aktif') {
                $query->where('status', 'pinjam')
                      ->whereDate('tgl_kembali', '>=', Carbon::today());
            } elseif ($this->status === 'terlambat') {
                $query->where('status', 'pinjam')
                      ->whereDate('tgl_kembali', '<', Carbon::today());
            } elseif ($this->status === 'selesai') {
                $query->where('status', 'kembali');
            }
        }

        if ($this->jenis) {
            $query->whereHas('user', function ($q) {
                $q->where('jenis', $this->jenis);
            });
        }

        $pinjam = $query->latest()->get();

        // Format tanggal ke Indonesia
        $tanggalMulai = $this->tanggalMulai
            ? Carbon::createFromFormat('Y-m-d', $this->tanggalMulai)->translatedFormat('d F Y')
            : null;

        $tanggalAkhir = $this->tanggalAkhir
            ? Carbon::createFromFormat('Y-m-d', $this->tanggalAkhir)->translatedFormat('d F Y')
            : null;

        // Judul laporan dinamis
        $judul = $this->judul;

        // Generate PDF
        $pdf = Pdf::loadView('pdf.laporan-peminjaman', [
            'pinjam' => $pinjam,
            'judul' => $judul,
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir
        ])->setPaper('a4', 'portrait');

        // Font UTF-8 friendly
        $pdf->getDomPDF()->set_option("isFontSubsettingEnabled", true);
        $pdf->getDomPDF()->set_option("defaultFont", "DejaVu Sans");

        // Preview di browser, bukan auto download
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "laporan-peminjaman.pdf", ["Content-Type" => "application/pdf"]);
    }
}
