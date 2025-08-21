<div class="card">
    <div class="card-header bg-primary text-white">
        Daftar Buku
    </div>
    <div class="card-body">
        <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari...">

        {{-- Grid 5 kolom --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            @foreach ($buku as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if ($item->sampul)
                            <img src="{{ asset('storage/' . $item->sampul) }}" class="card-img-top" alt="Sampul Buku">
                        @else
                            <img src="{{ asset('default.png') }}" class="card-img-top" alt="Default Sampul">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->judul }}</h5>
                            <p class="card-text">
                                <small>Penulis: {{ $item->penulis }}</small><br>
                                <small>Penerbit: {{ $item->penerbit }}</small>
                            </p>
                            <a href="{{ route('member.buku.detail', $item->id) }}" class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $buku->links() }}
        </div>
    </div>
</div>
