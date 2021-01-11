<?php

require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
     
class Title extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function index_get($id)
	{
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
            if ($id == 0) {
                $this->response(REST_Controller::HTTP_BAD_REQUEST);
            }else {
                $titledata = $this->db->get_where("title", ['title_id' => $id])->row_array();
                if ($titledata['title_type'] == 'QUIZ') {
                    $choicedata = $this->db->get_where("quizchoice", ['title_id' => $titledata['title_id']])->result();
                    $titledata = $titledata + array("choice" => $choicedata);
                }
                $titleprogressdata = $this->db->get_where("titleprogress", ['title_id' => $id])->result();
                if ($titleprogressdata != []) {
                    $enrolldata = $this->db->get_where("enrollment", ['user_id' => $jwtData['id']])->result();
                    foreach ($enrolldata as $data) {
                        $data = (array) $data;
                        foreach ($titleprogressdata as $dataobj) {
                            $dataobj = (array) $dataobj;
                            if ($data['enrollment_id'] == $dataobj['enrollment_id']) {
                                $titledata = $titledata + array("status" => $dataobj['status']);
                            }
                        }
                    }
                }else{
                    $titledata = $titledata + array("status" => "0");
                }
                $this->response($titledata, REST_Controller::HTTP_OK);
            }
        }else{
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
}

?>