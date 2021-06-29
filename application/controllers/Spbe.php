<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spbe extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('SpbeModel');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function index()
	{
		/** 
		* $write = "<?php $" . "rfid_data=''; " . "echo $" . "rfid_data;" . " ?>";
		* write_file('./assets/RfidText.php', $write);
		*/

		// Empty the RFID Table first
		$this->SpbeModel->delete_rfid();
		$this->load->view('spbe/v_index');
	}

	// Function Distribusi
	public function distribusi()
	{
		$this->load->view('spbe/v_distribusi');
	}

	public function ajax_graph() {
		echo json_encode($this->SpbeModel->get_graph_distribusi_agen());
	}

	public function monitoring()
	{
		$this->data['namaAgen'] = $this->SpbeModel->get_agen();
		$this->load->view('spbe/v_monitoring', $this->data);
	}

	public function list_monitoing() {
		echo json_encode($this->SpbeModel->get_list_monitoring(''));
	}

	public function list_distribusi() {
		echo json_encode($this->SpbeModel->get_list_distribusi(''));
	}

	public function list_detail_distribusi($id="") {
		echo json_encode($this->SpbeModel->get_list_detail_distribusi($id));
	}

	public function distribusi_agen() {
		$this->load->view('spbe/v_distribusi_masyarakat');
	}

	public function detail_distribusi($id="") {
		if($id){
			$this->data['id_selected'] = $id;
			$this->data['agen'] = $this->SpbeModel->get_agen_by_id($id);
			$this->load->view('spbe/v_detail_distribusi',$this->data);
		}else{
			redirect('spbe/distribusi');
		}
	}
	
	public function laporan()
	{
		$this->load->view('spbe/v_laporan');
	}

	public function list_laporan(){
		$where = " ";
		$sql_table = "SELECT da.id_distribusi_agen as id, CONCAT('AG-', ag.no_reg) AS no_reg, ag.nama, da.jumlah_tabung, DATE(da.tanggal_pengambilan) AS tanggal_pengambilan, da.status_pengambilan
					FROM tb_distribusi_agen da
					LEFT JOIN tb_agen ag
						ON da.id_agen = ag.id_agen
					".$where."
					ORDER BY id DESC ";
		$result_table = $this->db->query($sql_table)->result();
		$respon = array('table' => $result_table);
		echo json_encode($respon);
	}

	public function search_list_laporan(){
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$where = "WHERE (da.tanggal_pengambilan BETWEEN '".$this->db->escape_str($start_date)." 00:00:00' AND '".$this->db->escape_str($end_date)." 23:59:59')";
		// $where = "WHERE (da.tanggal_pengambilan BETWEEN '2021-05-24 00:00:00' AND '2021-05-24 23:59:59')";
		$sql_table = "SELECT da.id_distribusi_agen as id, CONCAT('AG-', ag.no_reg) AS no_reg, ag.nama, da.jumlah_tabung, DATE(da.tanggal_pengambilan) AS tanggal_pengambilan, da.status_pengambilan
					FROM tb_distribusi_agen da
					LEFT JOIN tb_agen ag
						ON da.id_agen = ag.id_agen
					".$where."
					ORDER BY id DESC ";
		$result_table = $this->db->query($sql_table)->result();
		$respon = array('table' => $result_table);
		echo json_encode($respon);
	}

	public function list_agen() {
		echo json_encode($this->SpbeModel->get_list_agen(''));
	}

	public function detail_agen($id='') {
		if($id) {
			$agen = $this->SpbeModel->get_agen_by_id($id);
			if((count($agen)>0)&&($agen !== false)){
				$res = array('status' => 'success' , 'message' => $agen);
			} else {
				$res = array('status' => 'failed' , 'message' => 'Agen tidak ditemukan');
			}
		} else {
			$res = array('status' => 'failed' , 'message' => 'Agen tidak ditemukan');
		}

		echo json_encode($res);
	}

	public function store_agen()
	{
		$request = $this->input->post();
		
		if(isset($request)) {
			// if isset id is for edit, else for store
			if(isset($request['id'])) {
				// Check id is exist or not
				$checkAgen = $this->SpbeModel->get_agen_by_id($request['id']);
				if( (count($checkAgen)>0) && ($checkAgen !== FALSE) ) {
					//  Check username
					$checkUsername = $this->SpbeModel->get_agen_by_username($request['username']);
					if( (count($checkUsername)>0) && ($checkUsername !== FALSE) && ($checkUsername !== $request['username'])) {
						$message['alert'] = 'danger';
						$message['status'] = 'failed';
						$message['message'] = 'Username ' . $request['username'] . ' sudah digunakan';
					} else {
						$res = $this->SpbeModel->store($request);
						if($request !== FALSE) {
							$message['alert'] = 'success';
							$message['status'] = 'success';
							$message['message'] = 'Agen ' . $request['nama_agen'] . ' berhasil diubah';
						} else {
							$message['alert'] = 'danger';
							$message['status'] = 'failed';
							$message['message'] = 'Agen ' . $request['nama_agen'] . ' gagal diubah';
						}
					}
				} else {
					$message['alert'] = 'danger';
					$message['status'] = 'failed';
					$message['message'] = 'Agen ' . $request['nama_agen'] . ' tidak ditemukan';
				}
			} else {
				$res = $this->SpbeModel->store($request);
				if($request !== FALSE) {
					$message['alert'] = 'success';
					$message['status'] = 'success';
					$message['message'] = 'Agen ' . $request['nama_agen'] . ' berhasil ditambah';
				} else {
					$message['alert'] = 'danger';
					$message['status'] = 'failed';
					$message['message'] = 'Agen ' . $request['nama_agen'] . ' gagal ditambah';
				}
			}
		} else {
			$message['alert'] = 'danger';
			$message['status'] = 'failed';
			$message['message'] = 'Agen ' . $request['nama_agen'] . ' gagal ditambah';
		}

		echo json_encode($message);
	}

	public function update_profile() {
		
		$request = $this->input->post();

		if(isset($request)) {
			// if isset id is for edit, else for store
			if(isset($request['id'])) {
				$res = $this->SpbeModel->store_profile($request);
				redirect('spbe/profile');
			}
		}

		return false;
	}

	public function pickup_gas() {
		$request = $this->input->post();
		
		if(isset($request)) {

			$res = $this->SpbeModel->store_pickup($request);

			if($request !== FALSE) {
				$message['alert'] = 'success';
				$message['status'] = 'success';
				$message['message'] = 'Pengambilan gas berhasil';
			} else {
				$message['alert'] = 'danger';
				$message['status'] = 'failed';
				$message['message'] =  'Gagal mengambil gas';
			}
		}  else {
			$message['alert'] = 'danger';
			$message['status'] = 'failed';
			$message['message'] = 'Gagal mengambil gas';
		}

		echo json_encode($message);
	}

	public function delete_agen() {
		$request = $this->input->post();
		$res = array('status' => 'failed', 'message' => 'Gagal');
		if(isset($request['id'])) {
			$this->SpbeModel->delete($request);
			$res = array('status' => 'success', 'message' => 'Dihapus');
		}
		echo json_encode($res);
	}

	public function kelola_profile() {
		$this->load->view('spbe/v_profile');
	}

	public function get_rfid_daftar()
	{
		$rfid = $this->SpbeModel->rfid_listener();
		echo json_encode($rfid);
	}

	public function refresh_rfid()
	{
		$this->SpbeModel->delete_rfid();
	}
}
