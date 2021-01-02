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
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }

        $data = $this->db->get("category")->result();
        $this->response($data, REST_Controller::HTTP_OK);
    }
    
    public function index_post(){
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }

        $jsonArray = json_decode($this->input->raw_input_stream, true);
        $this->db->insert('category', $jsonArray);
        $this->response(['Category created successfully.'], REST_Controller::HTTP_OK);
    }

    public function index_delete($id){
        $received_Token = $this->input->request_headers('Authorization');
        if (isset($received_Token['Authorization'])){
            $jwtData = $this->tokenHandler->DecodeToken($received_Token['Authorization']);
        }

        $this->db->delete('category', array('id'=>$id));
        $this->response(['category deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}