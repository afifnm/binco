<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Produk extends MY_Controller {
	public function index(){
		$data = [
			'title' => 'Daftar Produk',
			'produk' => $this->db->get('produk')->result_array()
		];
		$this->template->load('temp','produk/index',$data);
	}
	public function log($id_produk){
		$data = [
			'title' => 'Log produk',
			'logs' => $this->db->where('id_produk', $id_produk)
								->order_by('id_log', 'ASC')
								->get('produk_log')
								->result_array(),
			'produk' => $this->db->where('a.id_produk', $id_produk)
								->join('produk_stok', 'a.id_produk = produk_stok.id_produk', 'left')
								->get('produk a')
								->row()
		];
		$this->template->load('temp','produk/logproduk',$data);
	}
	public function simpan() {
		$post = $this->input->post();
		if ($this->db->get_where('produk', ['nama' => $post['nama']])->num_rows() > 0) {
			$this->set_flash('Gagal memasukan, cek kembali nama produk','error');
		} else {
			$this->db->insert('produk', [
				'nama' => $post['nama'],
				'stok' => $post['stok'],
				'harga' => $post['harga']
			]);
			$this->set_flash('Produk berhasil ditambahkan','success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update() {
		$id = $this->input->post('id_produk');
		$nama_produk = $this->input->post('nama');
		$cek_nama = $this->db->where('nama', $nama_produk)
							 ->where('id_produk !=', $id)
							 ->get('produk')
							 ->row();
		if ($cek_nama) {
			$this->set_flash('Nama produk sudah digunakan!','error');
		} else {
			$data = [
				'nama' => $nama_produk,
				'harga' => $this->input->post('harga'),
				'stok' => $this->input->post('stok')
			];
			$this->db->where('id_produk', $id);
			$this->db->update('produk', $data);
			$this->set_flash('Data produk berhasil diperbarui','success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function hapus($id) {
		$this->db->where('id_produk', $id)->delete('produk');
		$this->set_flash('Data produk berhasil dihapus','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
