<div>
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Daftar Kategori Buku</span>
            <div>
                <button class="btn btn-light btn-sm" wire:click="$set('viewMode','card')">
                    <i class="bi bi-grid-3x3-gap"></i> Card
                </button>
                <button class="btn btn-light btn-sm" wire:click="$set('viewMode','table')">
                    <i class="bi bi-table"></i> Tabel
                </button>
            </div>
        </div>
        <div class="card-body">

            {{-- MODE CARD --}}
            @if ($viewMode === 'card')
                <div class="d-flex flex-wrap gap-3 justify-content-start">
                    @foreach ($kategori as $item)
                        @php
                            $iconMap = [
                                'Novel' => 'bi-book',
                                'Bahasa' => 'bi-journal-text',
                                'IPA' => 'bi-cpu',
                                'IPS' => 'bi-hourglass-split',
                                'Matematika' => 'bi-lightbulb',
                                'Agama' => 'bi-moon-stars',
                            ];
                            $icon = $iconMap[$item->nama] ?? 'bi-book';
                        @endphp

                        <a href="{{ route('member.kategori.buku', $item->id) }}"
                           class="kategori-card text-decoration-none d-flex flex-column justify-content-center align-items-center">
                            <div class="kategori-icon mb-2">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <div class="kategori-nama fw-bold">
                                {{ $item->nama }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- MODE TABLE --}}
            @if ($viewMode === 'table')
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Buku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->buku->count() }}</td>
                                <td>
                                    <a href="{{ route('member.kategori.buku', $item->id) }}" 
                                       class="btn btn-sm btn-primary">Lihat Buku</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{ $kategori->links() }}
        </div>
    </div>

    <style>
        .kategori-card {
            background: #fff;
            color: #000;
            border: 2px solid #000;
            border-radius: 0;
            transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
            aspect-ratio: 1 / 1;
            width: 160px;
        }

        .kategori-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            background: #f8f9fa;
            color: #000;
        }

        .kategori-icon {
            font-size: 2rem;
            color: #000;
        }

        .kategori-nama {
            font-size: 1rem;
            color: #000;
            text-align: center;
        }
    </style>
</div>
