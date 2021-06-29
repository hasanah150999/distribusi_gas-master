<?php

class RfidModel extends CI_Model {

	public function push($data_alat)
	{
		// Query
		$query_delete_temp = "DELETE FROM tb_temp_rfid";
		// $query_log = "SELECT func_rfid('".$data_alat."')";
		$query_temp_log = "SELECT func_temp_rfid('".$data_alat."')";

	
		// Header for response
		$header = "func_temp_rfid('".$data_alat."')";
		
		// Run Query
		$delete = $this->db->query($query_delete_temp);
		$temp = $this->db->query($query_temp_log)->result();
		// $result = $this->db->query($query_log)->result();
	
		// Return the response
		if($temp !== NULL) {
			return [
				'response' => $temp[0]->$header
			];
		}
	}
}
