<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pinjam;
use Carbon\Carbon;

class RiwayatComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $x['title'] = "Riwayat";
        $riwayat = Pinjam::with(['detail.buku'])
            ->where('user_id', auth()->id())
            ->orderBy('tgl_pinjam', 'desc')
            ->paginate(10);

        // Tambahin perhitungan denda
        foreach ($riwayat as $pinjam) {
            $denda = 0;
            $tarif = 500;

            if ($pinjam->tgl_kembali) {
                $today = Carbon::now();

                if ($pinjam->status === 'pinjam') {
                    // Buku belum balik → hitung telat dari today vs due date
                    if ($today->gt(Carbon::parse($pinjam->tgl_kembali))) {
                        $hariTelat = Carbon::parse($pinjam->tgl_kembali)->diffInDays($today);
                        $denda = $hariTelat * $tarif;
                    }
                } elseif ($pinjam->status === 'kembali') {
                    // Buku udah balik → hitung telat dari real return date vs due date
                    $actualReturn = Carbon::parse($pinjam->updated_at); // atau kolom lain buat tanggal kembali real
                    if ($actualReturn->gt(Carbon::parse($pinjam->tgl_kembali))) {
                        $hariTelat = Carbon::parse($pinjam->tgl_kembali)->diffInDays($actualReturn);
                        $denda = $hariTelat * $tarif;
                    }
                }
            }

            $pinjam->denda = $denda;
        }

        return view('livewire.riwayat-component', compact('riwayat'))
            ->layoutData($x);
    }
}
