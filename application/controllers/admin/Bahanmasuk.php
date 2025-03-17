<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bahanmasuk extends MY_Controller {
	public function index(){
		$data = [
			'title' => 'Daftar Pembelian Bahan Masuk',
			'bahan' => $this->db->join('supplier b', 'a.id_supplier = b.id_supplier', 'left')
					->order_by('invoice','DESC')
                    ->get('bahan_masuk a')
                    ->result_array(),
			'supplier' => $this->db->order_by('nama','ASC')->get('supplier')->result_array()
		];
		$this->template->load('temp','bahan/bahanMasuk',$data);
    }
	public function invoice($invoice){
		$data = [
			'title' => 'Pembelian #'.$invoice,
			'row'   => $this->db->select('a.*, b.*, c.nama as namauser')
						->where('invoice', $invoice)
						->join('supplier b', 'a.id_supplier = b.id_supplier', 'left')
						->join('user c', 'a.username = c.username', 'left')
						->get('bahan_masuk a')->row(),
			'details' => $this->db->select('a.*, b.bahan')
						->join('bahan b', 'a.id_bahan = b.id_bahan', 'left')
						->where('invoice', $invoice)
						->get('bahan_masuk_detail a')->result_array(),
		];
		$this->template->load('temp','bahan/bahanMasukInvoice',$data);
    }
	public function cancel($invoice){
		// Update status to 0 (canceled)
		$this->db->where('invoice', $invoice)->update('bahan_masuk', ['status' => 0]);       
		// Get the details of the canceled items
		$details = $this->db->where('invoice', $invoice)->get('bahan_masuk_detail')->result_array();
		foreach ($details as $item) {
			$this->db->set('stok', 'stok - ' . $item['jumlah'], FALSE)
					 ->where('id_bahan', $item['id_bahan'])
					 ->update('bahan_stok'); // update stock
			$log = [
				'invoice'	=> $invoice,
				'tipe'   	=> 'pembatalan',
				'jumlah'	=> $item['jumlah'],
				'harga_satuan'	=> $item['harga_beli'],
				'id_bahan'		=> $item['id_bahan']
			];
			$this->db->insert('bahan_log', $log); // insert into log
		}
		$this->set_flash('Pembelian dibatalkan','success');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function transaksi($id_supplier=NULL){
		if($id_supplier==NULL){ redirect('admin/bahanmasuk'); }
		$data = array(
			'title'			=> 'Transaksi Pembelian Bahan #'.$this->Func_model->nota(),
			'nota'			=> $this->Func_model->nota(),
			'id_supplier'	=> $id_supplier,
			'keranjang'		=> isset($_COOKIE['keranjang_bahan']) ? json_decode($_COOKIE['keranjang_bahan'], true) : [],
			'bahan' 		=> $this->db->order_by('bahan','ASC')->get('bahan')->result_array()
		);
		$this->template->load('temp','bahan/bahanMasukTransaksi',$data);
	}
	public function tambahKeranjang() {
		$item = [
			'id_bahan'   => $this->input->post('id_bahan'),
			'jumlah'     => $this->input->post('jumlah'),
			'kadar_air'  => $this->input->post('kadar_air'),
			'berat'      => $this->input->post('berat'),
			'harga'      => $this->input->post('harga'),
		];
		$keranjang = get_cookie('keranjang_bahan');
		$keranjang = $keranjang ? json_decode($keranjang, true) : [];
		$keranjang[] = $item;
		set_cookie('keranjang_bahan', json_encode($keranjang), 86400);
		$this->set_flash('Berhasil menambah daftar pembelian','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function hapus($id_bahan){
		$keranjang = isset($_COOKIE['keranjang_bahan']) ? json_decode($_COOKIE['keranjang_bahan'], true) : [];
		$keranjang = array_filter($keranjang, function ($item) use ($id_bahan) {
			return $item['id_bahan'] != $id_bahan;
		});
		setcookie('keranjang_bahan', json_encode(array_values($keranjang)), time() + (86400 * 30), "/");
		$this->set_flash('Berhasil menghapus dari daftar pembelian','success');
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function checkout() {
		$post = $this->input->post();
		$invoice = $this->Func_model->nota();
		$keranjang = get_cookie('keranjang_bahan');
		$keranjang = $keranjang ? json_decode($keranjang, true) : [];
		if (!empty($keranjang)) {
			foreach ($keranjang as $item) {
				$data = [
					'id_bahan'   => $item['id_bahan'],
					'jumlah'     => $item['jumlah'],
					'invoice'	 => $invoice,
					'kadar_air'  => $item['kadar_air'],
					'berat'      => $item['berat'],
					'harga_beli' => $item['harga']
				];
				$this->db->insert('bahan_masuk_detail', $data); //input ke detail
				$this->db->set('stok', 'stok + ' . $item['jumlah'], FALSE)
						->where('id_bahan', $item['id_bahan'])
						->update('bahan_stok'); //ubah stok bahan
				$log = [
					'invoice'	=> $invoice,
					'tipe'   	=> 'pembelian',
					'jumlah'	=> $item['jumlah'],
					'harga_satuan'	=> $item['harga'],
					'id_bahan'		=> $item['id_bahan']
				];
				$this->db->insert('bahan_log',$log); //input ke tabel bahan masuk (pembelian)
			}
			delete_cookie('keranjang_bahan');
			$databeli = [
				'invoice'	=> $invoice,
				'username'	=> $this->session->userdata('username'),
				'id_supplier'	=> $post['id_supplier'],
				'status'	=> true,
				'total'		=> $post['total']
			];
			$this->db->insert('bahan_masuk',$databeli); //input ke tabel bahan masuk (pembelian)
			$this->set_flash('Pembayaran berhasil dilakukan','success'); //input ke invoice
			redirect('admin/bahanmasuk/invoice/'.$invoice);
		} else {
			$this->set_flash('Pembayaran gagal dilakukan, restart ulang browser','error');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
}
