<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input type="text" name="NamaPelanggan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="Alamat" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="NomorTelepon" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= base_url('pelanggan'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
