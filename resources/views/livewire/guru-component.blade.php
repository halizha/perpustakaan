<div>
    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            Data Guru
        </div>
        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari nama, email, atau NIP...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIP</th>
                            <th>Alamat</th>
                            <th>No WA</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($guru as $g)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $g->nama }}</td>
                                <td>{{ $g->nip }}</td>
                                <td>{{ $g->alamat }}</td>
                                <td>{{ $g->telepon }}</td>
                                <td>{{ $g->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data guru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $guru->links() }}
            </div>
        </div>
    </div>
</div>
