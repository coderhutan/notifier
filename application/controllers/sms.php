<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {
	public function index()
	{
		date_default_timezone_set('Asia/Jakarta');

		require "sms/Services/Twilio.php";
 
	    // Step 2: set our AccountSid and AuthToken from www.twilio.com/user/account
	    $AccountSid = "XXXXXXXXXX";
	    $AuthToken = "XXXXXXXXX";
	 
	    // Step 3: instantiate a new Twilio Rest Client
	    $client = new Services_Twilio($AccountSid, $AuthToken);

		$this->load->database();
		$tabel = $this->db->get('acara')->result_array();

		foreach ($tabel as $row) {
			if ($this->seminggu(new DateTime($row['Waktu']),$row['Dimunculkan'])) {
				$this->sendsms($client,$row['Nama_acara'],$row['Tempat'],$row['Waktu']);
				$newval = $row['Dimunculkan'] | (1 << 2);
				$this->db->where('Id', $row['Id']);
				$this->db->update('acara',array('Dimunculkan'=>$newval));
			}

			if ($this->sehari(new DateTime($row['Waktu']),$row['Dimunculkan'])) {
				$this->sendsms($client,$row['Nama_acara'],$row['Tempat'],$row['Waktu']);
				$newval = $row['Dimunculkan'] | (1 << 1);
				$this->db->where('Id', $row['Id']);
				$this->db->update('acara',array('Dimunculkan'=>$newval));
			}

			if ($this->sejam(new DateTime($row['Waktu']),$row['Dimunculkan'])) {
				$this->sendsms($client,$row['Nama_acara'],$row['Tempat'],$row['Waktu']);
				$newval = $row['Dimunculkan'] | (1 << 0);
				$this->db->where('Id', $row['Id']);
				$this->db->update('acara',array('Dimunculkan'=>$newval));
			}
		}
	}

	private function seminggu($waktu, $dimunculkan)
	{
		$today = new DateTime();
		$today->setTime(0,0);
		$selisih = $today->diff($waktu)->format("%r%a");
		return ( (0 < $selisih && $selisih <= 7) && (($dimunculkan & (1 << 2)) == 0) );
	}

	private function sehari($waktu, $dimunculkan)
	{
		$today = new DateTime();
		$selisih = $today->diff($waktu)->h;
		echo "selisih jam: $selisih - ";
		return ( ($waktu > $today) && ($waktu->format("Y-m-d") == $today->format("Y-m-d")) && (0 < $selisih && $selisih <= 23) && (($dimunculkan & (1 << 1)) == 0) );
	}

	private function sejam($waktu, $dimunculkan)
	{
		$today = new DateTime();
		$selisih = $today->diff($waktu)->i;
		echo "selisih menit: $selisih<br>";
		return ( ($waktu > $today) && ($waktu->format("Y-m-d") == $today->format("Y-m-d")) && ($today->diff($waktu)->h == 0) && (0 <= $selisih && $selisih <= 59) && (($dimunculkan & (1 << 0)) == 0) );
	}

	private function sendsms($client, $nama_acara, $tempat, $waktu)
	{
	    // Step 4: make an array of people we know, to send them a message. 
	    // Feel free to change/add your own phone number and name here.
	    $people = array(
	        "+6289652567808" => "Irfan"
	        #"+6281288508877" => "Reza",
	        #"+6281807540415" => "Fitri",
	    );
        #"+6281317404473"  => "Sari"
	 
	    // Step 5: Loop over all our friends. $number is a phone number above, and 
	    // $name is the name next to it
	    foreach ($people as $number => $name) {
	 
	        $sms = $client->account->messages->sendMessage(
	 
	        // Step 6: Change the 'From' number below to be a valid Twilio number 
	        // that you've purchased, or the (deprecated) Sandbox number
	            "+15414445026", 
	 
	            // the number we are sending to - Any phone number
	            $number,
	 
	            // the sms body
	            "Halo $name. Ada acara $nama_acara di $tempat. Waktunya $waktu. Jangan lupa ya, :). [Dikirim melalui sistem notifikasi humas]."
	        );
	 
	        // Display a confirmation message on the screen
	        echo "Sent message to $name<br>";
	        echo "Text:<br>"."Halo $name. Ada acara $nama_acara di $tempat, waktunya $waktu. Jangan lupa ya. :)"."<br>";
	    }
	}
}

/* End of file sms.php */
/* Location: ./application/controllers/sms.php */
