<!-- resources/views/modals/edit-barang-keluar.blade.php -->
<div class="modal fade" id="editBarangKeluarModal" tabindex="-1" aria-labelledby="editBarangKeluarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangKeluarModalLabel">Edit Barang Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBarangKeluarForm" method="POST">
                    @csrf
                    @method('PUT') <!-- Untuk mengindikasikan update -->
                    <div class="mb-3">
                        <label for="edit-nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit-nama" name="nama_barang" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-penanggungjawab" class="form-label">Penanggung Jawab</label>
                        <input type="text" class="form-control" id="edit-penanggungjawab" name="penanggungjawab" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="edit-kategori" name="kategori" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-kondisi" class="form-label">Kondisi</label>
                        <input type="text" class="form-control" id="edit-kondisi" name="kondisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="edit-lokasi" name="lokasi" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tanggal" class="form-label">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="edit-tanggal" name="tanggal_keluar" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-masapakai" class="form-label">Masa Pakai</label>
                        <input type="text" class="form-control" id="edit-masapakai" name="masa_pakai" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
