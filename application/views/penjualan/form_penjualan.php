<form id="form-penjualan" action="<?= base_url('penjualan/simpan'); ?>" method="post">
    <div class="card">
        <div class="card-header">
            <h6 class="font-weight-bold text-primary">Transaksi Penjualan</h6>
        </div>
        <div class="card-body">

            <!-- Pilihan Jenis Pembeli -->
            <div class="form-group">
                <label>Jenis Pembeli <span class="text-danger">*</span></label>
                <select id="jenis-pembeli" class="form-control" name="jenis_pembeli" required>
                    <option value="umum">Umum</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <!-- Dropdown Pelanggan (muncul hanya jika Member) -->
            <div class="form-group" id="member-container" style="display: none;">
                <label>Nama Pelanggan <span class="text-danger">*</span></label>
                <select class="form-control" id="pelanggan" name="pelanggan_id">
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php foreach ($pelanggan as $p): ?>
                        <option value="<?= $p['PelangganID']; ?>"><?= $p['NamaPelanggan']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr>

            <!-- Detail Produk -->
            <div class="card">
                <div class="card-header">
                    <h6 class="font-weight-bold text-primary">Detail Produk</h6>
                </div>
                <div class="card-body">
                    <?php
                    // prepare list of out-of-stock product names (make available to JS)
                    $out_of_stock = array_filter($produk, function($it){ return isset($it['Stok']) && (int)$it['Stok'] === 0; });
                    $names = !empty($out_of_stock) ? array_map(function($it){ return $it['NamaProduk']; }, $out_of_stock) : [];
                    ?>
                    <script>var OUT_OF_STOCK_NAMES = <?= json_encode($names); ?>;</script>

                    <!-- On-submit alert (hidden until needed) -->
                    <div class="alert alert-danger d-none" id="alert-submit-error"></div>
                    <div id="produk-container">
                        <div class="form-row produk-item mb-3">
                            <div class="col-md-4">
                                <label>Produk <span class="text-danger">*</span></label>
                                <select class="form-control produk" name="produk[]" required>
                                    <option value="" data-harga="">-- Pilih Produk --</option>
                                    <?php foreach ($produk as $item): ?>
                                        <?php $stok = isset($item['Stok']) ? (int)$item['Stok'] : 0; $isEmpty = $stok === 0; ?>
                                        <option value="<?= $item['ProdukID']; ?>" data-harga="<?= $item['Harga']; ?>" data-stok="<?= $stok; ?>" <?= $isEmpty ? 'disabled' : ''; ?>>
                                            <?= $item['NamaProduk']; ?><?= $isEmpty ? ' - Habis' : ' (Stok: ' . $stok . ')'; ?> - Rp <?= number_format($item['Harga'], 0, ',', '.'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control jumlah" name="jumlah[]" value="1" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label>Harga</label>
                                <input type="text" class="form-control harga" name="harga[]" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>Subtotal</label>
                                <input type="text" class="form-control subtotal" name="subtotal[]" readonly>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-hapus">X</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="tambah-produk" class="btn btn-primary btn-sm mt-2">
                        + Tambah Produk
                    </button>

                    <div class="text-right mt-4">
                        <h5><strong>Total Harga:</strong></h5>
                        <input type="text" id="total-harga" name="total_harga_tampil" class="form-control text-right" readonly>
                        <input type="hidden" id="total-harga-real" name="total_harga">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="text-right mt-4">
                <button type="submit" class="btn btn-success">💾 Simpan Transaksi</button>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const produkContainer = document.getElementById("produk-container");
        const tambahBtn = document.getElementById("tambah-produk");
        const jenisPembeli = document.getElementById("jenis-pembeli");
        const memberContainer = document.getElementById("member-container");

        // Tampilkan dropdown pelanggan jika "Member" dipilih
        jenisPembeli.addEventListener("change", function() {
            memberContainer.style.display = this.value === "member" ? "block" : "none";
            if (this.value !== "member") document.getElementById("pelanggan").value = "";
        });

        // pelanggan search: filter select options to names starting with typed letters
        var pelangganSearch = document.getElementById('pelanggan-search');
        var pelangganAutoToggle = document.getElementById('pelanggan-autocomplete');
        var pelangganSelect = document.getElementById('pelanggan');

        function rebuildPelangganOptions(query) {
            var q = (query || '').trim().toLowerCase();
            if (!pelangganSelect) return [];
            pelangganSelect.innerHTML = '';
            var defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '-- Pilih Pelanggan --';
            pelangganSelect.appendChild(defaultOpt);

            var matched = PELANGGAN_OPTIONS.filter(function(p){
                if (!p || !p.NamaPelanggan) return false;
                if (!q) return true; // if empty query, show all
                return p.NamaPelanggan.toLowerCase().startsWith(q);
            });

            matched.forEach(function(p){
                var o = document.createElement('option');
                o.value = p.PelangganID;
                o.textContent = p.NamaPelanggan;
                pelangganSelect.appendChild(o);
            });

            return matched;
        }

        if (pelangganSearch && typeof PELANGGAN_OPTIONS !== 'undefined') {
            pelangganSearch.addEventListener('input', function(){
                var matched = rebuildPelangganOptions(this.value);
                // focus select so user can open it; auto-select if only one match
                if (pelangganSelect) {
                    pelangganSelect.focus();
                    if (matched.length === 1) {
                        pelangganSelect.selectedIndex = 1; // first option is placeholder
                    }
                }
            });
        }

        // (Autocomplete / Select2 removed) simple search by starting letters remains

        function formatRupiah(angka) {
            return "Rp " + angka.toLocaleString("id-ID");
        }

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll(".subtotal").forEach(function(el) {
                const val = el.value.replace(/[^0-9]/g, "");
                total += parseFloat(val) || 0;
            });
            document.getElementById("total-harga").value = formatRupiah(total);
            document.getElementById("total-harga-real").value = total;
        }

        function updateHargaSubtotal(item) {
            const select = item.querySelector(".produk");
            const jumlahInput = item.querySelector(".jumlah");
            const hargaInput = item.querySelector(".harga");
            const subtotalInput = item.querySelector(".subtotal");

            const harga = parseFloat(select.selectedOptions[0].dataset.harga || 0);
            const jumlah = parseInt(jumlahInput.value) || 0;
            const subtotal = harga * jumlah;

            hargaInput.value = harga ? formatRupiah(harga) : "";
            subtotalInput.value = subtotal ? formatRupiah(subtotal) : "";

            hitungTotal();
        }

        produkContainer.addEventListener("change", function(e) {
            if (e.target.classList.contains("produk") || e.target.classList.contains("jumlah")) {
                const item = e.target.closest(".produk-item");
                updateHargaSubtotal(item);
            }
        });

        // helper: refresh labels & delete-button visibility per row
        function refreshRowControls() {
            const rows = produkContainer.querySelectorAll('.produk-item');
            rows.forEach((row, idx) => {
                // show labels only for first row
                row.querySelectorAll('label').forEach(lbl => {
                    lbl.style.display = idx === 0 ? '' : 'none';
                });
                // delete button hidden for first row
                const del = row.querySelector('.btn-hapus');
                if (del) del.style.display = idx === 0 ? 'none' : '';
            });
        }

        // add new product row
        if (tambahBtn) {
            tambahBtn.addEventListener("click", function() {
                const template = produkContainer.querySelector('.produk-item');
                if (!template) return;
                const itemBaru = template.cloneNode(true);
                // clear inputs in clone
                itemBaru.querySelectorAll('input').forEach((input) => input.value = '');
                itemBaru.querySelectorAll('select').forEach((sel) => sel.selectedIndex = 0);
                produkContainer.appendChild(itemBaru);
                refreshRowControls();
            });
        }

        // handle remove
        produkContainer.addEventListener("click", function(e) {
            if (e.target.classList.contains("btn-hapus")) {
                const rows = produkContainer.querySelectorAll(".produk-item");
                if (rows.length > 1) {
                    e.target.closest(".produk-item").remove();
                    hitungTotal();
                    refreshRowControls();
                }
            }
        });

        // initial refresh to hide delete on first row and labels on others
        refreshRowControls();
    });
</script>

<script>
    // intercept form submit to save via AJAX and open struk with auto-print
    (function(){
        var form = document.getElementById('form-penjualan');
        if (!form) return;
        form.addEventListener('submit', function(e){
            // before submit, ensure no selected product has stok 0 or jumlah > stok
            var selects = form.querySelectorAll('.produk');
            var submitAlert = document.getElementById('alert-submit-error');
            if (submitAlert) {
                submitAlert.classList.add('d-none');
                submitAlert.textContent = '';
            }

            for (var s = 0; s < selects.length; s++) {
                var sel = selects[s];
                var opt = sel.selectedOptions[0];
                if (!opt) continue;
                var stok = parseInt(opt.dataset.stok || 0);
                var item = sel.closest('.produk-item');
                var jumlahInput = item ? item.querySelector('.jumlah') : null;
                var jumlah = jumlahInput ? parseInt(jumlahInput.value) || 0 : 0;

                if (stok === 0 || jumlah > stok) {
                    e.preventDefault();
                    if (submitAlert) {
                        if (typeof OUT_OF_STOCK_NAMES !== 'undefined' && Array.isArray(OUT_OF_STOCK_NAMES) && OUT_OF_STOCK_NAMES.length) {
                            submitAlert.innerHTML = 'Produk stoknya habis: ' + OUT_OF_STOCK_NAMES.join(', ') + '. Produk tersebut tidak dapat ditransaksikan.';
                        } else {
                            submitAlert.textContent = 'Produk stok nya habis dan tidak bisa transaksi';
                        }
                        submitAlert.classList.remove('d-none');
                        submitAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        alert('Produk stok nya habis dan tidak bisa transaksi');
                    }
                    return;
                }
            }
            // If fetch not available, allow normal submit
            if (!window.fetch) return;
            e.preventDefault();
            var fd = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: fd,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function(res){
                // try to parse JSON; if not JSON, fallback to reload
                return res.json().catch(function(){ return null; });
            }).then(function(json){
                if (json && json.success && json.penjualanID) {
                    // buka struk di tab baru dan minta auto-print
                    var url = '<?= base_url('laporan_penjualan/cetak/'); ?>' + json.penjualanID + '?autoprint=1';
                    var win = window.open(url, '_blank');
                    if (win) win.focus();
                    // reset form
                    form.reset();
                    var memberContainer = document.getElementById('member-container');
                    if (memberContainer) memberContainer.style.display = 'none';
                    alert('Transaksi disimpan. Struk dibuka di tab baru.');
                } else {
                    // fallback: reload page
                    window.location.reload();
                }
            }).catch(function(err){
                console.error(err);
                // fallback: normal submit
                form.submit();
            });
        });
    })();
</script>