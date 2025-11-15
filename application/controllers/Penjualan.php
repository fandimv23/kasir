<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Penjualan Controller
 *
 * @property Penjualan_model $Penjualan_model
 * @property Produk_model $Produk_model
 * @property Pelanggan_model $Pelanggan_model
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Loader $load
 */
class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penjualan_model');
        $this->load->model('Produk_model');
        $this->load->model('Pelanggan_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = 'Transaksi Penjualan';
        $data['produk'] = $this->Produk_model->get_all();

        // Ambil semua pelanggan kecuali "Umum"
        $data['pelanggan'] = array_filter(
            $this->Pelanggan_model->get_all(),
            function ($p) {
                return $p['NamaPelanggan'] !== 'Umum';
            }
        );

        $data['success'] = $this->session->flashdata('success');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('penjualan/form_penjualan', $data);
        $this->load->view('templates/footer');
    }

    public function simpan()
    {
        // terima kedua kemungkinan nama field dari form: 'jenis_pelanggan' (old) atau 'jenis_pembeli' (view saat ini)
        $jenis = $this->input->post('jenis_pelanggan');
        if (empty($jenis)) {
            $jenis = $this->input->post('jenis_pembeli');
        }
        $produk = $this->input->post('produk');
        $jumlah = $this->input->post('jumlah');

        if ($jenis === 'member') {
            // terima kedua kemungkinan nama field: 'pelanggan' atau 'pelanggan_id'
            $pelangganID = $this->input->post('pelanggan');
            if (empty($pelangganID)) {
                $pelangganID = $this->input->post('pelanggan_id');
            }
            // jika tetap kosong, fallback ke Umum (ID 1) — pastikan ID Umum sesuai di DB
        } else {
            $pelangganID = 1; // Ganti 1 dengan PelangganID "Umum" yang benar
        }

        $total = 0;
        foreach ($produk as $i => $p) {
            $harga = $this->Produk_model->get_harga($p);
            $subtotal = $harga * $jumlah[$i];
            $total += $subtotal;
        }

        // Simpan ke tabel penjualan
        $penjualanID = $this->Penjualan_model->insert_penjualan([
            'TanggalPenjualan' => date('Y-m-d'),
            'TotalHarga' => $total,
            'PelangganID' => $pelangganID
        ]);

        // Simpan detail penjualan
        foreach ($produk as $i => $p) {
            $harga = $this->Produk_model->get_harga($p);
            $subtotal = $harga * $jumlah[$i];

            $this->Penjualan_model->insert_detail([
                'PenjualanID' => $penjualanID,
                'ProdukID' => $p,
                'JumlahProduk' => $jumlah[$i],
                'SubTotal' => $subtotal
            ]);

            // Kurangi stok produk
            $this->Produk_model->kurangi_stok($p, $jumlah[$i]);
        }

        // jika request via AJAX, kembalikan JSON dengan ID penjualan
        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'penjualanID' => $penjualanID]);
            return;
        }

        $this->session->set_flashdata('success', 'Transaksi berhasil disimpan!');
        redirect('penjualan');
    }
}
