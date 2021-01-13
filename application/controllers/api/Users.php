<?php
   
require APPPATH . '/libraries/TokenHandler.php';
require APPPATH . 'libraries/REST_Controller.php';
     
class Users extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

    public function index_get()
	{
            $data = $this->db->get("users")->result();
            $this->response($data, REST_Controller::HTTP_OK);
    }

	public function profile_get()
	{
            $star = array("star"=>0);
            $progress = array("progress"=>0);
            $received_Token = $this->input->request_headers('Authorization');
            if (isset($received_Token['Authorization'])){
                $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
                $userdata = $this->db->get_where("users", ['id' => $jwtData['id']])->row_array();
                $coursedata= $this->db->get_where("enrollment", ['user_id' => $userdata['id']])->result();
                foreach ($coursedata as $dataobj) {
                    $data = (array)$dataobj;
                    $titledata = $this->db->get_where("titleprogress", ['enrollment_id' => $data['enrollment_id']])->row_array();
                    $progress['progress'] += 1 ;
                    $star['star'] = $star['star'] + $titledata['star'];
                }
                $userdata = $userdata + $star + $progress;
                $this->response($userdata, REST_Controller::HTTP_OK);
            }else{
                $this->response(REST_Controller::HTTP_UNAUTHORIZED);
            }
    }

    public function index_post(){
        $jsonArray = json_decode($this->input->raw_input_stream, true);
        $userdata = $this->db->get_where("users", ['email' => $jsonArray['email']])->row_array();
        if (count($userdata) == 0) {
            $this->db->insert('users', $jsonArray);
            $userdata = $this->db->get_where("users", ['email' => $jsonArray['email']])->row_array();
            if ($jsonArray['password'] == $userdata['password']) {
                $jwttoken = $this->tokenHandler->GenerateToken($userdata);
                $this->response($jwttoken, REST_Controller::HTTP_CREATED);
            }
        }else{
            $this->response(['User has account.'], REST_Controller::HTTP_OK);
        }
    }

    public function resetpassword_patch()
    {
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
            $jsonArray = json_decode($this->input->raw_input_stream, true);
            if ($jsonArray == []) {
                $this->response(REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $data = $this->db->get_where("users", ['id' => $jwtData['id']])->row_array();
                if ($data['password'] == $jsonArray['oldpassword']) {
                    $this->db->set('password', $jsonArray['newpassword']);
                    $this->db->where('id', $id);
                    $this->db->update('users');
                    $this->response(REST_Controller::HTTP_OK);
                }else {
                    $this->response(REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }else {
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function profile_put()
    {
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
            $jsonArray = json_decode($this->input->raw_input_stream, true);
            if ($jsonArray == []) {
                $this->response(REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $this->db->update('users', $jsonArray, array('id'=>$jwtData['id']));
                $this->response(REST_Controller::HTTP_OK);
            }
        }else {
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    	
}
?>