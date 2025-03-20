<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sumber extends MY_Controller {
    public function index() {
        $data = [
            'title' => 'Daftar Sumber Penjualan',
            'sumber' => $this->db->get('sumber')->result_array()
        ];
        $this->template->load('temp', 'produk/sumber', $data);
    }

    public function simpan() {
        $post = $this->input->post(NULL, TRUE);
        if ($this->db->where('sumber', $post['sumber'])->count_all_results('sumber')) {
            $this->set_flash('Sumber sudah ada!', 'error');
        } else {
            $this->db->insert('sumber', ['sumber' => $post['sumber']]);
            $this->set_flash('Sumber berhasil ditambahkan', 'success');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update() {
        $post = $this->input->post(NULL, TRUE);
        if ($this->db->where(['sumber' => $post['sumber'], 'id_sumber !=' => $post['id_sumber']])->count_all_results('sumber')) {
            $this->set_flash('Sumber sudah digunakan!', 'error');
        } else {
            $this->db->where('id_sumber', $post['id_sumber'])->update('sumber', ['sumber' => $post['sumber']]);
            $this->set_flash('Data sumber berhasil diperbarui', 'success');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hapus($id) {
        $this->db->where('id_sumber', $id)->delete('sumber') 
            ? $this->set_flash('Data sumber berhasil dihapus', 'success')
            : $this->set_flash('Gagal menghapus data sumber', 'error');
        redirect($_SERVER['HTTP_REFERER']);
    }
}