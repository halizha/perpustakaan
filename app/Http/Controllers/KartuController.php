<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuController extends Controller
{
    public function cetak()
    {
        // ambil id yang disimpan di session
        $ids = session('cetak_ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada siswa yang dipilih untuk dicetak.');
        }

        // ambil siswa sesuai id
        $siswa = User::whereIn('id', $ids)
            ->orderBy('nama', 'asc')
            ->get();

        $pdf = Pdf::loadView('siswa.kartu', compact('siswa'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('kartu-siswa.pdf');
    }
}  