<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bahan extends MY_Controller {
	public function index(){
		date_default_timezone_set("Asia/Jakarta");
		$data = [
			'title' => 'Daftar Bahan',
			'bahan' => $this->db->join('bahan_stok', 'bahan.id_bahan = bahan_stok.id_bahan', 'left')
                    ->get('bahan')
                    ->result_array()
		];
		$this->template->load('temp','bahan/daftarBahan',$data);
	}
	public function simpan() {
		$post = $this->input->post();
		if ($this->db->get_where('bahan', ['bahan' => $post['bahan']])->num_rows() > 0) {
			$this->set_flash('Gagal memasukan, cek kembali nama bahan','error');
		} else {
			$this->db->insert('bahan', [
				'bahan' => $post['bahan'],
				'harga' => $post['harga']
			]);
			$this->set_flash('Bahan berhasil disimpan','success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update() {
		$id = $this->input->post('id_bahan');
		$nama_bahan = $this->input->post('bahan');
		$cek_nama = $this->db->where('bahan', $nama_bahan)
							 ->where('id_bahan !=', $id)
							 ->get('bahan')
							 ->row();
		if ($cek_nama) {
			$this->set_flash('Nama bahan sudah digunakan!','error');
		} else {
			$data = [
				'bahan' => $nama_bahan,
				'harga' => $this->input->post('harga')
			];
			$this->db->where('id_bahan', $id);
			$this->db->update('bahan', $data);
			$this->set_flash('Data bahan berhasil diperbarui','success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function hapus($id) {
		$this->db->where('id_bahan', $id);
		$this->db->delete('bahan');
		$this->set_flash('Data bahan berhasil dihapus','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
