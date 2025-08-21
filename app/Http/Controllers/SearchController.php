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
    public function searchMember(Request $request)
    {
        $search = $request->get('q');

        $data = User::where('jenis', 'siswa')
            ->where('akun', 'aktif') // 🔥 hanya tampilkan yang aktif
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->select('id', 'nama as text')
            ->get();

        return response()->json($data);
    }
}
