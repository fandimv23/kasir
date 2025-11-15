<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="NamaProduk" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="Harga" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="Stok" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?= base_url('produk'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
