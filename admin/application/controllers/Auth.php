<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Auth extends CI_Controller{
    function __construct(){
        parent::__construct();
        if ($this->session->login) {
            redirect('');
        }
    }

    public function index(){
        $data['title'] = 'Voting System';
        $this->load->view('_template_login/login', $data);
    }

    function actlogin(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $d = $this->db->get_where('admin', [
            'username' => $username,
            'password' => $password
        ]);
        if ($d->num_rows() > 0) {
            $admin = $d->row();
            $data = [
                'id' => $admin->id_admin,
                'name' => $admin->name,
                'username' => $admin->username,
                'last_login' => $admin->last_login,
                'login' => TRUE
            ];
            $this->session->set_userdata($data);
            $last = Date('Y-m-d H:i:s');
            $this->db->where([
                'id_admin' => $this->session->id
            ])->update('admin', [
                'last_login' => $last
            ]);
            redirect('');
        }
        else{
            $this->session->set_flashdata('gagal', 'Incorrect username or password');
            redirect('login');
        }
    }
}
