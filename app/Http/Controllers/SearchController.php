<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\User;

class SearchController extends Controller
{
    public function searchBuku(Request $request)
    {
        $search = $request->q;

        $books = Buku::where('judul', 'like', '%' . $search . '%')->get();

        $result = [];

        foreach ($books as $book) {
            $result[] = [
                'id' => $book->id,
                'text' => $book->judul
            ];
        }

        return response()->json($result);
    }

    public function searchKodeBuku(Request $request)
    {
        $bukuId = $request->buku_id;
        $search = $request->q;

        $eksemplar = \App\Models\EksemplarBuku::where('buku_id', $bukuId)
            ->where('status', 'tersedia') // ✅ cuma yang bisa dipinjam
            ->when($search, fn($q) => $q->where('kode_eksemplar', 'like', "%{$search}%"))
            ->get();

        return response()->json(
            $eksemplar->map(fn($e) => [
                'id' => $e->id,
                'text' => $e->kode_eksemplar
            ])
        );
    }

    public function searchMember(Request $request)
    {
        $search = $request->get('q');

        $data = User::whereIn('jenis', ['siswa', 'guru']) // siswa & guru boleh pinjam
            ->where('akun', 'aktif')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'text' => $user->nama,
                    'kelas' => $user->jenis === 'siswa' ? $user->kelas : '-', // kalau guru jadi '-'
                ];
            });

        return response()->json($data);
    }
}
