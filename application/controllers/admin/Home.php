<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
	public function index(){
		date_default_timezone_set("Asia/Jakarta");
		$data = array(
			'title' => 'Dashboard',
		);
		$this->template->load('temp','dashboard',$data);
	}
}
