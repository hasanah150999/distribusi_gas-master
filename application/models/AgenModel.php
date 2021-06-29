<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AgenModel extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->library('SSP');
		$this->load->helper('path');
		date_default_timezone_set('Asia/Jakarta');	
	}

	public function get_pelanggan_by_nik($nik) {
		$query = "SELECT tp.nama
					FROM tb_pelanggan tp
					WHERE tp.nik = '".$this->db->escape_str($nik)."'";
		return $dropdowns = $this->db->query($query)->result();
	}

	public function get_pelanggan_by_id($id) {
		$query = "SELECT *
					FROM tb_pelanggan tp
					WHERE tp.id_pelanggan = '".$this->db->escape_str($id)."'";
		return $dropdowns = $this->db->query($query)->result();
	}

	public function get_graph_distribusi_masyarakat() {
		$query = "SELECT SUM(dm.jumlah_tabung) AS tabung, DATE(dm.tanggal_pembelian) AS tanggal
					FROM tb_distribusi_masyarakat dm
					WHERE MONTH(dm.tanggal_pembelian) = MONTH(NOW())
					GROUP BY tanggal";
		return $this->db->query($query)->result();
	}

	public function get_pelanggan_by_rfid($data_rfid) {
		$query = "SELECT tp.nama
					FROM tb_pelanggan tp
					WHERE tp.data_rfid = '".$this->db->escape_str($data_rfid)."'";
		return $dropdowns = $this->db->query($query)->result();
	}

	public function get_list_pelanggan($request) {
		$where = 'WHERE tp.agen_id = ' . $this->session->userdata('id_agen');

		if($request) {
			$where .= ' AND (tp.nik = "'.$this->db->escape_str($request).'" OR tp.nama LIKE "%'.$this->db->escape_str($request).'%" OR tkl.nama LIKE "%'.$this->db->escape_str($request).'%" OR tkc.nama LIKE "%'.$this->db->escape_str($request).'%" OR tkb.nama LIKE "%'.$this->db->escape_str($request).'%" OR tkp.nama LIKE "%'.$this->db->escape_str($request).'%" )';
		}

		$table = '(SELECT tp.id_pelanggan as id, 
							tp.nik AS nik, 
							tp.nama AS nama, 
							CONCAT(tp.alamat, " RT ", tp.rt, " RW ", tp.rw, ", ", tkl.nama, 
										", Kec. ", tkc.nama, ", ", tkb.nama, ", Prov. ", tkp.nama) AS alamat,
							DATE(tp.create_date) AS tanggal_daftar
					FROM tb_pelanggan tp
					LEFT JOIN tb_kelurahan tkl
						ON tp.kelurahan = tkl.id_kel
					LEFT JOIN tb_kecamatan tkc
						ON tp.kecamatan = tkc.id_kec
					LEFT JOIN tb_kabupaten tkb
						ON tp.kab_kota = tkb.id_kab
					LEFT JOIN tb_provinsi tkp
						ON tp.provinsi = tkp.id_prov
					'. $where .') x';
		
		// Primary Key
		$primaryKey = 'x.id';
		// Table Where
		$sWhere = 'x.id > 0';
		// Table Group By
		$sGroupBy = '';

		$columns = array(
			array('db' => 'x.id', 'dt' => 0),
			array('db' => 'x.nik', 'dt' => 1),
			array('db' => 'x.nama', 'dt' => 2),
			array('db' => 'x.alamat', 'dt' => 3),
			array('db' => 'x.tanggal_daftar', 'dt' => 4)
		);

		$rows = '';

		for($i=0; $i<count($columns); $i++) {
			if($i!=count($columns)-1) {
				$rows.=$columns[$i]['db'].',';
			} else {
				$rows.=$columns[$i]['db'];
			}
		}

		// For Showing Column
		$aColumns = explode(',', $rows);

		$request = $_GET;
		$bindings = array();

		// SQL Server Connection Information
		$db = SSP::sql_connect();

		$limit = SSP::limit($request, $columns);
		$order = SSP::order($request, $columns);
		$where = SSP::filter($request, $columns, $bindings, $sWhere);

		// Main query to get data
		$data = SSP::sql_exec($db, $bindings, "SELECT SQL_CALC_FOUND_ROWS ". implode(", ", SSP::pluck($columns, 'db'))."
				FROM $table $where $sGroupBy $order $limit");

		// Data set length after filtering
		$resFilterLength = SSP::sql_exec($db, "SELECT FOUND_ROWS()");

		$recordsFiltered = $resFilterLength[0][0];

		$resTotalLength = SSP::sql_exec($db, $bindings, "SELECT COUNT({$primaryKey}) FROM $table $where");	

		$recordsTotal = $resTotalLength[0][0];

		// Output
		$output = array(
			"draw"				=> intval($request['draw']),
			'recordsTotal'		=> intval($recordsTotal),
			'recordsFiltered' 	=> intval($recordsFiltered),
			'data' 				=> array()
		);

		$hit = '1';

		foreach($data as $aRow) {
			$row = array();
			for($i=0; $i<count($aColumns); $i++) {
				if($aColumns[$i] == "version") {
					$row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
				} else if ($aColumns[$i] != ' ') {
					if(stripos($aColumns[$i], '.') === FALSE) {
						if($aColumns[$i] == 'id') {

						} else {
							$row[] = $aRow[$aColumns[$i]];
						}

						$row[] = $aRow[$aColumns[$i]];
						$id_temp = $aRow[$aColumns[0]];

					} else {
						$column = explode('.', $aColumns[$i]);
						$temps = explode('.', $aColumns[0]);
						$temps2 = explode('.', $aColumns[1]);
						$id_temp = $aRow[$temps[1]];
						$nik = $aRow[$temps2[1]];

						if($column[1] == 'id') {

						} else if($column[1] == "nik") {
							$count_nik = strlen($nik);
							$output_nik = substr_replace($nik, str_repeat('*', $count_nik), 4, $count_nik);
							$row[] = $output_nik;
						} else {
							$row[] = $aRow[$column[1]];
						}
					}
				}
			}
			
			$row[] = '<a href="#" class="btn btn-info edit_pelanggan" data-toggle="modal" data-target="#modalEditPelanggan" data-id="'.$id_temp.'">Edit</a>&nbsp
						&nbsp;
						<a href="#" class="btn btn-danger delete_pelanggan" data-id="'.$id_temp.'">Hapus</a>';

			$output['data'][] = $row;
			$hit++;
		}

		return $output;
	}

	public function get_list_pengambilan($request) {
		$where = 'WHERE dm.id_agen = ' . $this->session->userdata('id_agen');

		if($request) {
			$where .= 'AND (tp.nik LIKE "%'.$this->db->escape_str($request).'%" OR tp.nama LIKE "%'.$this->db->escape_str($request).'%" OR  tanggal_pembelian LIKE "%'.$this->db->escape_str($request).'%" OR dm.jumlah_tabung LIKE "%'.$this->db->escape_str($request).'%")';
		}

		$table = '(SELECT dm.id_distribusi_masyarakat AS id, tp.nik, tp.nama, dm.status_pembelian, DATE(dm.tanggal_pembelian) AS tanggal_pembelian, dm.jumlah_tabung
					FROM tb_distribusi_masyarakat dm
					LEFT JOIN tb_pelanggan tp
					ON dm.id_pelanggan = tp.id_pelanggan '. $where .'
					ORDER BY dm.tanggal_pembelian DESC) x';

		// Primary Key
		$primaryKey = 'x.id';
		// Table Where
		$sWhere = 'x.id > 0';
		// Table Group By
		$sGroupBy = '';

		$columns = array(
			array('db' => 'x.id', 'dt' => 0),
			array('db' => 'x.nik', 'dt' => 1),
			array('db' => 'x.nama', 'dt' => 2),
			array('db' => 'x.status_pembelian', 'dt' => 3),
			array('db' => 'x.tanggal_pembelian', 'dt' => 4),
			array('db' => 'x.jumlah_tabung', 'dt' => 5)
		);

		$rows = '';

		for($i=0; $i<count($columns); $i++) {
			if($i!=count($columns)-1) {
				$rows.=$columns[$i]['db'].',';
			} else {
				$rows.=$columns[$i]['db'];
			}
		}

		// For Showing Column
		$aColumns = explode(',', $rows);

		$request = $_GET;
		$bindings = array();

		// SQL Server Connection Information
		$db = SSP::sql_connect();

		$limit = SSP::limit($request, $columns);
		$order = SSP::order($request, $columns);
		$where = SSP::filter($request, $columns, $bindings, $sWhere);

		// Main query to get data
		$data = SSP::sql_exec($db, $bindings, "SELECT SQL_CALC_FOUND_ROWS ". implode(", ", SSP::pluck($columns, 'db'))."
				FROM $table $where $sGroupBy $order $limit");

		// Data set length after filtering
		$resFilterLength = SSP::sql_exec($db, "SELECT FOUND_ROWS()");

		$recordsFiltered = $resFilterLength[0][0];

		$resTotalLength = SSP::sql_exec($db, $bindings, "SELECT COUNT({$primaryKey}) FROM $table $where");	

		$recordsTotal = $resTotalLength[0][0];

		// Output
		$output = array(
			"draw"				=> intval($request['draw']),
			'recordsTotal'		=> intval($recordsTotal),
			'recordsFiltered' 	=> intval($recordsFiltered),
			'data' 				=> array()
		);

		$hit = '1';

		foreach($data as $aRow) {
			$row = array();
			for($i=0; $i<count($aColumns); $i++) {
				if($aColumns[$i] == "version") {
					$row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
				} else if ($aColumns[$i] != ' ') {
					if(stripos($aColumns[$i], '.') === FALSE) {
						if($aColumns[$i] == 'id') {

						} else {
							$row[] = $aRow[$aColumns[$i]];
						}

						$row[] = $aRow[$aColumns[$i]];
						$id_temp = $aRow[$aColumns[0]];

					} else {
						$column = explode('.', $aColumns[$i]);
						$temps = explode('.', $aColumns[0]);
						$id_temp = $aRow[$temps[1]];

						if($column[1] == 'id') {

						} else {
							$row[] = $aRow[$column[1]];
						}
					}
				}
			}
			
			$row[] = '';

			$output['data'][] = $row;
			$hit++;
		}

		return $output;

	}

	function get_agen_by_id($id) {
		if($id) {
			$query = "SELECT * FROM tb_agen ag LEFT JOIN tb_pengguna tp ON ag.id_agen = tp.profile_id  WHERE ag.id_agen = '".$this->db->escape_str($id)."' AND tp.priviledge_id = 2";
			return $this->db->query($query)->result();
		}

		return false;
	}

	public function store($request) {
		if(isset($request)) {
			$inputPelanggan = array(
				'nama' => $request['nama'],
				'email_pelanggan' => $request['email'],
				'alamat' => $request['alamat'],
				'nik' => $request['nik'],
				'rt' => $request['rt'],
				'rw' => $request['rw'],
				// 'kelurahan' => $request['kelurahan'],
				// 'kecamatan' => $request['kecamatan'],
				// 'kab_kota' => $request['kab_kota'],
				// 'provinsi' => $request['provinsi'],
				'data_rfid' => $request['data_ktp'],
				'agen_id' => $request['agen_id']
			);

			if(isset($request['id'])) {
				if(isset($request['nik'])) {
					if($request['nik']) {
						$inputPelanggan['nik'] = $request['nik'];
					}
				}

				if(isset($request['nama'])) {
					if($request['nama']) {
						$inputPelanggan['nama'] = $request['nama'];
					}
				}

				if(isset($request['email'])) {
					if($request['email']) {
						$inputPelanggan['email'] = $request['email'];
					}
				}

				if(isset($request['alamat'])) {
					if($request['alamat']) {
						$inputPelanggan['alamat'] = $request['alamat'];
					}
				}

				if(isset($request['rt'])) {
					if($request['rt']) {
						$inputPelanggan['rt'] = $request['rt'];
					}
				}

				if(isset($request['rw'])) {
					if($request['rw']) {
						$inputPelanggan['rw'] = $request['rw'];
					}
				}

				if(isset($request['provinsi'])) {
					if($request['provinsi']) {
						$inputPelanggan['provinsi'] = $request['provinsi'];
					}
				}

				if(isset($request['kab_kota'])) {
					if($request['kab_kota']) {
						$inputPelanggan['kab_kota'] = $request['kab_kota'];
					}
				}

				if(isset($request['kecamatan'])) {
					if($request['kecamatan']) {
						$inputPelanggan['kecamatan'] = $request['kecamatan'];
					}
				}

				if(isset($request['kelurahan'])) {
					if($request['kelurahan']) {
						$inputPelanggan['kelurahan'] = $request['kelurahan'];
					}
				}

				if(isset($request['data_ktp_edit'])) {
					if($request['data_ktp_edit']) {
						$inputPelanggan['data_rfid'] = $request['data_ktp_edit'];
					}
				}

				$inputPelanggan['change_date'] = date('Y-m-d H:i:s');

				$this->db->where('id_pelanggan', $request['id']);
				$this->db->update('tb_pelanggan', $inputPelanggan);
				$message['message_update'] = 'Pelanggan ' . $request['nama'] . ' berhasil diubah';
				return $message;
			} else {

				if(isset($request['provinsi'])) {
					if($request['provinsi']) {
						$inputPelanggan['provinsi'] = $request['provinsi'];
					}
				}

				if(isset($request['kab_kota'])) {
					if($request['kab_kota']) {
						$inputPelanggan['kab_kota'] = $request['kab_kota'];
					}
				}

				if(isset($request['kecamatan'])) {
					if($request['kecamatan']) {
						$inputPelanggan['kecamatan'] = $request['kecamatan'];
					}
				}

				if(isset($request['kelurahan'])) {
					if($request['kelurahan']) {
						$inputPelanggan['kelurahan'] = $request['kelurahan'];
					}
				}

				$inputPelanggan['create_date'] = date('Y-m-d H:i:s');
				$inputPelanggan['change_date'] = date('Y-m-d H:i:s');

				$this->db->insert('tb_pelanggan', $inputPelanggan);
				$insert_id = $this->db->insert_id();

				$queryUpdate = "UPDATE tb_agen ag SET ag.jumlah_pelanggan = ag.jumlah_pelanggan + 1 WHERE ag.id_agen = " . $request['agen_id'];
				$this->db->query($queryUpdate);
				
				$message['message_insert'] = 'Pelanggan ' . $request['nama'] . ' berhasil ditambah';
				return $message;
			}
		}

		return false;
	}

	public function get_batas_distribusi($request) {
		if(isset($request)) {
			$query = "SELECT SUM(dm.jumlah_tabung) as jumlah_tabung FROM tb_distribusi_masyarakat dm WHERE MONTH(dm.tanggal_pembelian) = MONTH(NOW()) and dm.id_pelanggan = " . $request;
			$header = 'jumlah_tabung';
			$result = $this->db->query($query)->result();

			if(count($result) > 0) {
				return $result[0]->$header;
			}
		}

		return array();
	}

	public function get_stok_gas($request) {
		if(isset($request)) {
			$query = "SELECT ag.jumlah_tabung FROM tb_agen ag WHERE ag.id_agen =" . $request;
			$header = 'jumlah_tabung';
			$result = $this->db->query($query)->result();

			if(count($result) > 0) {
				return $result[0]->$header;
			}
		}

		return array();
	}

	public function store_pickup($request) {
		if(isset($request)) {
			$inputPengambilan = array(
				'id_pelanggan' => $request['id_pelanggan'],
				'id_agen' => $request['id_agen'],
				'jumlah_tabung' => $request['jumlah_beli'],
				'status_pembelian' => 'berhasil',
				'tanggal_pembelian' => date('Y-m-d H:i:s'),
				'create_date' => date('Y-m-d H:i:s'),
				'create_date' => date('Y-m-d H:i:s'),
			);

			$this->db->insert('tb_distribusi_masyarakat', $inputPengambilan);
			$insert_id = $this->db->insert_id();

			$queryUpdate = "UPDATE tb_agen ag SET ag.jumlah_tabung = ag.jumlah_tabung - ". $request['jumlah_beli'] ." WHERE ag.id_agen = " . $request['id_agen'];
			$this->db->query($queryUpdate);
	
			$message['message'] = 'Pengambilan gas berhasil';
			return $message;
		}
	}

	public function store_profile($request) {
		if(isset($request)) {
			$inputAgen = array(
				'nama' => $request['nama'],
				'alamat' => $request['alamat_agen']
			);

			$akunAgen = array(
				'username' => $request['username'],
			);

			if(isset($request['id'])) {
				if(isset($request['nama'])) {
					if($request['nama']) {
						$inputAgen['nama'] = $request['nama'];
						$this->session->set_userdata('name', $inputAgen['nama']);
					}
				}

				if(isset($request['alamat_agen'])) {
					if($request['alamat_agen']) {
						$inputAgen['alamat'] = $request['alamat_agen'];
						$this->session->set_userdata('alamat', $inputAgen['alamat']);
					}
				}

				if(!empty($request['no_telepon'])) {
					if($request['no_telepon']) {
						$inputAgen['no_telepon'] = $request['no_telepon'];
						$this->session->set_userdata('no_telepon', $inputAgen['no_telepon']);
					}
				}

				if(isset($request['username'])) {
					if($request['username']) {
						$akunAgen['username'] = $request['username'];
						$this->session->set_userdata('username', $akunAgen['username']);
					}
				}

				if(!empty($request['password'])) {
					if($request['password']) {
						$akunAgen['password'] = sha1($request['password']);
					}
				}

				if(!empty($_FILES['image']['name'])!==FALSE){
					// $dir_file = FCPATH.'uploads';  //for server
					$dir_file = FCPATH.'uploads'; //for localhost
	
					if (!file_exists($dir_file)) {
						@mkdir($dir_file,0777);
					}
					$dir_att = $dir_file.'/profile';
					if (!file_exists($dir_att)) {
						@mkdir($dir_att,0777);
					}	
	
					$ext = substr(strrchr($_FILES['image']['name'], '.'), 1);
					$filename = 'image_'.sha1($request['username']).'_'.sha1(date('Y-m-d H:i:s')).'.'.$ext;
					$path = set_realpath($dir_file.'/profile');
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['overwrite'] = TRUE;
					$config['max_size'] = 3000;
					$config['file_name'] = $filename;
					// $config['max_width'] = 1024;
					// $config['max_height'] = 768;
	
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					
					if ( ! $this->upload->do_upload('image')){						
						$inputAgen['photo']  = '';
					}else{	
						$data = array('upload_data' => $this->upload->data());
						$inputAgen['photo']  = $filename;
						$this->session->set_userdata('photo', $filename);
					}
					
				}

				$inputAgen['change_date'] = date('Y-m-d H:i:s');

				$this->db->where('id_agen', $request['id']);
				$this->db->update('tb_agen', $inputAgen);

				$this->db->where('id_pengguna', $request['id_pengguna']);
				$this->db->update('tb_pengguna', $akunAgen);
			}
		}
	}

	public function delete($request) {
		if(isset($request)) {
			if(isset($request['id'])) {
				$this->db->delete('tb_pelanggan', array('id_pelanggan' => $request['id']));
				$queryUpdate = "UPDATE tb_agen ag SET ag.jumlah_pelanggan = ag.jumlah_pelanggan - 1 WHERE ag.id_agen = " . $this->session->userdata('id_agen');
				$this->db->query($queryUpdate);

				return true;
			}
		}
		return false;
	}

	public function get_list_provinsi() {
		$query = $this->db->query("SELECT pr.id_prov, pr.nama FROM tb_provinsi pr");
		$dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->id_prov] = $dropdown->nama;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
	}

	public function get_list_kab_kota($id) {
		$query = "SELECT tk.id_kab AS id_kab_kot, tk.nama AS nama
					FROM tb_kabupaten tk
					WHERE tk.id_prov = '".$this->db->escape_str($id)."'";
		return $dropdowns = $this->db->query($query)->result();
	}

	public function get_list_kecamatan($id) {
		$query = "SELECT tk.id_kec AS id_kec, tk.nama AS nama
					FROM tb_kecamatan tk
					WHERE tk.id_kab = '".$this->db->escape_str($id)."'";
		return $dropdowns = $this->db->query($query)->result();
	}

	public function get_list_kel_des($id) {
		$query = "SELECT tk.id_kel AS id_kel, tk.nama AS nama
					FROM tb_kelurahan tk
					WHERE tk.id_kec = '".$this->db->escape_str($id)."'";
		return $dropdowns = $this->db->query($query)->result();
	}

	public function get_detail_daerah($id) {
		if($id) {
			$query = "SELECT pv.nama AS provinsi, kb.nama AS kab_kota, kc.nama AS kecamatan, kl.nama AS desa_lurah
						FROM tb_provinsi pv
						LEFT JOIN tb_kabupaten kb
							ON pv.id_prov = kb.id_prov
						LEFT JOIN tb_kecamatan kc
							ON kc.id_kab = kb.id_kab
						LEFT JOIN tb_kelurahan kl
							ON kl.id_kec = kc.id_kec
						WHERE kl.id_kel = '".$this->db->escape_str($id)."'";
			return $this->db->query($query)->result();
		}

		return false;
	}

	public function rfid_listener() {
		$query = "SELECT tr.data_rfid, tp.id_pelanggan, tp.nama, tp.nik, tp.email_pelanggan
					FROM tb_temp_rfid tr
					LEFT JOIN tb_pelanggan tp
						ON tp.data_rfid = tr.data_rfid
					ORDER BY tr.id DESC
					LIMIT 1";
		$header = 'data_rfid';
		$result = $this->db->query($query)->result();

		if(count($result) > 0) {
			return $result;
		}

		return array();
	}

	public function rfid_only_listener() {
		$query = "SELECT tr.data_rfid, tp.id_pelanggan, tp.nama, tp.nik
					FROM tb_temp_rfid tr
					LEFT JOIN tb_pelanggan tp
						ON tp.data_rfid = tr.data_rfid
					ORDER BY tr.id DESC
					LIMIT 1";
		$header = 'data_rfid';
		$result = $this->db->query($query)->result();

		if(count($result) > 0) {
			return $result[0]->data_rfid;
		}

		return array();
	}

	public function delete_rfid() {
		$query = "DELETE FROM tb_temp_rfid";
		$run = $this->db->query($query);
	}

	
}

/* End of file AgenModel.php */
