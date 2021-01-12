<?php

require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
     
class Oauth extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function token_get()
	{
        $jsonArray = json_decode($this->input->raw_input_stream, true);
        $userdata = $this->db->get_where("users", ['email' => $jsonArray['email']])->row_array();
        if ($jsonArray['password'] == $userdata['password']) {
            $jwttoken = $this->tokenHandler->GenerateToken($userdata);
            $this->response($jwttoken, REST_Controller::HTTP_OK);
        }
    }
    	
}

?>