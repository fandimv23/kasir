<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Produk controller
 *
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property Produk_model $Produk_model
 */

class Produk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
            return;
        }
    }

    public function index()
    {
        $data['title'] = 'Data Produk';
        $data['produk'] = $this->Produk_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('produk/produk', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Produk';

        if ($this->input->post()) {
            $insert = [
                'NamaProduk' => $this->input->post('NamaProduk'),
                'Harga'      => $this->input->post('Harga'),
                'Stok'       => $this->input->post('Stok')
            ];
            $this->Produk_model->insert($insert);
            $this->session->set_flashdata('success', 'Data produk berhasil ditambahkan!');
            redirect('produk');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('produk/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Produk';
        $data['produk'] = $this->Produk_model->get_by_id($id);

        if ($this->input->post()) {
            $update = [
                'NamaProduk' => $this->input->post('NamaProduk'),
                'Harga'      => $this->input->post('Harga'),
                'Stok'       => $this->input->post('Stok')
            ];
            $this->Produk_model->update($id, $update);
            $this->session->set_flashdata('success', 'Data produk berhasil diperbarui!');
            redirect('produk');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('produk/edit', $data);
        $this->load->view('templates/footer');
    }

    public function hapus($id)
    {
        $this->Produk_model->delete($id);
        $this->session->set_flashdata('success', 'Data produk berhasil dihapus!');
        redirect('produk');
    }
}
