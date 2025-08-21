<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pinjam;
use App\Services\FonnteService;
use Carbon\Carbon;

class KirimWA extends Command
{
    protected $signature = 'kirim:wa';
    protected $description = 'Kirim WA pengingat pengembalian buku H-1, H, H+1 dengan denda';

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $besok = Carbon::now()->addDay()->toDateString();

        // H-1 → pengingat besok
        $this->kirimPesan($besok, 'H-1');

        // H → pengingat hari ini
        $this->kirimPesan($today, 'H');

        // H+1 → peminjaman yang terlambat
        $this->kirimTerlambat();
    }

    private function kirimPesan($tanggal, $label)
    {
        $peminjaman = Pinjam::with(['user', 'detail.buku'])
            ->whereDate('tgl_kembali', $tanggal)
            ->where('status', 'pinjam')
            ->get();

        if ($peminjaman->isEmpty()) {
            $this->info("Tidak ada peminjaman $label ($tanggal)");
            return;
        }

        foreach ($peminjaman as $pinjam) {
            $nama = $pinjam->user->nama;
            $telepon = $pinjam->user->telepon;
            $judulBuku = $pinjam->detail->map(fn($d) => $d->buku->judul)->join(', ');
            $tglKembali = Carbon::parse($pinjam->tgl_kembali)->format('d-m-Y'); // <-- format tanggal

            if ($label === 'H-1') {
                $pesan = "Halo *{$nama}*, 👋\n"
                    . "Jangan lupa ya, buku *\"{$judulBuku}\"* yang kamu pinjam jatuh tempo pada *{$tglKembali}*.\n"
                    . "Pastikan buku dikembalikan tepat waktu supaya kamu nggak kena denda keterlambatan 📚.\n"
                    . "Kalau ada kendala atau belum sempat mengembalikan, jangan ragu untuk menghubungi petugas perpustakaan supaya bisa dicatat terlebih dahulu.\n"
                    . "Terima kasih sudah meminjam dan merawat buku dengan baik ✨.";
            } elseif ($label === 'H') {
                $pesan = "Halo *{$nama}*, 👋\n"
                    . "Buku *\"{$judulBuku}\"* yang kamu pinjam jatuh tempo hari ini (*{$tglKembali}*).\n"
                    . "Segera dikembalikan ya supaya tidak terkena denda 📚.\n"
                    . "Kalau ada kendala, silakan hubungi petugas perpustakaan ✨.";
            }

            try {
                FonnteService::sendMessage($telepon, $pesan);
                $this->info("WA dikirim ke $telepon ($label)");
            } catch (\Exception $e) {
                $this->error("Gagal kirim ke $telepon: " . $e->getMessage());
            }
        }
    }

    private function kirimTerlambat()
    {
        $hariIni = Carbon::now();

        $peminjaman = Pinjam::with(['user', 'detail.buku'])
            ->whereDate('tgl_kembali', '<', $hariIni->toDateString())
            ->where('status', 'pinjam')
            ->get();

        if ($peminjaman->isEmpty()) {
            $this->info("Tidak ada peminjaman terlambat (H+1 ke atas)");
            return;
        }

        foreach ($peminjaman as $pinjam) {
            $nama = $pinjam->user->nama;
            $telepon = $pinjam->user->telepon;
            $judulBuku = $pinjam->detail->map(fn($d) => $d->buku->judul)->join(', ');
            $tglKembali = Carbon::parse($pinjam->tgl_kembali)->format('d-m-Y'); // <-- format tanggal

            if ($hariIni->gt(Carbon::parse($pinjam->tgl_kembali))) {
                $hariTerlambat = Carbon::parse($pinjam->tgl_kembali)->diffInDays($hariIni);
                $hariTerlambat = max(1, $hariTerlambat);
                $denda = $hariTerlambat * 500;

                $pesan = "Halo *{$nama}*, ⚠️\n"
                    . "Buku *\"{$judulBuku}\"* yang kamu pinjam seharusnya dikembalikan pada *{$tglKembali}*.\n"
                    . "Saat ini terlambat {$hariTerlambat} hari, denda sebesar Rp{$denda}.\n"
                    . "Segera kembalikan buku ya 📚.\n"
                    . "Kalau ada kendala, segera hubungi petugas perpustakaan ✨.";
                try {
                    FonnteService::sendMessage($telepon, $pesan);
                    $this->info("WA dikirim ke $telepon (H+{$hariTerlambat})");
                } catch (\Exception $e) {
                    $this->error("Gagal kirim ke $telepon: " . $e->getMessage());
                }
            }
        }
    }
}
