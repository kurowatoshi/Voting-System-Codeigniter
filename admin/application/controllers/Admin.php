<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');

class Admin extends CI_Controller {

    function __construct(){
        parent::__construct();
        if (!$this->session->login) {
            redirect('login');
        }
        $this->load->model('m_admin');
    }

    private function header($data){
        $data['jmlkandidat'] = $this->m_admin->lihat('candidates')->num_rows();
        $data['jmlpemilih'] = $this->m_admin->lihat('voters')->num_rows();
        $cpass = $this->db->select('password')->get_where('admin', ['id_admin' => $this->session->id])->row();
        if ($cpass->password == md5($this->session->username)) {
            $data['passdefault'] = TRUE;
        }
        else{
            $data['passdefault'] = FALSE;
        }
        $this->load->view('_template/_header', $data);
    }

    public function index(){
        $data['title'] = 'Voting System';

        $this->header($data);
        $this->load->view('main');
        $this->load->view('_template/_footer');
    }

    public function voting(){
        $data['title'] = 'Voting';
        $data['listkandidat'] = $this->db->select('id_candidate, candidate_name')->get('candidates')->result();
        $data['cekvoting'] = $this->m_admin->lihat('voting')->num_rows();
        if ($data['cekvoting'] > 0) {
            $data['voting'] = $this->m_admin->lihat('voting')->row();
            $data['kandidat'] = $this->db->select('candidates.*, candidate_participation.id_voting, candidate_participation.points')
                                                                     ->where('candidates.id_candidate = candidate_participation.id_candidate')
                                                                     ->join('candidates', 'candidate_participation.id_voting = '.$data['voting']->id_voting, 'inner')
                                                                     ->get('candidate_participation')->result();

            $data['sudah_memilih'] = $this->db->query('SELECT voters.id_voter, voters.name, voter_participation.timestamp FROM voters JOIN voter_participation ON voters.id_voter=voter_participation.id_voter JOIN voting ON voter_participation.id_voting=voting.id_voting WHERE voters.id_voter IN (SELECT voter_participation.id_voter FROM voter_participation)')->result();

            $data['belum_memilih'] = $this->db->query('SELECT id_voter, name FROM voters WHERE id_voter NOT IN (SELECT id_voter FROM voter_participation)')->result();
        }

        $this->header($data);
        $this->load->view('voting');
        $this->load->view('_template/_footer');
    }
    function tambah_voting(){
        $voting = $this->input->post('voting');
        $kandidat = $this->input->post('kandidat[]');
        $data = ['voting_name' => $voting];
        $this->m_admin->tambah('voting', $data);
        $id_voting = $this->db->insert_id();

        foreach ($kandidat as $k) {
            $candidate_participation = ['id_voting' => $id_voting, 'id_candidate' => $k];
            $this->m_admin->tambah('candidate_participation', $candidate_participation);
        }

        $this->session->set_flashdata('tambah', 'Voting baru telah ditambahkan');
        redirect($this->agent->referrer());
    }
    function edit_voting($id){
        $voting = $this->input->post('voting');
        $data = ['voting_name' => $voting];
        $this->m_admin->ubah(['id_voting' => $id], 'voting', $data);
        $this->session->set_flashdata('ubah', 'Perubahan berhasil disimpan');
        redirect($this->agent->referrer());
    }
    function hapus_voting($id){
        $this->db->where(['id_voting' => $id]);
        $this->db->delete('voting');
        redirect('voting');
    }

    public function candidate(){
        $data['title'] = 'Candidate';
        $data['kandidat'] = $this->db->query('SELECT *, candidates.id_candidate as id FROM candidates LEFT JOIN candidate_participation ON candidate_participation.id_candidate=candidates.id_candidate')->result();

        $this->header($data);
        $this->load->view('candidate');
        $this->load->view('_template/_footer');
    }
    function data_candidate(){
        $data = $this->m_admin->lihat('candidates')->result();
        echo json_encode($data);
    }
    function get_candidate($id){
        $d = $this->db->get_where('candidates', ['id_candidate' => $id])->row();
        echo json_encode($d);
    }
    function tambah_candidate(){
        $nama = $this->input->post('name');
        $ket = $this->input->post('ket');
        $foto = $_FILES['foto'];

        $config['upload_path'] = '../assets/img/kandidat';
        $config['allowed_types'] = 'jpg|png|gif';
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        if (!empty($foto['name'])) {
            if (!$this->upload->do_upload('foto')) {
                $data['error'] = $this->upload->display_errors();
                $this->session->set_flashdata('error', $data['error'].' '.$config['upload_path']);
                redirect('candidate');
            }
            else{
                $data = [
                    'candidate_name' => $nama,
                    'description' => $ket,
                    'photo' => $this->upload->data('file_name')
                ];
                $this->m_admin->tambah('candidates', $data);
                $this->session->set_flashdata('tambah', 'kandidat berhasil ditambahkan');
                redirect('candidate');
            }
        }
        else{
            $this->session->set_flashdata('error', 'Foto belum dipilih');
            redirect('candidate');
        }

    }
    function edit_candidate(){
        $id = $this->input->post('id_candidate');
        $nama = $this->input->post('name');
        $ket = $this->input->post('ket');
        $foto = $_FILES['foto'];

        if (empty($foto['name'])) {
            $data = ['candidate_name' => $nama, 'description' => $ket];
            $this->m_admin->ubah(['id_candidate' => $id], 'candidates', $data);
            $this->session->set_flashdata('edit', 'Data berhasil diubah');
            redirect($this->agent->referrer());
        }
        else{
            $config['upload_path'] = './../assets/img/kandidat';
            $config['allowed_types'] = 'jpg|png|gif';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto')) {
                $data['error'] = $this->upload->display_errors();
                $this->session->set_flashdata('error', 'Periksa file foto!');
                redirect($this->agent->referrer());
            }
            else{
                $f = $this->db->select('photo')->get_where('candidates', ['id_candidate' => $id])->row();
                unlink('./../assets/img/kandidat/'.$f->photo);
                $data = [
                    'candidate_name' => $nama,
                    'description' => $ket,
                    'photo' => $this->upload->data('file_name')
                ];
                $this->m_admin->ubah(['id_candidate' => $id], 'candidates', $data);
                $this->session->set_flashdata('edit', 'Data berhasil diubah');
                redirect($this->agent->referrer());
            }
        }
    }
    function hapus_candidate($id){
        $d = $this->db->select('photo')->get_where('candidates', ['id_candidate' => $id])->row();
        unlink('./../assets/img/kandidat/'.$d->photo);
        $this->m_admin->hapus(['id_candidate' => $id], 'candidates');
        $this->session->set_flashdata('hapus', 'Kandidat berhasil dihapus');
        redirect($this->agent->referrer());
    }

    public function voter(){
        $data['title'] = 'Voter List';

        $this->header($data);
        $this->load->view('voter');
        $this->load->view('_template/_footer');
    }
    function data_voter(){
        $data = $this->m_admin->lihat('voters')->result();
        echo json_encode($data);
    }
    function get_voter($id){
        $d = $this->db->select('id_voter, name, username')->get_where('voters', ['id_voter' => $id])->row();
        echo json_encode($d);
    }
    function tambah_voter(){
        $nama = $this->input->post('name');
        $username = $this->input->post('username');
        $password = md5($this->input->post('username'));
        $data = ['name' => $nama, 'username' => $username, 'password' => $password];
        $this->m_admin->tambah('voters', $data);
    }
    function edit_voter($id){
        $nama = $this->input->post('name');
        $username = $this->input->post('username');
        $where = ['id_voter' => $id];
        $data = ['name' => $nama, 'username' => $username];
        $this->m_admin->ubah($where, 'voters', $data);
    }
    function reset_pass_voter($id){
        $p = $this->db->select('username')->get_where('voters', ['id_voter' => $id])->row();
        $pass = md5($p->username);
        $this->db->query('UPDATE voters SET password="'.$pass.'" WHERE id_voter='.$id);
    }
    function hapus_voter($id){
        $this->db->query('DELETE FROM voters WHERE id_voter='.$id);
    }

    public function setting(){
        $data['title'] = 'Settings';

        $this->header($data);
        $this->load->view('setting');
        $this->load->view('_template/_footer');
    }
    function data_admin(){
        $d = $this->m_admin->lihat('admin')->result();
        echo json_encode($d);
    }
    function get_admin($id){
        $d = $this->db->select('id_admin, name, username')->get_where('admin', ['id_admin' => $id])->row();
        echo json_encode($d);
    }
    function tambah_admin(){
		$nama = $this->input->post('name');
		$username = $this->input->post('username');
		$password = md5($this->input->post('username'));
		$last = Date('Y-m-d H:i:s');
		$data = [
			'name' => $nama,
			'username' => $username,
			'password' => $password,
			'last_login' => $last
		];
		$this->m_admin->tambah('admin', $data);
	}
    function reset_pass_admin($id){
        $d = $this->db->select('username')->get_where('admin', ['id_admin' => $id])->row();
        $pass = md5($d->username);
        $this->m_admin->ubah(['id_admin' => $id], 'admin', ['password' => $pass]);
    }
    function edit_admin($id){
        $nama = $this->input->post('name');
        $username = $this->input->post('username');
        $where = ['id_admin' => $id];
        $data = ['name' => $nama, 'username' => $username];
        $this->m_admin->ubah($where, 'admin', $data);
    }
    function hapus_admin($id){
        $this->db->query('DELETE FROM admin WHERE id_admin='.$id);
    }

    function ganti_user_admin($id){
        $nama = $this->input->post('name');
        $user = $this->input->post('username');
        $data = ['name' => $nama, 'username' => $user];
        $this->m_admin->ubah(['id_admin' => $id], 'admin', $data);
        $this->session->unset_userdata(['name', 'username']);
        $this->session->set_userdata($data);
        $this->session->set_flashdata('ganti_user', 'Nama/Username berhasil diubah');
        redirect($this->agent->referrer());
    }
    function ganti_pass_admin($id){
        $d = $this->db->select('password')->get_where('admin', ['id_admin' => $id])->row();
        $pass = md5($this->input->post('passwdlama'));
        $newpass = md5($this->input->post('passwdbaru'));

        if ($d->password == $pass) {
            $data = ['password' => $newpass];
            $this->m_admin->ubah(['id_admin' => $id], 'admin', $data);
            $this->session->set_flashdata('ganti_pass', 'Password berhasil diubah');
            redirect('pengaturan');
        }
        else{
            $this->session->set_flashdata('error_pass', 'Password lama tidak sama');
            redirect('pengaturan');
        }
    }

    //Reset aplikasi
    function reset(){
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->truncate('candidate_participation');
        $this->db->truncate('voter_participation');
        $this->db->truncate('candidates');
        $this->db->truncate('voters');
        $this->db->truncate('voting');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        delete_files('./../assets/img/kandidat/');
        redirect('');
    }
    //Logout
    function logout(){
        $last = Date('Y-m-d H:i:s');
        $this->m_admin->ubah(['id_admin' => $this->session->id], 'admin', ['last_login' => $last]);
        $this->session->sess_destroy();
        redirect('login');
    }
}
