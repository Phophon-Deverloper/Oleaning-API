<?php

require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
     
class Leaderboard extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function index_get()
	{
        $scoreuserdata = array();
        $board = [];
        $progress = array();
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
            $userdata = $this->db->get_where("users")->result();
            foreach ($userdata as $data) {
                $data = (array) $data;
                $scoreuserdata = $scoreuserdata + array("user_id" => $data['id']) + array("user_name" => $data['name']);
                $enrolldata = $this->db->get_where("enrollment", ['user_id' => $data['id']])->result();
                foreach ($enrolldata as $endata) {
                    $endata = (array) $endata;
                    $titledata = $this->db->get_where("titleprogress", ['enrollment_id' => $endata['enrollment_id']])->result();
                    if ($titledata != []) {
                        foreach ($titledata as $tdata) {
                            array_push($progress, $tdata);
                        }
                    }
                }
                $scoreuserdata = $scoreuserdata + array("module_progress_current" => count($progress));
                array_push($board, $scoreuserdata);
                $scoreuserdata = array();
                $progress = array();
            }
            $this->response($board, REST_Controller::HTTP_OK);
        }else{
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}

?>