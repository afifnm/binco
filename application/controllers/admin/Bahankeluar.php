<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bahankeluar extends MY_Controller {
	public function index(){
		$data = [
			'title' => 'Daftar Penjualan Bahan',
			'bahan' => $this->db->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left')
					->order_by('invoice','DESC')
                    ->get('bahan_keluar a')
                    ->result_array(),
			'pelanggan' => $this->db->get('pelanggan')->result_array()
		];
		$this->template->load('temp','bahan/bahanKeluar',$data);
    }
	public function invoice($invoice){
		$data = [
			'title' => 'penjualan #'.$invoice,
			'row'   => $this->db->select('a.*, b.*, c.nama as namauser')
						->where('invoice', $invoice)
						->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left')
						->join('user c', 'a.username = c.username', 'left')
						->get('bahan_keluar a')->row(),
			'details' => $this->db->select('a.*, b.bahan')
						->join('bahan b', 'a.id_bahan = b.id_bahan', 'left')
						->where('invoice', $invoice)
						->get('bahan_keluar_detail a')->result_array(),
		];
		$this->template->load('temp','bahan/bahanKeluarInvoice',$data);
    }
	public function cancel($invoice){
		// Update status to 0 (canceled)
		$this->db->where('invoice', $invoice)->update('bahan_keluar', ['status' => 0]);       
		// Get the details of the canceled items
		$details = $this->db->where('invoice', $invoice)->get('bahan_keluar_detail')->result_array();
		foreach ($details as $item) {
			$this->db->set('stok', 'stok + ' . $item['jumlah'], FALSE)
					 ->where('id_bahan', $item['id_bahan'])
					 ->update('bahan_stok'); // update stock
			$log = [
				'invoice'	=> $invoice,
				'tipe'   	=> 'pembatalan',
				'jumlah'	=> $item['jumlah'],
				'harga_satuan'	=> $item['harga_jual'],
				'id_bahan'		=> $item['id_bahan']
			];
			$this->db->insert('bahan_log', $log); // insert into log
		}
		$this->set_flash('penjualan dibatalkan','success');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function transaksi($id_pelanggan=NULL){
		if($id_pelanggan==NULL){ redirect('admin/bahanKeluar'); }
		$data = array(
			'title'			=> 'Transaksi Penjualan Bahan #'.$this->Func_model->nota2(),
			'nota'			=> $this->Func_model->nota2(),
			'id_pelanggan'	=> $id_pelanggan,
			'keranjang'		=> isset($_COOKIE['keranjang']) ? json_decode($_COOKIE['keranjang'], true) : [],
			'bahan' 		=> $this->db->where('b.stok >', 0)
                            ->join('bahan_stok b', 'a.id_bahan = b.id_bahan', 'left')
                            ->get('bahan a')->result_array()
		);
		$this->template->load('temp','bahan/bahanKeluarTransaksi',$data);
	}
	public function tambahKeranjang() {
		$id_bahan = $this->input->post('id_bahan');
		$jumlah = (int) $this->input->post('jumlah');
		$harga = (int) $this->input->post('harga');
		// Ambil stok dari database
		$bahan = $this->db->get_where('bahan_stok', ['id_bahan' => $id_bahan])->row();
		if (!$bahan) {
			$this->set_flash('Bahan tidak ditemukan.', 'error');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$stok_tersedia = (int) $bahan->stok;
		$keranjang = get_cookie('keranjang');
		$keranjang = $keranjang ? json_decode($keranjang, true) : [];
		// Cek apakah bahan sudah ada di keranjang
		$index = array_search($id_bahan, array_column($keranjang, 'id_bahan'));
		if ($index !== false) {
			$jumlah_baru = $keranjang[$index]['jumlah'] + $jumlah;
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
			// Update jumlah di keranjang
			$keranjang[$index]['jumlah'] = $jumlah_baru;
		} else {
			// Tambahkan item baru ke keranjang
			$keranjang[] = [
				'id_bahan' => $id_bahan,
				'jumlah'   => $jumlah,
				'harga'    => $harga,
			];
		}
		// Simpan kembali ke cookie
		set_cookie('keranjang', json_encode($keranjang), 86400);
		$this->set_flash('Berhasil menambah daftar penjualan', 'success');
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function hapus($id_bahan){
		$keranjang = isset($_COOKIE['keranjang']) ? json_decode($_COOKIE['keranjang'], true) : [];
		$keranjang = array_filter($keranjang, function ($item) use ($id_bahan) {
			return $item['id_bahan'] != $id_bahan;
		});
		setcookie('keranjang', json_encode(array_values($keranjang)), time() + (86400 * 30), "/");
		$this->set_flash('Berhasil menghapus dari daftar penjualan','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function checkout() {
		$post = $this->input->post();
		$invoice = $this->Func_model->nota2();
		$keranjang = get_cookie('keranjang');
		$keranjang = $keranjang ? json_decode($keranjang, true) : [];
		if (!empty($keranjang)) {
			foreach ($keranjang as $item) {
				$data = [
					'id_bahan'   => $item['id_bahan'],
					'jumlah'     => $item['jumlah'],
					'invoice'	 => $invoice,
					'harga_jual' => $item['harga']
				];
				$this->db->insert('bahan_keluar_detail', $data); //input ke detail
				$this->db->set('stok', 'stok - ' . $item['jumlah'], FALSE)
						->where('id_bahan', $item['id_bahan'])
						->update('bahan_stok'); //ubah stok bahan
				$log = [
					'invoice'	=> $invoice,
					'tipe'   	=> 'penjualan',
					'jumlah'	=> $item['jumlah'],
					'harga_satuan'	=> $item['harga'],
					'id_bahan'		=> $item['id_bahan']
				];
				$this->db->insert('bahan_log',$log); //input ke tabel bahan masuk (penjualan)
			}
			delete_cookie('keranjang');
			$databeli = [
				'invoice'	=> $invoice,
				'username'	=> $this->session->userdata('username'),
				'id_pelanggan'	=> $post['id_pelanggan'],
				'status'	=> true,
				'total'		=> $post['total']
			];
			$this->db->insert('bahan_keluar',$databeli); //input ke tabel bahan masuk (penjualan)
			$this->set_flash('Pembayaran berhasil dilakukan','success'); //input ke invoice
			redirect('admin/bahankeluar/invoice/'.$invoice);
		} else {
			$this->set_flash('Pembayaran gagal dilakukan, restart ulang browser','error');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
}
