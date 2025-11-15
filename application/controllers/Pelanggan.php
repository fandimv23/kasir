<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Pelanggan controller
 *
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property Pelanggan_model $Pelanggan_model
 */

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model');
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
        $data['title'] = 'Data Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pelanggan/pelanggan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Pelanggan';

        if ($this->input->post()) {
            $insert = [
                'NamaPelanggan' => $this->input->post('NamaPelanggan'),
                'Alamat' => $this->input->post('Alamat'),
                'NomorTelepon' => $this->input->post('NomorTelepon')
            ];
            $this->Pelanggan_model->insert($insert);
            $this->session->set_flashdata('success', 'Data pelanggan berhasil ditambahkan!');
            redirect('pelanggan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pelanggan/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_by_id($id);

        if ($this->input->post()) {
            $update = [
                'NamaPelanggan' => $this->input->post('NamaPelanggan'),
                'Alamat' => $this->input->post('Alamat'),
                'NomorTelepon' => $this->input->post('NomorTelepon')
            ];
            $this->Pelanggan_model->update($id, $update);
            $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbarui!');
            redirect('pelanggan');
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('pelanggan/edit', $data);
        $this->load->view('templates/footer');
    }

    public function hapus($id)
    {
        $this->Pelanggan_model->delete($id);
        $this->session->set_flashdata('success', 'Data pelanggan berhasil dihapus!');
        redirect('pelanggan');
    }
}
