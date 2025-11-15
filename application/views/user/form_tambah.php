<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah User</h6>
                </div>
                <div class="card-body">
                    <?= form_open('user/tambah') ?>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control <?= form_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= set_value('nama') ?>">
                        <?= form_error('nama', '<div class="invalid-feedback">', '</div>') ?>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= set_value('username') ?>">
                        <?= form_error('username', '<div class="invalid-feedback">', '</div>') ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" id="password" name="password">
                        <?= form_error('password', '<div class="invalid-feedback">', '</div>') ?>
                    </div>

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control <?= form_error('level') ? 'is-invalid' : '' ?>" id="level" name="level">
                            <option value="">Pilih Level</option>
                            <option value="admin" <?= set_select('level', 'admin') ?>>Admin</option>
                            <option value="kasir" <?= set_select('level', 'kasir') ?>>Kasir</option>
                        </select>
                        <?= form_error('level', '<div class="invalid-feedback">', '</div>') ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('user') ?>" class="btn btn-secondary">Kembali</a>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>