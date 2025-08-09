<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Buku;

class SearchComponent extends Component
{
    public function render()
    {
        // Jangan dipakai untuk AJAX
        abort(404);
    }

    public function __invoke(Request $request)
    {
        $search = $request->q;

        $data = Buku::where('judul', 'like', '%' . $search . '%')
            ->select('id', 'judul as text')
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}
