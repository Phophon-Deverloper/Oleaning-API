<?php
   
   require APPPATH . 'libraries/REST_Controller.php';
   require APPPATH . '/libraries/TokenHandler.php';
     
class Category extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tokenHandler = new TokenHandler();
    }

	public function index_get()
	{
        $received_Token = $this->input->request_headers('authorization');
        if (isset($received_Token['authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['authorization']);
            $data = $this->db->get("category")->result();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    
    public function index_post(){
        $received_Token = $this->input->request_headers('authorization');
        if (isset($received_Token['authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['authorization']);
            $jsonArray = json_decode($this->input->raw_input_stream, true);
            if ($jsonArray["category_name"] == []) {
                $this->response(REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $this->db->insert('category', $jsonArray);
                $this->response(REST_Controller::HTTP_CREATED);
            }
        }else {
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    public function index_delete($id){
        $received_Token = $this->input->request_headers('authorization');
        if (isset($received_Token['authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['authorization']);
            if ($id == 0) {
                $this->response(REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $this->db->delete('category', array('id'=>$id));
                $this->response(REST_Controller::HTTP_OK);
            }
        }else{
            $this->response(REST_Controller::HTTP_UNAUTHORIZED);
        }

    }
    	
}