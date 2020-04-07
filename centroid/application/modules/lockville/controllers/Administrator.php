<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	class Administrator extends MY_Controller{
		public $view = array();

		function __construct(){
			parent::__construct();
			
		}

		public function index(){
			$this->load->view('a.php', $this->view);
		}
	}
	




