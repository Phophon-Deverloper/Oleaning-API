<?php

require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
     
class Submodule extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function title_get($id)
	{
        $usertitleData = [];
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        $titledata = $this->db->get_where("title", ['submodule_id' => $id])->result();
        foreach ($titledata as $data) {
            $data = (array) $data;
            if ($data['title_type'] == 'QUIZ') {
                $choicedata = $this->db->get_where("quizchoice", ['title_id' => $data['title_id']])->result();
                $data = $data + array("choice" => $choicedata);
            }
            array_push($usertitleData, $data);
        }
        $this->response($usertitleData, REST_Controller::HTTP_OK);
    }
}

?>