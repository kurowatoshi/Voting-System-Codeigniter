<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class User extends CI_Controller {

    function __construct(){
        parent::__construct();
        if (!$this->session->login) {
            redirect('login');
        }
    }

    private function header($data){
        $p = $this->db->query('SELECT password FROM voters WHERE id_voter='.$this->session->id)->row(); // Changed 'pemilih' to 'voters' and 'id_pemilih' to 'id_voter'
        if ($p->password == md5($this->session->username)) {
            $data['passdefault'] = TRUE;
        }
        else{
            $data['passdefault'] = FALSE;
        }

        $this->load->view('_template/_header', $data);
    }

    public function index(){
        $data['title'] = 'Voting System';
        $data['voting'] = $this->db->get('voting')->row();

        $cekvoting = $this->db->get('voting')->num_rows();
        if ($cekvoting > 0) {
            $data['voting'] = $this->db->get('voting')->row();
            $data['kandidat'] = $this->db->query('SELECT candidate_participation.id_voting, candidates.* FROM candidate_participation INNER JOIN candidates ON candidate_participation.id_voting='.$data['voting']->id_voting.' WHERE candidates.id_candidate=candidate_participation.id_candidate')->result(); // Changed 'ikut_kandidat' to 'candidate_participation' and 'kandidat' to 'candidates'
        }
        $cekpilih = $this->db->query('SELECT * FROM voter_participation WHERE id_voter='.$this->session->id)->num_rows(); // Changed 'ikut_voting' to 'voter_participation' and 'id_pemilih' to 'id_voter'
        ($cekpilih > 0) ? $data['pilih'] = TRUE : $data['pilih'] = FALSE;

        $this->header($data);
        $this->load->view('main');
        $this->load->view('_template/_footer');
    }

    function pilih($voting, $id){
        $c = $this->db->get_where('voting', ['id_voting' => $voting]);
        if ($c->num_rows() > 0) {
            $this->db->query('UPDATE candidate_participation SET points = points+1 WHERE id_candidate='.$id); // Changed 'ikut_kandidat' to 'candidate_participation' and 'poin' to 'points'
            $pilih = ['id_voting' => $voting, 'id_voter' => $this->session->id, 'timestamp' => Date('y-m-d H:i:s')]; // Changed 'id_pemilih' to 'id_voter' and 'waktu' to 'timestamp'
            $this->db->insert('voter_participation', $pilih); // Changed 'ikut_voting' to 'voter_participation'
            echo 1;
        }
    }

    function set_pass_id($id){
        $passLama = md5($this->input->post('passwdLama'));
        $passBaru = md5($this->input->post('passwdBaru'));
        $p = $this->db->query('SELECT password FROM voters WHERE id_voter='.$id)->row(); // Changed 'pemilih' to 'voters' and 'id_pemilih' to 'id_voter'
        if ($passLama == $p->password) {
            $this->db->query('UPDATE voters SET password="'.$passBaru.'" WHERE id_voter='.$id); // Changed 'pemilih' to 'voters' and 'id_pemilih' to 'id_voter'
            echo 1;
        }
        else{
            echo 0;
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
}
