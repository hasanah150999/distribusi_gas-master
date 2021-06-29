<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('RfidModel');
	}

	public function response($data) 
	{
		$this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
        
        exit();
	}

	public function push_rfid()
	{
		return $this->response(
						$this->RfidModel->push($this->input->get('data_alat'))
					);
	}

	public function put_rfid()
	{
		$data = $this->input->get('data_alat');
		$write ="<?php $" . "rfid_data='" . $data . "'; " . "echo $" . "rfid_data;" . " ?>";
		if (!write_file('./assets/RfidText.php', $write)) {
	        echo 'RFID gagal ditulis';
		} else {
	        echo 'RFID berhasil ditulis!';
		}
	}
}
