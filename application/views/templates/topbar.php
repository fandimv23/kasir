<div class="flex-grow-1">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <form class="form-inline">
        </form>
        <span class="navbar-text me-3">
            <?= $this->session->userdata('nama'); ?>
            <?php if ($this->session->userdata('level') == 'admin'): ?>
                <small class="text-danger fw-bold">(Admin)</small>
            <?php else: ?>
                <small class="text-success fw-bold">(Petugas)</small>
            <?php endif; ?>
        </span>

    </nav>