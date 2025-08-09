<div class="card">
    <div class="card-header">
        Daftar Buku
    </div>
    <div class="card-body">
        <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari...">

        <div class="row">
            @foreach ($buku as $item)
                <div class="col-md-3 mb-4">
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
                            <a href="{{ route('member.buku.detail', $item->id) }}"
                                class="btn btn-primary btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $buku->links() }}
    </div>
</div>
</div>
