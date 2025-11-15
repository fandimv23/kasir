<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">

        <!-- Total Penjualan Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Penjualan Hari Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp <?= number_format($total_penjualan, 0, ',', '.'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Transaksi Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Jumlah Transaksi Hari Ini</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $jumlah_transaksi; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Aktif -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Barang Aktif</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $jumlah_barang; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Pelanggan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Jumlah Pelanggan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?= $jumlah_pelanggan; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Produk Tidak Aktif (Stok = 0) -->
<div class="container-fluid mt-3">
        <!-- Produk Aktif (Stok > 0) -->
        <div class="card mb-3">
            <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">Produk Aktif</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($produk_aktif)) : ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Produk</th>
                                    <th width="120">Harga</th>
                                    <th width="80">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = 1; foreach ($produk_aktif as $p): ?>
                                    <tr>
                                        <td><?= $j++; ?></td>
                                        <td><?= html_escape($p['NamaProduk']); ?></td>
                                        <td>Rp <?= number_format($p['Harga'], 0, ',', '.'); ?></td>
                                        <td><?= (int)$p['Stok']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-muted">Tidak ada produk aktif.</div>
                <?php endif; ?>
            </div>
        </div>

    <div class="card">
        <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Produk Tidak Aktif</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($produk_tidak_aktif)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Produk</th>
                                <th width="120">Harga</th>
                                <th width="80">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($produk_tidak_aktif as $p): ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= html_escape($p['NamaProduk']); ?></td>
                                    <td>Rp <?= number_format($p['Harga'], 0, ',', '.'); ?></td>
                                    <td><?= (int)$p['Stok']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-muted">Tidak ada produk dengan stok 0.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
