<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index() {
		$username = $this->input->post('uname');
		$password = $this->input->post('pword');

		$this->user->login($username,$password);

		if ($this->user->login()) {
			$this->load->database();
			$this->db->order_by('Id','DESC');
			$data['entry'] = $this->db->get('acara')->result_array();
			$this->load->view('home',$data);
		}
		else
		{
			$this->load->view('login');
		}
	}

	public function filter($p1 = 'semua', $p2 = 'semua') {
		if ($this->user->login()) {
			$this->load->database();

			if ($p1 === 'sudah') {
				$this->db->where('Waktu <= NOW()');
				$data['param'] = 'Sudah Lewat';
			} elseif ($p1 === 'belum') {
				$this->db->where('Waktu > NOW()');
				$data['param'] = 'Akan Datang';
			}
			
			if ($p2 === 'masuk') {
				$this->db->where('Jenis','masuk');
				$data['param'] = 'Masuk';
			} elseif ($p2 === 'keluar') {
				$this->db->where('Jenis','keluar');
				$data['param'] = 'Keluar';
			}

			$this->db->order_by('Id','DESC');
			$data['entry'] = $this->db->get('acara')->result_array();
			$this->load->view('home',$data);
		}
		else
		{
			$this->load->view('login');
		}
	}

	public function request() {
		$this->load->database();
		$this->db->where('Waktu > NOW()')->order_by('Waktu', 'DESC');
		$output = $this->db->get('acara')->result_array();
		print_r(json_encode($output));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */