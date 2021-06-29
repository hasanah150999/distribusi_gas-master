<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agen extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AgenModel');
		$this->load->model('RfidModel');
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function index()
	{
		// Empty the RFID Table first
		$this->AgenModel->delete_rfid();

		$this->data['namaProvinsi'] = $this->AgenModel->get_list_provinsi();
        $this->data['namaKota'] = [];
        $this->data['namaKecamatan'] = [];
		$this->data['namaKelurahan'] = [];
		$this->load->view('agen/v_distribusi', $this->data);
	}

	public function rfid() {
		$this->RfidModel->push($this->input->get('data_alat'));
	}

	public function ajax_graph() {
		echo json_encode($this->AgenModel->get_graph_distribusi_masyarakat());
	}

	public function kelola_pelanggan() {
		// Empty the RFID Table first
		$this->AgenModel->delete_rfid();

		$this->data['namaProvinsi'] = $this->AgenModel->get_list_provinsi();
        $this->data['namaKota'] = [];
        $this->data['namaKecamatan'] = [];
		$this->data['namaKelurahan'] = [];
		$this->load->view('agen/v_masyarakat', $this->data);
	}

	public function detail_pelanggan($id='') {
		if($id) {
			$pelanggan = $this->AgenModel->get_pelanggan_by_id($id);
			if((count($pelanggan)>0)&&($pelanggan !== false)){
				$res = array('status' => 'success' , 'message' => $pelanggan);
			} else {
				$res = array('status' => 'failed' , 'message' => 'Agen tidak ditemukan');
			}
		} else {
			$res = array('status' => 'failed' , 'message' => 'Agen tidak ditemukan');
		}

		echo json_encode($res);
	}

	public function kelola_profile() {
		$this->load->view('agen/v_profile');
	}

	public function get_rfid_daftar() {
		$rfid = $this->AgenModel->rfid_only_listener();
		echo json_encode($rfid);
	}

	public function get_rfid_distribusi() {
		$rfid = $this->AgenModel->rfid_listener();
		echo json_encode($rfid);
	}

	public function refresh_rfid() {
		$this->AgenModel->delete_rfid();
	}

	public function delete_pelanggan() {
		$request = $this->input->post();
		$res = array('status' => 'failed', 'message' => 'Gagal');
		if(isset($request['id'])) {
			$this->AgenModel->delete($request);
			$res = array('status' => 'success', 'message' => 'Dihapus');
		}
		echo json_encode($res);
	}

	public function store_pelanggan() {
		$request = $this->input->post();

		if(isset($request)) {
			if(isset($request['id'])) {
				$res = $this->AgenModel->store($request);
					$message['alert'] = 'success';
					$message['status'] = 'success';
					$message['message'] = 'Pelanggan ' . $request['nama'] . ' berhasil diubah';
			} else {
				$checkKtp = $this->AgenModel->get_pelanggan_by_nik($request['nik']);
				$checkRfid = $this->AgenModel->get_pelanggan_by_rfid($request['data_ktp']);

				if( ((count($checkKtp)>0) && ($checkKtp !== FALSE))  || ((count($checkRfid)>0) && ($checkRfid !== FALSE)) ) {
					$message['alert'] = 'danger';
					$message['status'] = 'failed';
					$message['message'] = 'Data RFID atau NIK sudah digunakan';
				} else {
					$res = $this->AgenModel->store($request);
					$message['alert'] = 'success';
					$message['status'] = 'success';
					$message['message'] = 'Pelanggan ' . $request['nama'] . ' berhasil ditambah';
				}
			}
		} else {
			$message['alert'] = 'danger';
			$message['status'] = 'failed';
			$message['message'] = 'Pelanggan ' . $request['nama'] . ' gagal ditambah';
		}

		echo json_encode($message);
	}

	public function update_profile() {
		
		$request = $this->input->post();

		if(isset($request)) {
			// if isset id is for edit, else for store
			if(isset($request['id'])) {
				$res = $this->AgenModel->store_profile($request);
				redirect('agen/profile');
			}
		}

		return false;
	}

	public function store_distribusi()
	{
		// $this->load->config('email');
		$config_email = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'sisgasudi@gmail.com',  // Email gmail
            'smtp_pass'   => 'admin123!',  // Password gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];

		$request = $this->input->post();
		
		if(isset($request)) {

			if($request['jumlah_beli'] < 5) {

				$checkStok = $this->AgenModel->get_stok_gas($request['id_agen']);

				if($checkStok >= $request['jumlah_beli']) {

					$checkPelanggan = $this->AgenModel->get_batas_distribusi($request['id_pelanggan']);
					$jumlahSekarang = $request['jumlah_beli'] + $checkPelanggan;
					$jumlahKuota = 4 - (int) $jumlahSekarang;					

					if(($checkPelanggan < 5) && ($jumlahSekarang < 5)) {
						$res = $this->AgenModel->store_pickup($request);
						$this->load->library('email', $config_email);
						$this->email->from('sisgasudi@gmail.com', 'Sistem Distribusi Gas');
						$this->email->to($request['email_beli']);
						$this->email->subject('Notifikasi Pemakaian Gas LPG 3kg Bersubsidi');
						$template_email = "Yth,<br>
										". $request['nama_beli'] ."<br>
										Di tempat<br>
										<br>
										
										Dengan ini kami sampaikan kepada bapak/ibu bahwa jumlah pembelian gas pada bulan ini sudah berjumlah
										: ". $jumlahSekarang ." <br>
										Sisa jumlah pembelian gas anda adalah : ". $jumlahKuota ."<br>
										Terima Kasih <br><br> 
										
										Sistem Distribusi Gas<br>";
						$this->email->message($template_email);

						if ($this->email->send()) {
							$message['message'] = 'Email berhasil terkirim';
						} else {
							$message['message'] = 'Email gagal terkirim';
						}
				
						if($request !== FALSE) {
							$message['alert'] = 'success';
							$message['status'] = 'success';
							$message['message'] = 'Pengambilan gas berhasil';
						} else {
							$message['alert'] = 'danger';
							$message['status'] = 'failed';
							$message['message'] =  'Gagal mengambil gas';
						}	
					} else {
						$message['alert'] = 'danger';
						$message['status'] = 'failed';
						$message['message'] =  'Pelanggan sudah mengambil lebih dari 4 tabung bulan ini';
					}
				} else {
					$message['alert'] = 'danger';
					$message['status'] = 'failed';
					$message['message'] =  'Jumlah pengambilan tidak bisa melebihi stok';
				}

			} else {
				$message['alert'] = 'danger';
				$message['status'] = 'failed';
				$message['message'] =  'Pembelian melebihi batas (4 Tabung)';
			}

		}  else {
			$message['alert'] = 'danger';
			$message['status'] = 'failed';
			$message['message'] = 'Gagal mengambil gas';
		}

		echo json_encode($message);
	}

	public function laporan() {
		$this->load->view('agen/v_laporan');
	}

	public function list_pelanggan() {
		echo json_encode($this->AgenModel->get_list_pelanggan(''));
	}

	public function list_distribusi() {
		echo json_encode($this->AgenModel->get_list_pengambilan(''));
	}

	public function list_provinsi() {
		$res = $this->AgenModel->get_list_provinsi();
		echo json_encode($res);
	}

	public function list_kab_kota($id='') {
		if($id) {
			$res = $this->AgenModel->get_list_kab_kota($id);
		} else {
			$res = '';
		}

		echo json_encode($res);
	}

	public function list_kecamatan($id='') {
		if($id) {
			$res = $this->AgenModel->get_list_kecamatan($id);
		} else {
			$res = '';
		}

		echo json_encode($res);
	}

	public function list_kel_des($id='') {
		if($id) {
			$res = $this->AgenModel->get_list_kel_des($id);
		} else {
			$res = '';
		}

		echo json_encode($res);
	}
}

/* End of file Controllername.php */
