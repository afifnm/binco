<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bahan extends MY_Controller {
	public function index(){
		date_default_timezone_set("Asia/Jakarta");
		$data = array(
			'title' => 'Daftar Bahan',
		);
		$this->template->load('temp','bahan/daftarBahan',$data);
	}
}
