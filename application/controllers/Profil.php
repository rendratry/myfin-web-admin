<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');

        $userId = $this->session->userdata('login_session')['tb_adminstaff'];
        $this->user = $this->admin->get('tb_adminstaff', ['id_adminstaff' => $userId]);
    }

    public function index()
    {
        $data['title'] = "Profile";
        $data['user'] = $this->user;
        $this->template->load('templates/dashboard', 'profile/user', $data);
    }

    private function _validasi()
    {
        $db = $this->admin->get('tb_adminstaff', ['id_adminstaff' => $this->input->post('id_user', true)]);
        $username = $this->input->post('username', true);
        $email = $this->input->post('email', true);

        $uniq_username = $db['nama_adminstaff'] == $username ? '' : '|is_unique[tb_adminstaff.nama_adminstaff]';
        $uniq_email = $db['email'] == $email ? '' : '|is_unique[tb_adminstaff.email]';

        $this->form_validation->set_rules('nama_adminstaff', 'nama_adminstaff', 'required|trim|alpha_numeric' . $uniq_username);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $uniq_email);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
    }

    private function _config()
    {
        $config['upload_path']      = "./assets/img/avatar";
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = '2048';

        $this->load->library('upload', $config);
    }

    public function setting()
    {
        $this->_validasi();
        $this->_config();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Profile";
            $data['tb_adminstaff'] = $this->user;
            $this->template->load('templates/dashboard', 'profile/setting', $data);
        } else {
            $input = $this->input->post(null, true);
            if (empty($_FILES['foto']['name'])) {
                $insert = $this->admin->update('tb_adminstaff', 'id_adminstaff', $input['id_adminstaff'], $input);
                if ($insert) {
                    set_pesan('perubahan berhasil disimpan.');
                } else {
                    set_pesan('perubahan tidak disimpan.');
                }
                redirect('profile/setting');
            } else {
                if ($this->upload->do_upload('foto') == false) {
                    echo $this->upload->display_errors();
                    die;
                } else {
                    if ($this->session->userdata('foto') != 'user.png') {
                        $old_image = FCPATH . 'assets/img/avatar/' . $this->session->userdata('foto');
                        if (!unlink($old_image)) {
                            set_pesan('gagal hapus foto lama.');
                            redirect('profile/setting');
                        }
                    }

                    $input['foto'] = $this->upload->data('file_name');
                    $update = $this->admin->update('tb_adminstaff', 'id_adminstaff', $input['id_adminstaff'], $input);
                    if ($update) {
                        set_pesan('perubahan berhasil disimpan.');
                    } else {
                        set_pesan('gagal menyimpan perubahan');
                    }
                    redirect('profile/setting');
                }
            }
        }
    }

    public function ubahpassword()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[3]|differs[password_lama]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Ubah Password";
            $this->template->load('templates/dashboard', 'profile/ubahpassword', $data);
        } else {
            $input = $this->input->post(null, true);
            if (password_verify($input['password_lama'], $this->session->userdata('password_adminstaff'))) {
                $new_pass = ['password_adminstaff' => password_hash($input['password_baru'], PASSWORD_DEFAULT)];
                $query = $this->admin->update('tb_adminstaff', 'id_adminstaff', $this->session->userdata('id_adminstaff'), $new_pass);

                if ($query) {
                    set_pesan('password berhasil diubah.');
                } else {
                    set_pesan('gagal ubah password', false);
                }
            } else {
                set_pesan('password lama salah.', false);
            }
            redirect('profile/ubahpassword');
        }
    }
}
