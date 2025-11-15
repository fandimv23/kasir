<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dashboard controller
 *
 * @property CI_Session $session
 * @property CI_Loader $load
 * @property Dashboard_model $dashboard_model
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        // jika belum login redirect ke halaman auth
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }
    }

    // method yang dipetakan ke /dashboard
    public function index()
    {
        $this->load->model('Dashboard_model');

        $data['title'] = 'Dashboard';
        $data['total_penjualan']   = $this->Dashboard_model->get_total_penjualan_hari_ini() ?? 0;
        $data['jumlah_transaksi']  = $this->Dashboard_model->get_jumlah_transaksi_hari_ini() ?? 0;
        $data['jumlah_barang']     = $this->Dashboard_model->get_jumlah_barang_aktif() ?? 0;
        $data['jumlah_pelanggan']  = $this->Dashboard_model->get_jumlah_pelanggan() ?? 0;
        // produk tidak aktif (stok 0)
        $data['produk_tidak_aktif'] = $this->Dashboard_model->get_produk_tidak_aktif();
        // produk aktif (stok > 0)
        $data['produk_aktif'] = $this->Dashboard_model->get_produk_aktif();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('templates/footer');
    }
}
