<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KartuGuruController extends Controller
{
    public function cetak(Request $request)
    {
        // Ambil id guru yang disimpan di session dari Livewire
        $ids = session()->get('cetak_ids', []);

        if (empty($ids)) {
            return redirect()->route('guru')->with('error', 'Tidak ada guru yang dipilih.');
        }

        // Ambil data guru berdasarkan id terpilih
        $guru = User::where('jenis', 'guru')
            ->whereIn('id', $ids)
            ->get();

        $pdf = Pdf::loadView('siswa.kartu-guru', compact('guru'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('kartu-guru.pdf');
    }
}
