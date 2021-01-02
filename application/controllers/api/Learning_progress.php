<?php

require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
     
class Learning_progress extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function title_post()
	{
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        $jsonArray = json_decode($this->input->raw_input_stream, true);
        $enrolldata = $this->db->get_where("enrollment", ['user_id' => $jwtData['id']])->result();
        $titledata = $this->db->get_where("title", ['title_id' => $jsonArray['title_id']])->row_array();
        $submoduledata = $this->db->get_where("submodule", ['submodule_id' => $titledata['submodule_id']])->row_array();
        $moduledata = $this->db->get_where("module", ['module_id' => $submoduledata['module_id']])->row_array();
        foreach ($enrolldata as $data) {
            $data = (array) $data;
            // $jsonArray = (array) $jsonArray;
            if ($data['course_id'] == $moduledata['course_id']) {
                $jsonArray = $jsonArray + array("enrollment_id" => $data['enrollment_id']);
            }
        }
        $this->db->insert('titleprogress', $jsonArray);
        $this->response($jsonArray, REST_Controller::HTTP_OK);
    }
}

?>