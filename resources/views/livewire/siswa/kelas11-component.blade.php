<div>
    <div class="card">
        <div class="card-header">
            Siswa Kelas 11
        </div>
        <div class="card-body">
            <input type="text" wire:model.live="cari" class="form-control w-50 mb-3" placeholder="Cari nama atau kelas ...">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th>No WA</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswaKelas11 as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->nis }}</td>
                        <td>{{ $data->kelas }}</td>
                        <td>{{ $data->alamat }}</td>
                        <td>{{ $data->telepon }}</td>
                        <td>{{ $data->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $siswaKelas11->links() }}
</div>
