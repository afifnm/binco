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
    public function namapelanggan($id_pelanggan){
        $this->db->where('id_pelanggan', $id_pelanggan)->from('pelanggan');
        return $this->db->get()->row()->nama;
    }
    public function namaproduk($id_produk){
        $this->db->where('id_produk', $id_produk)->from('produk');
        return $this->db->get()->row()->nama;
    }
    public function nota1(){
        $tanggal = date('Y-m');
        $nota = 'B'.date('ymd').$this->session->userdata('id_user').($this->db->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal)
        ->count_all_results('bahan_masuk') + 1);
        return $nota;
    }
    public function nota2(){
        $tanggal = date('Y-m');
        $nota = 'S'.date('ymd').$this->session->userdata('id_user').($this->db->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal)
        ->count_all_results('bahan_keluar') + 1);
        return $nota;
    }
    public function nota3(){
        $tanggal = date('Y-m');
        $nota = 'P'.date('ymd').$this->session->userdata('id_user').($this->db->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal)
        ->count_all_results('produk_penjualan') + 1);
        return $nota;
    }
}