<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    public function index()
    {
		if(($this->input->post('username_')) && ($this->input->post('password_'))) {
			// Variable for username and passowrd
			$username = $this->input->post('username_');
			$password = $this->input->post('password_');

			// Query check the username
			$result = $this->db->query("SELECT * FROM tb_pengguna WHERE username = '". $this->db->escape_str($username) ."' ")->result();

			// If username exist
			if($result) {
				// Compare the password in mysql and password form sign in
				if($result[0]->password == sha1($password)) {
					// Check if role is SPBE
					if($result[0]->priviledge_id == 1) {
						// Array for store session
						$sessData = array(
							'id' => $result[0]->id_pengguna,
							'username' => $result[0]->username,
							'photo' => $result[0]->photo,
							'name' => 'SPBE',
							'role' => 'spbe'
						);
						
						// Store array to session
						$this->session->set_userdata( $sessData );

						// Redirect to dashboard here
						redirect('dashboard');
					} else {
						// Get agen data
						$resultProfile = $this->db->query("SELECT * FROM tb_agen WHERE id_agen = '". $this->db->escape_str($result[0]->profile_id) ."' ")->result();
						// Array for store session
						$sessData = array(
							'id' => $result[0]->id_pengguna,
							'username' => $result[0]->username,
							'id_agen' => $resultProfile[0]->id_agen,
							'no_reg' => $resultProfile[0]->no_reg,
							'no_telepon' => $resultProfile[0]->no_telepon,
							'alamat' => $resultProfile[0]->alamat,
							'name' => $resultProfile[0]->nama,
							'rfid' => $resultProfile[0]->data_rfid,
							'tabung' => $resultProfile[0]->jumlah_tabung,
							'pelanggan' => $resultProfile[0]->jumlah_pelanggan,
							'photo' => $resultProfile[0]->photo,
							'role' => 'agen'
						);

						// Store array to session
						$this->session->set_userdata( $sessData );

						// Redirect to dashboard here
						redirect('dashboard');
					}
				} else {
					$message['alert'] = 'danger';
					$message['status'] = 'Gagal';
					$message['message'] = 'Username dan password salah';
					$this->session->set_flashdata($message);
					redirect('login');
				}
			} else {
				$message['alert'] = 'danger';
				$message['status'] = 'Gagal';
				$message['message'] = 'Username dan password salah';
				$this->session->set_flashdata($message);
				redirect('login');
			}
		}

        $this->load->view('login/v_login');
    }
}
