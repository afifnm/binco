<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pelanggan extends MY_Controller {
	public function index(){
        $data = [
            'title' => 'Daftar Pelanggan',
            'rows' => $this->db->get('pelanggan')->result_array()
        ];
		$this->template->load('temp','bahan/pelanggan',$data);
	}
	public function transaksi($id_pelanggan){
		$data = [
			'title' => 'Daftar Transaksi Pelanggan',
			'bahan' => $this->db->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left')
					->where('a.id_pelanggan', $id_pelanggan)
					->order_by('invoice','DESC')
                    ->get('bahan_keluar a')
                    ->result_array(),
			'pelanggan' => $this->db->order_by('nama','ASC')->get('pelanggan')->result_array()
		];
		$this->template->load('temp','bahan/bahanKeluar',$data);
    }
	public function simpan() {
		$post = $this->input->post();
		if ($this->db->get_where('pelanggan', ['nama' => $post['nama']])->num_rows() > 0) {
			$this->set_flash('Gagal memasukan, cek kembali nama pelanggan','error');
		} else {
			$this->db->insert('pelanggan', [
				'nama' => $post['nama'],
				'alamat' => $post['alamat'],
				'telp' => $post['telp']
			]);
			$this->set_flash('Pelanggan berhasil disimpan','success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update() {
        $post = $this->input->post();
		$cek_nama = $this->db->where('nama', $post['nama'])
                             ->where('id_pelanggan !=', $post['id_pelanggan'])
							 ->get('pelanggan')
							 ->row();
		if ($cek_nama) {
			$this->set_flash('Nama sudah digunakan!','error');
		} else {
			$data = [
				'nama' => $post['nama'],
				'alamat' => $post['alamat'],
				'telp' => $post['telp']
			];
			$this->db->where('id_pelanggan', $post['id_pelanggan']);
			$this->db->update('pelanggan', $data);
			$this->set_flash('Data pelanggan berhasil diperbarui','success');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function hapus($id) {
		$this->db->where('id_pelanggan', $id);
		$this->db->delete('pelanggan');
		$this->set_flash('Data pelanggan berhasil dihapus','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
}
