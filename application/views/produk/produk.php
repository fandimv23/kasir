<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <a href="<?= base_url('produk/tambah'); ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
            <table id="produk-table" class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($produk as $p): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= isset($p['NamaProduk']) ? $p['NamaProduk'] : '-' ?></td>
                            <td>Rp <?= isset($p['Harga']) ? number_format($p['Harga'], 0, ',', '.') : '0'; ?></td>
                            <td><?= isset($p['Stok']) ? $p['Stok'] : '0'; ?></td>
                            <td>
                                <a href="<?= base_url('produk/edit/' . $p['ProdukID']); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('produk/hapus/' . $p['ProdukID']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?');"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <!-- pagination controls inserted here -->
            <nav id="produk-pagination" aria-label="Page navigation" style="display:none;">
                <ul class="pagination mt-3 justify-content-center"></ul>
            </nav>
        </div>
    </div>
</div>

<script>
    (function(){
        var rowsPerPage = 6;
        var table = document.getElementById('produk-table');
        if (!table) return;
        var tbody = table.querySelector('tbody');
        var rows = Array.prototype.slice.call(tbody.querySelectorAll('tr'));
        var pagination = document.getElementById('produk-pagination');
        var pagerList = pagination ? pagination.querySelector('ul.pagination') : null;
        if (rows.length <= rowsPerPage) {
            if (pagination) pagination.style.display = 'none';
            return;
        }

        var pageCount = Math.ceil(rows.length / rowsPerPage);
        function showPage(page) {
            var start = (page - 1) * rowsPerPage;
            var end = start + rowsPerPage;
            rows.forEach(function(r, idx){
                r.style.display = (idx >= start && idx < end) ? '' : 'none';
            });
            // update active class
            if (pagerList) {
                Array.prototype.forEach.call(pagerList.children, function(li){ li.classList.remove('active'); });
                var activeLi = pagerList.querySelector('li[data-page="'+page+'"]');
                if (activeLi) activeLi.classList.add('active');
            }
        }

        // build pager
        for (var i=1;i<=pageCount;i++) {
            var li = document.createElement('li');
            li.className = 'page-item' + (i===1? ' active':'');
            li.setAttribute('data-page', i);
            var a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = i;
            (function(page){
                a.addEventListener('click', function(e){ e.preventDefault(); showPage(page); });
            })(i);
            li.appendChild(a);
            if (pagerList) pagerList.appendChild(li);
        }

        if (pagination) pagination.style.display = '';
        // show first page
        showPage(1);
    })();
</script>