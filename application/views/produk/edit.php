<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" name="NamaProduk" class="form-control" value="<?= $produk->NamaProduk; ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" name="Harga" class="form-control" value="<?= $produk->Harga; ?>" required>
                </div>
                <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="Stok" class="form-control" value="<?= $produk->Stok; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('produk'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
