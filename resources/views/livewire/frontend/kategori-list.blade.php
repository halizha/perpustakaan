<section id="kategori" class="fullscreen">
    <h1 class="mb-4 text-center">Daftar Kategori Buku</h1>
    <div class="kategori-grid">
        @foreach ($kategori as $item)
            @php
                $iconMap = [
                    'Novel' => ['bi-book', '#6f42c1'],
                    'Bahasa' => ['bi-journal-text', '#0dcaf0'],
                    'IPA' => ['bi-cpu', '#0d6efd'],
                    'IPS' => ['bi-hourglass-split', '#198754'],
                    'Matematika' => ['bi-lightbulb', '#fd7e14'],
                    'Agama' => ['bi-moon-stars', '#dc3545'],
                ];
                $icon = $iconMap[$item->nama][0] ?? 'bi-book';
                $color = $iconMap[$item->nama][1] ?? '#20c997';
            @endphp

            <a href="{{ route('kategori.buku', $item->id) }}" class="kategori-card"
                style="--bg-color: {{ $color }};">
                <div class="kategori-icon">
                    <i class="bi {{ $icon }}"></i>
                </div>
                <div class="kategori-nama fw-bold">
                    {{ $item->nama }}
                </div>
            </a>
        @endforeach
    </div>
</section>

<style>
    .kategori-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 kolom */
        gap: 20px;
        /* jarak antar kotak */
    }

    .kategori-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: var(--bg-color, #20c997);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-decoration: none;
        height: 150px;
        /* ukuran kotak tetap */
    }
</style>
