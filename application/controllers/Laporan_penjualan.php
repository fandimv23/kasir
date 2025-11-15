<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Laporan_penjualan Controller
 *
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property Laporan_penjualan_model $laporan_model
 */
class Laporan_penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Laporan_penjualan_model', 'laporan_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index()
    {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_selesai = $this->input->get('tanggal_selesai');

        $data['title'] = 'Laporan Penjualan';
        $data['laporan'] = $this->laporan_model->getLaporan($tanggal_mulai, $tanggal_selesai);
        $data['tanggal_mulai'] = $tanggal_mulai;
        $data['tanggal_selesai'] = $tanggal_selesai;
        $data['success'] = $this->session->flashdata('success');

        // hitung total seluruh TotalHarga pada hasil laporan (untuk ditampilkan di view)
        $total_harga = 0;
        if (!empty($data['laporan'])) {
            foreach ($data['laporan'] as $r) {
                $total_harga += (float) $r->TotalHarga;
            }
        }
        $data['total_harga'] = $total_harga;

        // attach product names for each penjualan so view can show Nama Produk
        if (!empty($data['laporan'])) {
            foreach ($data['laporan'] as $r) {
                $details = $this->laporan_model->getDetails($r->PenjualanID);
                $names = [];
                foreach ($details as $d) {
                    $qty = isset($d->JumlahProduk) ? (int)$d->JumlahProduk : (isset($d->Jumlah) ? (int)$d->Jumlah : 0);
                    $names[] = trim($d->NamaProduk) . ($qty > 0 ? ' (' . $qty . ')' : '');
                }
                $r->NamaProdukList = !empty($names) ? implode(', ', $names) : '';
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('penjualan/laporan_penjualan', $data);
        $this->load->view('templates/footer');
    }

    // new: export laporan penjualan ke CSV (Excel dapat membuka)
    public function export()
    {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_selesai = $this->input->get('tanggal_selesai');

        $laporan = $this->laporan_model->getLaporan($tanggal_mulai, $tanggal_selesai);

        // nama file
        $filename = 'laporan_penjualan_' . date('Ymd_His') . '.csv';

        // headers for CSV download (Excel will open CSV)
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        // BOM untuk memastikan Excel membaca UTF-8
        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');

        // header row (tambahkan kolom Nama Produk)
        fputcsv($out, ['No', 'No Penjualan', 'Tanggal', 'Nama Pelanggan', 'Nama Produk', 'Total Harga']);

        $no = 1;
        $total_harga = 0;
        foreach ($laporan as $row) {
            // tampilkan hanya tanggal tanpa jam
            $tanggal = !empty($row->TanggalPenjualan) ? date('Y-m-d', strtotime($row->TanggalPenjualan)) : '';
            // gunakan nilai numerik untuk TotalHarga agar Excel mengenali sebagai angka
            $total = (float) $row->TotalHarga;
            $total_harga += $total;
            // ambil detail produk dan gabungkan nama + qty
            $details = $this->laporan_model->getDetails($row->PenjualanID);
            $names = [];
            foreach ($details as $d) {
                $qty = isset($d->JumlahProduk) ? (int)$d->JumlahProduk : (isset($d->Jumlah) ? (int)$d->Jumlah : 0);
                $names[] = trim($d->NamaProduk) . ($qty > 0 ? ' (' . $qty . ')' : '');
            }
            $namaProdukList = !empty($names) ? implode(', ', $names) : '';

            fputcsv($out, [
                $no++,
                $row->PenjualanID,
                $tanggal,
                !empty($row->NamaPelanggan) ? $row->NamaPelanggan : 'Umum',
                $namaProdukList,
                $total
            ]);
        }

        // tambahkan baris total keseluruhan
        if ($no > 1) {
            // letakkan label di kolom pertama agar mudah terlihat, nilai total di kolom terakhir
            fputcsv($out, ['Total Seluruhnya', '', '', '', '', $total_harga]);
        }

        fclose($out);
        exit;
    }

    public function cetak($id = null)
    {
        if ($id === null) {
            redirect('laporan_penjualan');
            return;
        }

        // ambil header penjualan
        $penjualan = $this->laporan_model->getById($id);
        if (empty($penjualan)) {
            $this->session->set_flashdata('success', 'Data tidak ditemukan.');
            redirect('laporan_penjualan');
            return;
        }

        // ambil detail (produk)
        $detail = $this->laporan_model->getDetails($id);

        $data['penjualan'] = $penjualan;
        $data['detail'] = $detail;

        // view struk sederhana (target: buka di tab baru untuk cetak)
        $this->load->view('penjualan/struk', $data);
    }
    // Note: server-side PDF and combined struk functionality removed.
}
