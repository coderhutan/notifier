<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {
	public function login($username = FALSE, $password = FALSE)
	{
		$this->load->library('session');
		$this->load->database();
		if ($username !== FALSE && $password !== FALSE)
		{
			$result = $this->db->get_where('PENGGUNA',array('username'=>$username, 'password'=>$password))->result_array();
			if (sizeof($result) == 1) {
				$this->session->set_userdata('user',$username);
				$this->session->set_userdata('role',$result[0]['Role']);
			}
		}
		return ( $this->session->userdata('user') !== FALSE );
	}

	public function logout()
	{
		$this->load->library('session');
		$this->session->unset_userdata('user');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */