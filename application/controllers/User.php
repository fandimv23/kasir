<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User management controller
 * 
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property User_model $user_model
 */
class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);

        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Check if user has admin level
        if ($this->session->userdata('level') !== 'admin') {
            show_error('Anda tidak memiliki akses ke halaman ini.', 403, 'Akses Ditolak');
        }
    }
    public function index()
    {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->user_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]');
        $this->form_validation->set_rules('level', 'Level', 'required|trim|in_list[admin,kasir]', [
            'in_list' => 'Level harus admin atau kasir'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah User';

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/form_tambah', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama' => $this->input->post('nama', true),
                'username' => $this->input->post('username', true),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'level' => $this->input->post('level', true)
            ];

            $this->user_model->insert($data);
            $this->session->set_flashdata('message', 'User berhasil ditambahkan!');
            redirect('user');
        }
    }

    public function edit($id = null)
    {
        if (!$id) redirect('user');

        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            show_404();
            return;
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check[' . $id . ']');
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[4]');
        }
        $this->form_validation->set_rules('level', 'Level', 'required|trim|in_list[admin,kasir]', [
            'in_list' => 'Level harus admin atau kasir'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Edit User';
            $data['user'] = $user;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/form_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama' => $this->input->post('nama', true),
                'username' => $this->input->post('username', true),
                'level' => $this->input->post('level', true)
            ];

            // Only update password if new password is provided
            if ($this->input->post('password')) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->user_model->update($id, $data);
            $this->session->set_flashdata('message', 'User berhasil diupdate!');
            redirect('user');
        }
    }

    public function hapus($id = null)
    {
        if (!$id) redirect('user');

        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            show_404();
            return;
        }

        // Prevent deleting own account
        if ($user['id_user'] == $this->session->userdata('id_user')) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri!');
            redirect('user');
            return;
        }

        $this->user_model->delete($id);
        $this->session->set_flashdata('message', 'User berhasil dihapus!');
        redirect('user');
    }

    public function username_check($username, $user_id)
    {
        if ($this->user_model->is_username_exists($username, $user_id)) {
            $this->form_validation->set_message('username_check', 'Username sudah digunakan.');
            return false;
        }
        return true;
    }
}
