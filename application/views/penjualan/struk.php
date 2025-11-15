<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk Penjualan #<?= $penjualan->PenjualanID; ?></title>
    <style>
        @page {
            size: 80mm auto;
            margin: 2mm;
        }

        body {
            width: 80mm;
            margin: 0 auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            padding: 0;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        hr {
            border: 0;
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 2px 0;
        }

        .total {
            font-weight: bold;
            font-size: 13px;
        }

        .footer {
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
            text-align: center;
        }

        @media print {

            html,
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body onload="startPrintFlow();">

    <div class="center">
        <strong>TOKO SALAAN JAYA</strong><br>
        Jl. semboro No. 45<br>
        Telp: 0812-3456-7890<br>
        ----------------------------------------
    </div>

    <table>
        <tr>
            <td>No</td>
            <td>: <?= $penjualan->PenjualanID; ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <!-- tampilkan tanggal dari DB (tanggal saja) dan waktu realtime lewat JS -->
            <td>: <?= !empty($penjualan->TanggalPenjualan) ? date('d/m/Y', strtotime($penjualan->TanggalPenjualan)) : date('d/m/Y'); ?> <span id="waktu-sekarang"></span></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>: <?= !empty($penjualan->NamaPelanggan) ? html_escape($penjualan->NamaPelanggan) : 'Umum'; ?></td>
        </tr>
    </table>

    <hr>

    <table>
        <thead>
            <tr>
                <th class="left">Produk</th>
                <th class="right">Harga</th>
                <th class="right">Qty</th>
                <th class="right">Sub</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $d): ?>
                <tr>
                    <td class="left"><?= html_escape($d->NamaProduk); ?></td>
                    <td class="right"><?= number_format($d->Harga, 0, ',', '.'); ?></td>
                    <td class="right"><?= (int)$d->JumlahProduk; ?></td>
                    <td class="right"><?= number_format($d->SubTotal, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <table>
        <tr>
            <td class="right total">TOTAL :</td>
            <td class="right total">Rp <?= number_format($penjualan->TotalHarga, 0, ',', '.'); ?></td>
        </tr>
    </table>

    <div class="footer">
        Terima Kasih Telah Berbelanja<br>
        --- Barang yang sudah dibeli tidak dapat dikembalikan ---
    </div>

    <script>
        function setRealtimeDate() {
            const now = new Date();
            // hanya menampilkan jam:menit realtime saat cetak
            const jam = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
            const el = document.getElementById('waktu-sekarang');
            if (el) el.textContent = jam;
        }

        function startPrintFlow() {
                // only auto-print when requested with ?autoprint=1
                var params = new URLSearchParams(window.location.search);
                var doAuto = params.get('autoprint') === '1' || params.get('autoprint') === 'true';
                setRealtimeDate();

                if (!doAuto) return; // do nothing if not requested

                // pada beberapa browser, onafterprint dipanggil saat dialog ditutup (apapun hasilnya)
                function afterPrint() {
                    // kembali ke halaman transaksi dan replace history agar struk tidak kembali
                    try {
                        window.location.replace('<?= base_url('penjualan'); ?>');
                    } catch (e) {
                        window.location.href = '<?= base_url('penjualan'); ?>';
                    }
                }

                if ('onafterprint' in window) {
                    window.onafterprint = afterPrint;
                }

                // panggil print setelah memberi waktu agar DOM termuat dan waktu realtime terlihat
                setTimeout(function() {
                    try {
                        window.print();
                    } catch (e) {
                        // kalau print gagal, langsung kembali
                        afterPrint();
                    }
                }, 200);

                // fallback: jika browser tidak mendukung onafterprint, arahkan kembali setelah 6 detik
                setTimeout(function() {
                    if (!('onafterprint' in window)) {
                        afterPrint();
                    }
                }, 6000);
        }
    </script>



</body>

</html>