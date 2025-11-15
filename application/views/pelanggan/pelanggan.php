<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <a href="<?= base_url('pelanggan/tambah'); ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Pelanggan
    </a>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table id="pelanggan-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($pelanggan as $p): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= isset($p['NamaPelanggan']) ? $p['NamaPelanggan'] : '-'; ?></td>
                            <td><?= isset($p['Alamat']) ? $p['Alamat'] : '-'; ?></td>
                            <td><?= isset($p['NomorTelepon']) ? $p['NomorTelepon'] : '-'; ?></td>
                            <td>
                                <a href="<?= base_url('pelanggan/edit/' . $p['PelangganID']); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('pelanggan/hapus/' . $p['PelangganID']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pelanggan ini?');"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>

            <!-- Pagination controls for pelanggan (client-side) -->
            <div class="d-flex justify-content-center mt-3">
                <nav aria-label="Pelanggan pagination">
                    <ul id="pelanggan-pagination" class="pagination pagination-sm mb-0"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const table = document.getElementById('pelanggan-table');
    if (!table) return;
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const perPage = 6;

    const pagination = document.getElementById('pelanggan-pagination');

    if (rows.length <= perPage) {
        // nothing to do
        return;
    }

    const totalPages = Math.ceil(rows.length / perPage);

    function showPage(page) {
        const start = (page - 1) * perPage;
        const end = start + perPage;
        rows.forEach((r, i) => {
            r.style.display = (i >= start && i < end) ? '' : 'none';
        });
        // update active class
        Array.from(pagination.querySelectorAll('li')).forEach(li => li.classList.remove('active'));
        const activeLi = pagination.querySelector('li[data-page="'+page+'"]');
        if (activeLi) activeLi.classList.add('active');
        // page marker removed (pagination centered)
    }

    // build page links
    for (let p = 1; p <= totalPages; p++) {
        const li = document.createElement('li');
        li.className = 'page-item' + (p === 1 ? ' active' : '');
        li.dataset.page = p;
        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = '#';
        a.textContent = p;
        a.addEventListener('click', function(e){
            e.preventDefault();
            showPage(p);
        });
        li.appendChild(a);
        pagination.appendChild(li);
    }

    // show first page
    showPage(1);
});
</script>