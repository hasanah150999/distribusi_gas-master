<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SpbeModel extends CI_Model {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ssp');
		$this->load->helper('path');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function get_list_agen($request) {
		
		$where = '';

		if($request) {
			$where .= 'WHERE ag.no_reg LIKE "%'.$this->db->escape_str($request).'%" OR ag.nama LIKE "%'.$this->db->escape_str($request).'%"
						OR ag.alamat LIKE "%'.$this->db->escape_str($request).'%" OR ag.jumlah_tabung = '.$this->db->escape_str($request).' 
						OR ag.jumlah_pelanggan = '.$this->db->escape_str($request).' ';
		}

		$table = '(SELECT ag.id_agen as id, CONCAT("AG-", ag.no_reg) as no_reg, ag.nama, ag.alamat, ag.jumlah_tabung, ag.jumlah_pelanggan
					FROM tb_agen ag '. $where .') x ';

		// Primary Key
		$primaryKey = 'x.id';
		// Table Where
		$sWhere = 'x.id > 0';
		// Table Group By
		$sGroupBy = '';

		$columns = array(
			array('db' => 'x.id', 'dt' => 0),
			array('db' => 'x.no_reg', 'dt' => 1),
			array('db' => 'x.nama', 'dt' => 2),
			array('db' => 'x.alamat', 'dt' => 3),
			array('db' => 'x.jumlah_tabung', 'dt' => 4),
			array('db' => 'x.jumlah_pelanggan', 'dt' => 5)
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
			
			$row[] = '<a href="#" class="btn btn-info edit_agen" data-toggle="modal" data-target="#modalEditAgen" data-id="'.$id_temp.'">Edit</a>&nbsp
						&nbsp;
						<a href="#" class="btn btn-danger delete_agen" data-id="'.$id_temp.'">Hapus</a>';

			$output['data'][] = $row;
			$hit++;
		}

		return $output;
	}

	public function get_list_monitoring($request) {
		$where = '';

		if($request) {
			$where .= 'WHERE ag.no_reg LIKE "%'.$this->db->escape_str($request).'%" OR ag.nama LIKE "%'.$this->db->escape_str($request).'%" OR da.status_pengambilan LIKE "%'.$this->db->escape_str($request).'%" OR da.jumlah_tabung LIKE "%'.$this->db->escape_str($request).'%" OR da.tanggal_pengambilan = "%'.$this->db->escape_str($request).'%"';
		}

		$table = '(SELECT da.id_distribusi_agen as id, CONCAT("AG-", ag.no_reg) AS no_reg, ag.nama, da.status_pengambilan, da.jumlah_tabung, DATE(da.tanggal_pengambilan) AS tanggal_pengambilan
					FROM tb_distribusi_agen da
					LEFT JOIN tb_agen ag
						ON da.id_agen = ag.id_agen '. $where .') x ';

		// Primary Key
		$primaryKey = 'x.id';
		// Table Where
		$sWhere = 'x.id > 0';
		// Table Group By
		$sGroupBy = '';

		$columns = array(
			array('db' => 'x.id', 'dt' => 0),
			array('db' => 'x.no_reg', 'dt' => 1),
			array('db' => 'x.nama', 'dt' => 2),
			array('db' => 'x.status_pengambilan', 'dt' => 3),
			array('db' => 'x.jumlah_tabung', 'dt' => 4),
			array('db' => 'x.tanggal_pengambilan', 'dt' => 5)
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

	public function get_agen_by_id($id) {
		if($id) {
			$query = "SELECT * FROM tb_agen ag LEFT JOIN tb_pengguna tp ON ag.id_agen = tp.profile_id  WHERE ag.id_agen = '".$this->db->escape_str($id)."' AND tp.priviledge_id = 2";
			return $this->db->query($query)->result();
		}

		return false;
	}

	public function get_graph_distribusi_agen() {
		$query = "SELECT SUM(da.jumlah_tabung) AS jumlah_tabung, DATE(da.tanggal_pengambilan) AS tanggal
					FROM tb_distribusi_agen da
					WHERE MONTH(da.tanggal_pengambilan) = MONTH(NOW())
					GROUP BY tanggal";
		return $this->db->query($query)->result();
	}

	public function get_agen_by_rfid($rfid) {
		if($rfid) {
			$query = "SELECT * FROM tb_agen ag WHERE ag.data_rfid = '".$this->db->escape_str($rfid)."' ";
			return $this->db->query($query)->result();
		}

		return false;
	}

	public function get_agen_by_username($username) {
		if($username) {
			$query = "SELECT pg.username FROM tb_pengguna pg WHERE pg.username = '".$this->db->escape_str($username)."' ";
			$res = $this->db->query($query)->result();
			return $res[0]->username;
		}

		return false;
	}

	public function get_list_distribusi($request) {
		$where = '';

		if($request) {
			$where .= 'WHERE ag.no_reg LIKE "%'.$this->db->escape_str($request).'%" OR ag.nama LIKE "%'.$this->db->escape_str($request).'%" OR ag.jumlah_tabung LIKE "%'.$this->db->escape_str($request).'%" OR ag.jumlah_pelanggan LIKE "%'.$this->db->escape_str($request).'%"';
		}

		$table = '(SELECT ag.id_agen AS id, ag.no_reg, ag.nama, ag.jumlah_tabung, ag.jumlah_pelanggan
					FROM tb_agen ag '. $where .') x ';

		// Primary Key
		$primaryKey = 'x.id';
		// Table Where
		$sWhere = 'x.id > 0';
		// Table Group By
		$sGroupBy = '';

		$columns = array(
			array('db' => 'x.id', 'dt' => 0),
			array('db' => 'x.no_reg', 'dt' => 1),
			array('db' => 'x.nama', 'dt' => 2),
			array('db' => 'x.jumlah_tabung', 'dt' => 3),
			array('db' => 'x.jumlah_pelanggan', 'dt' => 4),
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
			
			$row[] = '<a href="'.base_url().'spbe/detail_distribusi/'.$id_temp.'" class="btn btn-info edit_agen">Lihat</a>';

			$output['data'][] = $row;
			$hit++;
		}

		return $output;
	}

	public function get_list_detail_distribusi($id='') {
		$where = 'WHERE dm.id_agen = ' . $id;

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

	public function get_agen() {

		$query = $this->db->query("SELECT ag.id_agen, ag.nama FROM tb_agen ag ")->result();
		$dropdowns = $query;

		if(!$dropdowns) {
			// $finalDropdown[''] = " - Pilih Agen -";
			return $finalDropdown;
		} else {
			foreach($dropdowns as $dropdown) {
				$dropdownlist[$dropdown->id_agen] = $dropdown->nama;
			}

			$finalDropdown = $dropdownlist;
			$finalDropdown[''] = " - Pilih Agen - ";
			return $finalDropdown;
		}
	}

	public function get_permit($username) {
		if($username) {
			$query = "SELECT pg.username as user, pg.password as pass FROM tb_pengguna pg WHERE pg.username = '".$this->db->escape_str($username)."' ";
			$res = $this->db->query($query)->result();
			return $res[0]->pass;
		}

		return false;
	}
	
	public function store($request) {
		if(isset($request)) {
			$inputAgen = array(
				'no_reg' => $request['no_regis_agen'],
				'nama' => $request['nama_agen'],
				'alamat' => $request['alamat_agen'],
				// 'data_rfid' => $request['data_ktp']
			);

			$akunAgen = array(
				'username' => $request['username'],
				// 'password' => sha1($request['password_baru']),
				'priviledge_id' => 2,
				'status' => 'active',
			);

			if(isset($request['id'])) {
				if(isset($request['no_regis_agen'])) {
					if($request['no_regis_agen']) {
						$inputAgen['no_reg'] = $request['no_regis_agen'];
					}
				}

				if(isset($request['nama_agen'])) {
					if($request['nama_agen']) {
						$inputAgen['nama'] = $request['nama_agen'];
					}
				}

				if(isset($request['alamat_agen'])) {
					if($request['alamat_agen']) {
						$inputAgen['alamat'] = $request['alamat_agen'];
					}
				}

				if(isset($request['data_ktp'])) {
					if($request['data_ktp']) {
						$inputAgen['data_rfid'] = $request['data_ktp'];
					}
				}

				if(isset($request['username'])) {
					if($request['username']) {
						$akunAgen['username'] = $request['username'];
					}
				}

				if(!empty($request['password_baru'])) {
					if($request['password_baru']) {
						$akunAgen['password'] = sha1($request['password_baru']);
					}
				}

				$inputAgen['change_date'] = date('Y-m-d H:i:s');

				$this->db->where('id_agen', $request['id']);
				$this->db->update('tb_agen', $inputAgen);

				$this->db->where('id_pengguna', $request['id_pengguna']);
				$this->db->update('tb_pengguna', $akunAgen);
				
				$message['message_update'] = 'Agen ' . $request['nama_agen'] . ' berhasil diubah';
				return $message;
			} else {			
				// if(isset($request['data_ktp'])) {
				// 	if($request['data_ktp']) {
				// 		$inputAgen['data_rfid'] = $request['data_ktp'];
				// 	}
				// }

				if(!empty($request['password_baru'])) {
					if($request['password_baru']) {
						$akunAgen['password'] = sha1($request['password_baru']);
					}
				}

				$inputAgen['create_date'] = date('Y-m-d H:i:s');
				$inputAgen['change_date'] = date('Y-m-d H:i:s');

				$this->db->insert('tb_agen', $inputAgen);
				$insert_id = $this->db->insert_id();

				$akunAgen['profile_id'] = $insert_id;
				$akunAgen['create_date'] = date('Y-m-d H:i:s');
				$akunAgen['change_date'] = date('Y-m-d H:i:s');

				$this->db->insert('tb_pengguna', $akunAgen);

				$message['message_insert'] = 'Agen ' . $request['nama_agen'] . ' berhasil ditambah';
				return $message;
			}
		}

		return false;
	}

	public function store_profile($request) {
		if(isset($request)) {
			$akunSPBE = array(
				'username' => $request['username']
			);

			if(isset($request['id'])) {
				if(isset($request['username'])) {
					if($request['username']) {
						$akunSPBE['username'] = $request['username'];
						$this->session->set_userdata('username', $akunSPBE['username']);
					}
				}

				if(!empty($request['password'])) {
					if($request['password']) {
						$akunSPBE['password'] = sha1($request['password']);
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
						$akunSPBE['photo']  = '';
					}else{	
						$data = array('upload_data' => $this->upload->data());
						$akunSPBE['photo']  = $filename;
						$this->session->set_userdata('photo', $filename);
					}
					
				}

				$akunSPBE['change_date'] = date('Y-m-d H:i:s');

				$this->db->where('id_pengguna', $request['id']);
				$this->db->update('tb_pengguna', $akunSPBE);
			}
		}
	}

	public function delete($request) {
		if(isset($request)) {
			if(isset($request['id'])) {
				$this->db->delete('tb_agen', array('id_agen' => $request['id']));
				$this->db->delete('tb_pengguna', array('profile_id' => $request['id'], 'priviledge_id' => 2));

				return true;
			}
		}
		return false;
	}
	
	public function store_pickup($request) {
		if(isset($request)) {
			$inputPengambilan = array(
				'id_agen' => $request['agen'],
				'jumlah_tabung' => $request['jumlah_ambil'],
				'tanggal_pengambilan' => date('Y-m-d H:i:s'),
				'status_pengambilan' => 'berhasil',
				'create_date' => date('Y-m-d H:i:s'),
				'change_date' => date('Y-m-d H:i:s')
			);
	
	
			$this->db->insert('tb_distribusi_agen', $inputPengambilan);
			$insert_id = $this->db->insert_id();
	
			$queryUpdate = "UPDATE tb_agen ag SET ag.jumlah_tabung = ag.jumlah_tabung + ". $request['jumlah_ambil'] ." WHERE ag.id_agen = " . $request['agen'];
			$this->db->query($queryUpdate);
	
			$message['message'] = 'Pengambilan gas berhasil';
			return $message;
		}

		return false;
	}

	public function rfid_listener() {
		$query = "SELECT tr.data_rfid
					FROM tb_temp_rfid tr
					ORDER BY tr.id DESC
					LIMIT 1";
		$header = 'data_rfid';
		$result = $this->db->query($query)->result();

		if(count($result) > 0) {
			return [
				$result[0]->$header
			];
		}

		return array();
	}

	public function delete_rfid() {
		$query = "DELETE FROM tb_temp_rfid";
		$run = $this->db->query($query);
	}

}

/* End of file SpbeModel.php */
