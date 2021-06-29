<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Protect_route {

	function __construct()
	{
		$CI =& get_instance();
        $curr_url = $CI->uri->segment(1);
        $session = $CI->session->userdata('id');

        $url_not_protected = array (
            'login','api','notfound','Api/push_rfid','api/push_rfid'
        );

        if(empty($session)){
            if(in_array($curr_url,$url_not_protected)===FALSE){
                redirect('login');
            }
        }

        if($session){
            if(in_array($curr_url,$url_not_protected)!==FALSE){
                redirect('dashboard');
            }  
        }
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
