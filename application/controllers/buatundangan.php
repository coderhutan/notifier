<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buatundangan extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	public function index()
	{
		if ($this->user->login()) {
			$post = $this->input->post();
			$data["posted"] = FALSE;
			if($post !== FALSE)
			{
				$folder = "files/";

				$tanggal = $post['tanggal'];
				$jam	 = $post['jam'];

				$spl = explode("/", $tanggal);
				$post['Waktu'] = sprintf("%s-%s-%s %s", $spl[2], $spl[1], $spl[0], $jam);
				unset($post['tanggal']);
				unset($post['jam']);

				$this->load->database();
				$this->db->insert('acara',$post);

				$this->db->select('Id');
				$this->db->order_by('Id','DESC');
				$result = $this->db->get('acara',1)->result_array();
				$id = $result[0]['Id'];

				$config =  array(
					  'file_name'		=> $id.'-'.$post['nama_acara'],
	                  'upload_path'     => "files/",
	                  'allowed_types'   => "jpg|png|jpeg|pdf|doc|docx",
	                  'overwrite'       => TRUE,
	                  'max_size'        => "4000KB",
	                );
				$this->load->library('upload',$config);
				
				if($this->upload->do_upload('berkas_asli'))
					;
				else
					echo $this->upload->display_errors();

				$this->db->where('Id',$id);
				$this->db->update('acara',array('Berkas_asli'=>$folder.($this->upload->data()['file_name'])));
				$data["posted"] = TRUE;
				$data["nama_acara"] = $post["nama_acara"];
				$data["dari"] = $post["dari"];
			}

			$this->load->view('buatundangan', $data);
		}
		else
		{
			$this->load->view('login');
		}
	}
}

/* End of file buatundangan.php */
/* Location: ./application/controllers/buatundangan.php */