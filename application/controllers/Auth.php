<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Auth controller
 *
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Loader $load
 * @property User_model $user_model
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'session']);
        $this->load->model('User_model', 'user_model');
    }

    // tampilkan form login dan proses login POST
    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('dashboard');
        }

        // jika form disubmit
        if ($this->input->method() === 'post') {
            // deteksi apakah form mengirim 'username' atau 'email'
            $post_field = $this->input->post('username') !== null ? 'username' : ($this->input->post('email') !== null ? 'email' : 'username');

            // set rule sesuai nama field yang dikirim form (agar validasi tak gagal)
            $this->form_validation->set_rules($post_field, 'Username', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');

            if ($this->form_validation->run() == false) {
                $data['title'] = 'Login';
                $this->load->view('templates/header', $data);
                $this->load->view('auth/login', $data);
                $this->load->view('templates/footer');
            } else {
                // ambil nilai dari field yang dikirim (email diperlakukan sebagai username jika tidak ada kolom email)
                $login_value = $this->input->post($post_field, true);
                $password = $this->input->post('password', true);

                // cari user berdasarkan username (jika DB punya kolom email dan kamu mau pakai, buat method baru di model)
                $user = $this->user_model->get_by_username($login_value);

                if ($user && password_verify($password, $user['password'])) {
                    // set session dan redirect ke dashboard
                    $sess = [
                        'id_user' => $user['id_user'],
                        'username' => $user['username'],
                        'nama' => $user['nama'],
                        'level' => $user['level'],
                        'logged_in' => true
                    ];
                    $this->session->set_userdata($sess);
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Username atau password salah.</div>');
                    redirect('auth');
                }
            }
        } else {
            $data['title'] = 'Login';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer');
        }
    }

    // logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function registration()
    {
        if ($this->session->userdata('username')) {
            redirect('home');
        }

        // rules disesuaikan dengan kolom tabel: nama, username
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]', [
            'is_unique' => 'Username ini sudah terdaftar'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Ulangi Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Kasir Registration';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/registration', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                // default level: 'petugas' (sesuaikan bila mau 'admin')
                'level' => 'admin'
            ];

            $this->user_model->insert($data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akun berhasil dibuat. Silakan login.</div>');
            redirect('auth');
        }
    }
}
