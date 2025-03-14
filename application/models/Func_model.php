<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Func_model extends CI_Model{
    public function namaBahan($id_bahan){
        $this->db->where('id_bahan', $id_bahan)->from('bahan');
        return $this->db->get()->row()->bahan;
    }
    public function namaSupplier($id_supplier){
        $this->db->where('id_supplier', $id_supplier)->from('supplier');
        return $this->db->get()->row()->nama;
    }
    public function nota(){
        $tanggal = date('Y-m');
        $nota = date('ymd').$this->session->userdata('id_user').($this->db->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal)
        ->count_all_results('bahan_masuk') + 1);
        return $nota;
    }
}