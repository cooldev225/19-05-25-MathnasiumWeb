<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data = array();

class User_dir extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->data['header'] = "include/header.php";        
        $this->data['footer'] = "include/footer.php";
    }

    public function index(){
        $this->data['content'] = "user/user_container.php";
        $this->data['left'] = "left.php";
        $this->data['main'] = "directory/directory.php";
        $this->load->view("container.php", $this->data);
    }
}
