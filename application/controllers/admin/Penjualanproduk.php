<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualanproduk extends MY_Controller {
	public function index(){
		$data = [
			'title' => 'Daftar Penjualan Produk',
			'penjualan' => $this->db->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left')
					->order_by('invoice','DESC')
                    ->get('produk_penjualan a')
                    ->result_array(),
			'pelanggan' => $this->db->get('pelanggan')->result_array()
		];
		$this->template->load('temp','produk/penjualan_index',$data);
    }
	public function transaksi($id_pelanggan=NULL){
		if($id_pelanggan==NULL){ redirect('admin/penjualanproduk'); }
		$data = array(
			'title'			=> 'Transaksi Penjualan Produk #'.$this->Func_model->nota3(),
			'nota'			=> $this->Func_model->nota3(),
			'id_pelanggan'	=> $id_pelanggan,
			'keranjangproduk'		=> isset($_COOKIE['keranjangproduk']) ? json_decode($_COOKIE['keranjangproduk'], true) : [],
			'produk' 		=> $this->db->where('stok >', 0)
                            ->get('produk')->result_array()
		);
		$this->template->load('temp','produk/transaksi',$data);
	}
	public function invoice($invoice){
		$data = [
			'title' => 'Penjualan #'.$invoice,
			'row'   => $this->db->select('a.*, b.*, c.nama as namauser, d.sumber')
						->where('invoice', $invoice)
						->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left')
						->join('user c', 'a.username = c.username', 'left')
						->join('sumber d', 'a.id_sumber = d.id_sumber', 'left')
						->get('produk_penjualan a')->row(),
			'details' => $this->db->select('a.*, b.nama')
						->join('produk b', 'a.id_produk = b.id_produk', 'left')
						->where('invoice', $invoice)
						->get('produk_penjualan_detail a')->result_array(),
		];
		$this->template->load('temp','produk/invoice',$data);
    }
	public function cancel($invoice){
		// Update status to 0 (canceled)
		$this->db->where('invoice', $invoice)->update('produk_penjualan', ['status' => 0]);       
		// Get the details of the canceled items
		$details = $this->db->where('invoice', $invoice)->get('produk_penjualan_detail')->result_array();
		$id_sumber = $this->db->where('invoice', $invoice)->get('produk_penjualan')->row()->id_sumber;
		foreach ($details as $item) {
			$this->db->set('stok', 'stok + ' . $item['jumlah'], FALSE)
					 ->where('id_produk', $item['id_produk'])
					 ->update('produk'); // update stock
				$log = [
					'invoice'	=> $invoice,
					'tipe'   	=> 'penjualan',
					'jumlah'	=> $item['jumlah'],
					'harga_satuan'	=> $item['harga_jual'],
					'id_produk'		=> $item['id_produk'],
					'id_sumber'	=> $id_sumber
				];
			$this->db->insert('produk_log', $log); // insert into log
		}
		$this->set_flash('Penjualan dibatalkan','success');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function tambahKeranjang() {
		$id_produk = $this->input->post('id_produk');
		$jumlah = (int) $this->input->post('jumlah');
		$harga = (int) $this->input->post('harga');
		// Ambil stok dari database
		$produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->row();
		if (!$produk) {
			$this->set_flash('produk tidak ditemukan.', 'error');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$stok_tersedia = (int) $produk->stok;
		$keranjangproduk = get_cookie('keranjangproduk');
		$keranjangproduk = $keranjangproduk ? json_decode($keranjangproduk, true) : [];
		// Cek apakah produk sudah ada di keranjangproduk
		$index = array_search($id_produk, array_column($keranjangproduk, 'id_produk'));
		if ($index !== false) {
			$jumlah_baru = $keranjangproduk[$index]['jumlah'] + $jumlah;
		} else {
			$jumlah_baru = $jumlah;
		}
		// Periksa apakah stok mencukupi
		if ($jumlah_baru > $stok_tersedia) {
			$this->set_flash('Stok tidak mencukupi.', 'error');
			redirect($_SERVER['HTTP_REFERER']);
			return;
		}
		if ($index !== false) {
			// Update jumlah di keranjangproduk
			$keranjangproduk[$index]['jumlah'] = $jumlah_baru;
		} else {
			// Tambahkan item baru ke keranjangproduk
			$keranjangproduk[] = [
				'id_produk' => $id_produk,
				'jumlah'   => $jumlah,
				'harga'    => $harga,
			];
		}
		// Simpan kembali ke cookie
		set_cookie('keranjangproduk', json_encode($keranjangproduk), 86400);
		$this->set_flash('Berhasil menambah daftar penjualan', 'success');
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function hapus($id_produk){
		$keranjangproduk = isset($_COOKIE['keranjangproduk']) ? json_decode($_COOKIE['keranjangproduk'], true) : [];
		$keranjangproduk = array_filter($keranjangproduk, function ($item) use ($id_produk) {
			return $item['id_produk'] != $id_produk;
		});
		setcookie('keranjangproduk', json_encode(array_values($keranjangproduk)), time() + (86400 * 30), "/");
		$this->set_flash('Berhasil menghapus dari daftar penjualan','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function checkout() {
		$post = $this->input->post();
		$invoice = $this->Func_model->nota3();
		$keranjangproduk = get_cookie('keranjangproduk');
		$keranjangproduk = $keranjangproduk ? json_decode($keranjangproduk, true) : [];
		if (!empty($keranjangproduk)) {
			foreach ($keranjangproduk as $item) {
				$data = [
					'id_produk'   => $item['id_produk'],
					'jumlah'     => $item['jumlah'],
					'invoice'	 => $invoice,
					'harga_jual' => $item['harga']
				];
				$this->db->insert('produk_penjualan_detail', $data); //input ke detail
				$this->db->set('stok', 'stok - ' . $item['jumlah'], FALSE)
						->where('id_produk', $item['id_produk'])
						->update('produk'); //ubah stok produk
				$log = [
					'invoice'	=> $invoice,
					'tipe'   	=> 'penjualan',
					'jumlah'	=> $item['jumlah'],
					'harga_satuan'	=> $item['harga'],
					'id_produk'		=> $item['id_produk'],
					'id_sumber'	=> $post['sumber_penjualan']
				];
				$this->db->insert('produk_log',$log); //input ke tabel produk masuk (penjualan)
			}
			delete_cookie('keranjangproduk');
			$databeli = [
				'invoice'	=> $invoice,
				'username'	=> $this->session->userdata('username'),
				'id_pelanggan'	=> $post['id_pelanggan'],
				'status'	=> true,
				'total'		=> $post['total'],
				'id_sumber'	=> $post['sumber_penjualan']
			];
			$this->db->insert('produk_penjualan',$databeli); //input ke tabel produk masuk (penjualan)
			$this->set_flash('Pembayaran berhasil dilakukan','success'); //input ke invoice
			redirect('admin/penjualanproduk/invoice/'.$invoice);
		} else {
			$this->set_flash('Pembayaran gagal dilakukan, restart ulang browser','error');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
}