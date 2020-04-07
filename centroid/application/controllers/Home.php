<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data = array();

class Home extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->data['header'] = "include/header.php";        
        $this->data['footer'] = "include/footer.php";
    }

    public function index(){
        $user = $this->session->userdata("userdata");
        if(isset($user)){
            redirect(URL_PATH.'dashboard', 'refresh');
        }else{
            //$this->data['history'] = $this->History_model->getHistory();
            // print_r($this->data['history_data']);
            // exit;
            $this->data['content'] = "home/home.php";
            $this->load->view("container.php", $this->data);
        }
    }
	
	public function adduser($role){
		
		$this->load->database();
		$this->load->model('Import_Model', 'import');
		$this->data['role']=$role;	
		$this->data['instructordata'] = $this->import->getDataList("tbl_account");
		$this->data['parentdata'] = $this->import->getDataList("tbl_guardian");
		$this->load->view("register.php", $this->data);
        
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(URL_PATH.'home', 'refresh');
    }

    public function login(){
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $result['error'] = "1";
            $result['msg'] = "Please fill all fields";
        }
        else
        {
            $user = $this->User_model->getUser($_POST);
            if(count($user) > 0){
                $this->session->set_userdata("userdata", $user[0]);
                $result['error'] = "0";
                $result['msg'] = "Success";
            }else{
                $result['error'] = "1";
                $result['msg'] = "Invalid user";
            }
        }
        echo json_encode($result);
    }

    public function registe(){
        $this->form_validation->set_rules('r_username', 'Username', 'required');
        $this->form_validation->set_rules('r_password', 'Password', 'required');
        $this->form_validation->set_rules('r_email', 'Email', 'required');
        $this->form_validation->set_rules('r_repeatpwd', 'Repeatpwd', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $result['error'] = "1";
            $result['msg'] = "Please fill all fields";
        }
        else
        {
            if($this->User_model->userRegister($_POST)){
                $result['error'] = "0";
                $result['msg'] = "Success";
            }else{
                $result['error'] = "1";
                $result['msg'] = "Invalid user";
            }
        }
        echo json_encode($result);
    }
}
