<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Hasil extends CI_Controller{
    
    public function index(){
        $data['title'] = 'Hasil Voting';
        $v = $this->db->query('SELECT * FROM voting');
        if ($v->num_rows() < 1) {
            $data['voting'] = '';
        }
        else{
            $data['voting'] = $v->row();
            $data['kandidat'] = $this->db->query('SELECT * FROM candidates JOIN candidate_participation ON candidate_participation.id_candidate=candidates.id_candidate WHERE id_voting='.$data["voting"]->id_voting)->result(); // Changed 'kandidat' to 'candidates' and 'ikut_kandidat' to 'candidate_participation'
        }

        $this->load->view('_hasil_voting/hasil', $data);
    }

}
