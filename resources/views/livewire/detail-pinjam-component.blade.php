<div>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Peminjaman</h5>
        </div>
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-3">
                <div class="d-flex mb-2">
                    <strong class="me-3" style="min-width: 150px;">Nama Peminjam:</strong>
                    <span>{{ $pinjam->user->nama ?? '-' }}</span>
                </div>
                <div class="d-flex mb-2">
                    <strong class="me-3" style="min-width: 150px;">Tanggal Pinjam:</strong>
                    <span>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d-m-Y') }}</span>
                </div>
                <div class="d-flex mb-2">
                    <strong class="me-3" style="min-width: 150px;">Tanggal Kembali:</strong>
                    <span>{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d-m-Y') }}</span>
                </div>
                <div class="d-flex mb-2">
                    <strong class="me-3" style="min-width: 150px;">Status:</strong>
                    <span>{{ ucfirst($pinjam->status) }}</span>
                </div>
            </div>

            <h6 class="mt-4">Daftar Buku yang Dipinjam:</h6>
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjam->detail as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $d->buku->judul ?? '-' }}</td>
                            
                            <td>
                                <button wire:click="edit({{ $d->id }})" class="btn btn-sm btn-outline-info"
                                    data-toggle="modal" data-target="#editPage">Ubah</button>
                                <button wire:click="confirm({{ $d->id }})" class="btn btn-sm btn-outline-danger"
                                    data-toggle="modal" data-target="#deletePage">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada detail peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Ubah -->
    <div wire:ignore.self class="modal fade" id="editPage" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="update">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">Ubah Keterangan</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" wire:model="editKeterangan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div wire:ignore.self class="modal fade" id="deletePage" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form wire:submit.prevent="delete">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        Yakin ingin menghapus data ini?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Close Modal -->
<script>
    window.addEventListener('close-modal', event => {
        $('#' + event.detail).modal('hide');
    });
</script>
