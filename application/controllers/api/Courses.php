<?php
   
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . '/libraries/TokenHandler.php';
     
class Courses extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function index_get()
	{
        $received_Token = $this->input->request_headers('Authorization');
        $param =  $this->input->get();
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        if ($param['category_id'] != "none") {
            $data = $this->db->get_where("course", ['category_id' => $param['category_id']])->row_array();
            // $data = "pass";
        }else{
            $data = $this->db->get_where("course")->result();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function module_get($id)
	{
        $received_Token = $this->input->request_headers('Authorization');
        $param =  $this->input->get();
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        $data = $this->db->get_where("module", ['course_id' => $id])->result();
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function my_get($id = 0)
	{
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        $userCouseData = array();
        $submoduleuser = array();
        $moduleuser = array();
        $maxmodule;
        $currentmodule;
        if ($id != 0) {
            $moduledata = $this->db->get_where("module", ['course_id' => $id])->result();
            $coursedata = $this->db->get_where("course", ['course_id' => $id])->row_array();
            // array_push($userCouseData, $coursedata);
            $enrolldata = $this->db->where('user_id' , $jwtData['id']) -> where('course_id' , $id)->get('enrollment')->row_array();
            foreach ($moduledata as $module) {
                $module = (array) $module;
                $submoduledata = $this->db->get_where("submodule", ['module_id' => $module['module_id']])->result();
                foreach ($submoduledata as $submodule) {
                    $max = 0;
                    $current = 0;
                    $submodule = (array) $submodule;
                    $titledata = $this->db->get_where("title", ['submodule_id' => $submodule['submodule_id']])->result();
                    $titleprogressdata = $this->db->get_where("titleprogress", ['enrollment_id' => $enrolldata['enrollment_id']])->result();
                    $max = count($titledata);
                    foreach ($titleprogressdata as $progress) {
                        foreach ($titledata as $title) {
                            $progress = (array) $progress;
                            $title = (array) $title;
                            if ($progress["title_id"] == $title["title_id"]) {
                                $current += 1;
                            }
                        }
                    }
                    $submodule = $submodule + array("current" => $current);
                    $submodule = $submodule + array("max" => $max);
                    array_push($submoduleuser, $submodule);
                }
                $module = $module + array("submodules" => $submoduleuser);
                array_push($moduleuser, $module);
            }
            $maxmodule = count($submoduledata);
            $currentmodule = count($moduleuser);
            $coursedata = $coursedata + array("current" => $currentmodule) + array("max" => $maxmodule) + array("modules" => $moduleuser);
            
            // $submoduledata = $this->db->get_where("submodule", ['submodule_id' => $titledata['submodule_id']])->result();
            $this->response($coursedata, REST_Controller::HTTP_OK);
        }else{
            $enrolldata = $this->db->get_where("enrollment", ['user_id' => $jwtData['id']])->result();
            foreach ($enrolldata as $data) {
                $data = (array) $data;
                $coursedata = $this->db->get_where("course", ['course_id' => $data['course_id']])->row_array();
                array_push($userCouseData, $coursedata);
            }
            $this->response($userCouseData, REST_Controller::HTTP_OK);
        }
        // $this->response($userCouseData, REST_Controller::HTTP_OK);
    }

    public function my_post()
	{
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        $jsonArray = json_decode($this->input->raw_input_stream, true);
        $time = array("start_time"=>date('Y-m-d H:i:s'));
        $jsonArray = $jsonArray + $time;
        $this->db->insert('enrollment', $jsonArray);
        $this->response($jsonArray, REST_Controller::HTTP_OK);
    }
    

    public function index_post()
	{
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }
        $jsonArray = json_decode($this->input->raw_input_stream, true);
        $this->db->set("course_name", $jsonArray["course_name"]);
        $this->db->set("course_description", $jsonArray["course_description"]);
        $this->db->set("course_image", $jsonArray["course_image"]);
        $this->db->set("category_id", $jsonArray["category_id"]);
        $this->db->insert('course');
        $courseId = $this->db->insert_id();
        foreach ($jsonArray["module"] as $jsonArrayModule) {
            $jsonArrayModule = (array) $jsonArrayModule;
            $this->db->set("module_name", $jsonArrayModule["module_name"]);
            $this->db->set("module_description", $jsonArrayModule["module_description"]);
            $this->db->set("module_image", $jsonArrayModule["module_image"]);
            $this->db->set("course_id", $courseId);
            $this->db->insert('module');
            $moduleId = $this->db->insert_id();
            foreach ($jsonArrayModule["submodule"] as $jsonArraySubModule ) {
                $jsonArraySubModule = (array) $jsonArraySubModule;
                $this->db->set("submodule_name", $jsonArraySubModule["submodule_name"]);
                $this->db->set("submodule_description", $jsonArraySubModule["submodule_description"]);
                $this->db->set("module_id", $moduleId);
                $this->db->insert('submodule');
                $submoduleId = $this->db->insert_id();
                foreach ($jsonArraySubModule["title"] as $jsonArraytitle) {
                    $jsonArraytitle = (array) $jsonArraytitle;
                    $this->db->set("title_name", $jsonArraytitle["title_name"]);
                    $this->db->set("title_description", $jsonArraytitle["title_description"]);
                    $this->db->set("title_type", $jsonArraytitle["title_type"]);
                    $this->db->set("submodule_id", $submoduleId);
                    $this->db->insert('title');
                    $titleId = $this->db->insert_id();
                    if ($jsonArraytitle["title_type"] == "QUIZ") {
                        foreach ($jsonArraytitle["choice"] as $jsonArraychoice) {
                            $jsonArraychoice = (array) $jsonArraychoice;
                            $this->db->set("choice", $jsonArraychoice["choice"]);
                            $this->db->set("answer", $jsonArraychoice["answer"]);
                            $this->db->set("title_id", $titleId);
                            $this->db->insert('quizchoice');
                        }
                    }
                }
            }
        }

        $this->response($jsonArray, REST_Controller::HTTP_OK);
    }

    public function index_delete($id){
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }

        $this->db->delete('enrollment', array('id'=>$id));
        $this->response(['Enrollment deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}