 <section id="kategori" class="fullscreen">
     <h1 class="mb-4">Daftar Kategori Buku</h1>
     <div class="d-flex flex-wrap gap-4 justify-content-center">
         @foreach ($kategori as $item)
             @php
                 $iconMap = [
                     'Novel' => ['bi-book', '#6f42c1'],
                     'Non Fiksi' => ['bi-journal-text', '#0dcaf0'],
                     'Teknologi' => ['bi-cpu', '#0d6efd'],
                     'Sejarah' => ['bi-hourglass-split', '#198754'],
                     'Sains' => ['bi-lightbulb', '#fd7e14'],
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
