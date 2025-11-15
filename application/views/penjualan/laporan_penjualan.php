<div class="container-fluid">

    <h1 class="h3 mb-3 text-gray-800"><?= isset($title) ? $title : 'Laporan Penjualan'; ?></h1>

    <style>
        /* action boxes: keep Export / Download / Tampilkan consistent */
        .action-box {
            width: 150px;
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-direction: row;
            gap: 8px;
            border-radius: 8px;
            color: #fff;
            padding: 6px 12px;
            font-size: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .action-box .icon { font-size: 18px; display:inline-block; }
        .action-box:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(0,0,0,0.08); }
        .action-box:focus { outline: none; box-shadow: 0 0 0 0.2rem rgba(0,123,255,.15); }

        /* layout: left filters, right actions */
        .filters-row { display:flex; justify-content:space-between; align-items:center; gap:16px; }
        .filters-left { display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
        .filters-right { display:flex; gap:8px; align-items:center; }

        /* card + table polish */
        .card { border: 1px solid rgba(34,41,47,0.05); border-radius: 8px; }
        .card .card-body { padding: 18px; }
        .table thead th { background: #f6f9fc; border-bottom: 2px solid rgba(0,0,0,0.04); }
        .table tbody td { padding: 12px 10px; }
        .table-striped tbody tr:nth-of-type(odd) { background: #fbfcfd; }
        .table thead th, .table tbody td { vertical-align: middle; }

        /* responsive tweak for small screens */
        @media (max-width: 768px) {
            .action-box { width: 110px; font-size:13px; }
            .filters-row { flex-direction: column; align-items: stretch; }
            .filters-right { justify-content:flex-start; }
        }
    </style>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success; ?></div>
    <?php endif; ?>

    <?php
    // Ensure total_harga is available (fallback compute if controller didn't pass it)
    if (!isset($total_harga)) {
        $total_harga = 0;
        if (!empty($laporan)) {
            foreach ($laporan as $r) {
                $total_harga += (float)($r->TotalHarga ?? 0);
            }
        }
    }
    function _format_rp($n) { return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
    ?>

    <!-- Filter Tanggal -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="get" id="filterForm" action="<?= base_url('laporan_penjualan'); ?>">
                <div class="filters-row">
                    <div class="filters-left">
                        <div>
                            <label class="small d-block">Dari Tanggal</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?= set_value('tanggal_mulai', $tanggal_mulai); ?>">
                        </div>
                        <div>
                            <label class="small d-block">Sampai Tanggal</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="<?= set_value('tanggal_selesai', $tanggal_selesai); ?>">
                        </div>
                    </div>
                    <div class="filters-right">
                        <button type="submit" class="btn btn-primary action-box" id="btnTampilkan">
                            <span class="icon"><i class="fas fa-search"></i></span>
                            <span>Tampilkan</span>
                        </button>

                        <button type="button" id="btnExport" class="btn btn-success action-box">
                            <span class="icon"><i class="fas fa-file-excel"></i></span>
                            <span>Export Excel</span>
                        </button>

                        <?php
                            $q_tanggal_mulai_top = isset($tanggal_mulai) && $tanggal_mulai !== null ? urlencode($tanggal_mulai) : '';
                            $q_tanggal_selesai_top = isset($tanggal_selesai) && $tanggal_selesai !== null ? urlencode($tanggal_selesai) : '';
                        ?>

                        <button type="button" id="btnClientPdf" class="btn btn-info action-box">
                            <span class="icon"><i class="fas fa-download"></i></span>
                            <span>Download PDF</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <!-- Tabel Laporan -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th width="60">No</th>
                                <th width="100">No Struk</th>
                                <th>Tanggal</th>
                                <th>Nama Pelanggan</th>
                                <th>Nama Produk</th>
                                <th class="text-right">Total Harga</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php if (!empty($laporan)) : ?>
                            <?php $no = 1;
                            foreach ($laporan as $l) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td class="text-center"><?= isset($l->PenjualanID) ? $l->PenjualanID : '-'; ?></td>
                                    <td><?= !empty($l->TanggalPenjualan) ? date('d-m-Y', strtotime($l->TanggalPenjualan)) : '-'; ?></td>
                                    <td><?= !empty($l->NamaPelanggan) ? html_escape($l->NamaPelanggan) : '-'; ?></td>
                                    <td><?= !empty($l->NamaProdukList) ? html_escape($l->NamaProdukList) : '-'; ?></td>
                                    <td class="text-right"><?= _format_rp($l->TotalHarga); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada data penjualan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($laporan)) : ?>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right bg-light font-weight-bold">Total Seluruhnya</th>
                                <th class="text-right bg-light font-weight-bold"><?= _format_rp($total_harga); ?></th>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // load html2pdf via CDN dynamically when user clicks download button to avoid extra load
    function loadHtml2Pdf(callback) {
        if (window.html2pdf) {
            return callback();
        }
        var s = document.createElement('script');
        s.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js';
        s.onload = callback;
        s.onerror = function() { alert('Gagal memuat library PDF client-side.'); };
        document.head.appendChild(s);
    }

    document.getElementById('btnClientPdf').addEventListener('click', function() {
        // ambil elemen tabel laporan
        var tableContainer = document.querySelector('.table-responsive');
        if (!tableContainer) {
            alert('Tidak ada data untuk dicetak.');
            return;
        }
        loadHtml2Pdf(function() {
            try {
                var now = new Date();
                var filename = 'laporan_penjualan_' + now.getFullYear() + (now.getMonth()+1).toString().padStart(2,'0') + now.getDate().toString().padStart(2,'0') + '_' + now.getHours().toString().padStart(2,'0') + now.getMinutes().toString().padStart(2,'0') + now.getSeconds().toString().padStart(2,'0') + '.pdf';
                var opt = {
                    margin:       10,
                    filename:     filename,
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
                };
                // clone element to avoid modifying page layout
                var clone = tableContainer.cloneNode(true);
                // wrap clone into a temporary container to set styles
                var wrapper = document.createElement('div');
                wrapper.style.padding = '10px';
                wrapper.appendChild(clone);
                document.body.appendChild(wrapper);
                html2pdf().set(opt).from(wrapper).save().then(function() {
                    // remove wrapper after save
                    document.body.removeChild(wrapper);
                }).catch(function(err){
                    console.error(err);
                    alert('Gagal membuat PDF client-side.');
                });
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan saat membuat PDF.');
            }
        });
    });
    document.getElementById('btnExport').addEventListener('click', function() {
        var start = document.getElementById('tanggal_mulai').value || '';
        var end = document.getElementById('tanggal_selesai').value || '';
        var url = '<?= base_url('laporan_penjualan/export'); ?>' + '?tanggal_mulai=' + encodeURIComponent(start) + '&tanggal_selesai=' + encodeURIComponent(end);
        window.location.href = url;
    });
</script>