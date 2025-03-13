<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplierbahan extends MY_Controller {
	public function index() {
		date_default_timezone_set("Asia/Jakarta");
		$data = [
			'title' => 'Daftar Supplier',
			'supplier' => $this->db->get('supplier')->result_array()
		];
		$this->template->load('temp', 'bahan/supplier', $data);
	}

	public function simpan() {
		$post = $this->input->post();
		if ($this->db->get_where('supplier', ['nama' => $post['nama']])->num_rows() > 0) {
			$this->set_flash('Gagal memasukkan, nama supplier sudah digunakan', 'error');
		} else {
			$this->db->insert('supplier', [
				'nama' => $post['nama'],
				'alamat' => $post['alamat'],
				'telp' => $post['telp']
			]);
			$this->set_flash('Supplier berhasil disimpan', 'success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function update() {
		$id = $this->input->post('id_supplier');
		$nama = $this->input->post('nama');
		$cek_nama = $this->db->where('nama', $nama)
						 ->where('id_supplier !=', $id)
						 ->get('supplier')
						 ->row();
		if ($cek_nama) {
			$this->set_flash('Nama supplier sudah digunakan!', 'error');
		} else {
			$data = [
				'nama' => $nama,
				'alamat' => $this->input->post('alamat'),
				'telp' => $this->input->post('telp')
			];
			$this->db->where('id_supplier', $id);
			$this->db->update('supplier', $data);
			$this->set_flash('Data supplier berhasil diperbarui', 'success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function hapus($id) {
		$this->db->where('id_supplier', $id);
		$this->db->delete('supplier');
		$this->set_flash('Data supplier berhasil dihapus', 'success');
		redirect($_SERVER['HTTP_REFERER']);
	}
}