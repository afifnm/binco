<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('login')!=="Backend"){
			redirect('auth');
		}
	}
	public function index(){
		$this->db->select('penjualan.*, pelanggan.nama')->from('penjualan')->order_by('id_penjualan','DESC');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan = penjualan.id_pelanggan');
        $user = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Penjualan',
			'user'			=> $user,
			'pelanggan'		=> $this->View_model->get_pelanggan()
		);
		$this->template->load('temp','penjualan_index',$data);
	}
	public function laporan(){
		$tanggal1 = $this->input->get('tanggal1');
        $tanggal2 = $this->input->get('tanggal2');
		// Base query to retrieve sales
		$sql = "
			SELECT 
				p.kode_penjualan,
				p.id_penjualan,
				p.tanggal,
				p.total_harga,
				p.id_pelanggan,
				p.bayar,
				p.pembayaran,
				p.bukti,
				p.transaksi,
				dp.id_produk,
				pr.nama,
				dp.jumlah,
				dp.harga
			FROM 
				penjualan p
			JOIN 
				detail_penjualan dp ON p.kode_penjualan = dp.kode_penjualan
			JOIN 
				produk pr ON dp.id_produk = pr.id_produk
		";

		// Check if the date range is provided
		if (!empty($tanggal1) && !empty($tanggal2)) {
			$sql .= " WHERE p.tanggal BETWEEN ? AND ?";
			$query = $this->db->query($sql, array($tanggal1, $tanggal2));
		} else {
			$sql .= " ORDER BY p.tanggal DESC";
			$query = $this->db->query($sql);
		}

		// Get the result
		$penjualan = $query->result_array();

		$data = array(
			'laporan_penjualan'		=> $penjualan,
			'tanggal1'		=> $tanggal1,
			'tanggal2'		=> $tanggal2,
		);
		$this->load->view('penjualan_laporan',$data);
	}
	public function transaksi($id_pelanggan){
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = date('Y-m');
		$this->db->from('penjualan');
		$this->db->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal);
		$jumlah = $this->db->count_all_results()+1;
		$nota = date('ymd').$jumlah;
		$this->db->from('produk')->where('stok >',0)->order_by('nama','ASC');
		$produk = $this->db->get()->result_array();

		$this->db->from('detail_penjualan a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.kode_penjualan',$nota);
		$detail = $this->db->get()->result_array();

		$this->db->from('temp a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.id_user',$this->session->userdata('id_user'));
		$this->db->where('a.id_pelanggan',$id_pelanggan);
		$temp = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Transaksi Penjualan '.$nota,
			'nota'			=> $nota,
			'produk'		=> $produk,
			'detail'		=> $detail,
			'temp'			=> $temp,
			'id_pelanggan'	=> $id_pelanggan
		);
		$this->template->load('temp','penjualan_transaksiRev',$data);
	}
	public function transaksiselect($id_pelanggan){
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = date('Y-m');
		$this->db->from('penjualan');
		$this->db->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal);
		$jumlah = $this->db->count_all_results()+1;
		$nota = date('ymd').$jumlah;
		$this->db->from('produk')->where('stok >',0)->order_by('nama','ASC');
		$produk = $this->db->get()->result_array();

		$this->db->from('detail_penjualan a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.kode_penjualan',$nota);
		$detail = $this->db->get()->result_array();

		$this->db->from('temp a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.id_user',$this->session->userdata('id_user'));
		$this->db->where('a.id_pelanggan',$id_pelanggan);
		$temp = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Transaksi Penjualan '.$nota,
			'nota'			=> $nota,
			'produk'		=> $produk,
			'detail'		=> $detail,
			'temp'			=> $temp,
			'id_pelanggan'	=> $id_pelanggan
		);
		$this->template->load('temp','penjualan_transaksi',$data);
	}
	public function addtemp2(){
		$this->db->from('produk')->or_where('kode_produk',$this->input->post('kode_produk'))
								->or_where('kode_produk',$this->input->post('kode_produk2'));
		$produk = $this->db->get()->row();
		if($produk==NULL){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Kode barcode tidak ditemukan.</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		}
		if($produk->stok<1){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Stok tidak mencukupi.</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		}
		$id_produk = $produk->id_produk;
		$jumlah = 1;
		$this->db->from('temp');
		$this->db->where('id_produk',$id_produk);
		$this->db->where('id_pelanggan',$this->input->post('id_pelanggan'));
		$this->db->where('id_user',$this->session->userdata('id_user'));
		$cek = $this->db->get()->row();
		if($cek<>NULL){
			if($cek->jumlah+1>$produk->stok){
				$this->session->set_flashdata('notifikasi','
				<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk yang dipilih tidak mencukupi stoknya.</div>
				');
				redirect($_SERVER["HTTP_REFERER"]);
			}
			$where = array(
				'id_user'			=> $this->session->userdata('id_user'),
				'id_produk'			=> $id_produk,
				'id_pelanggan'		=> $this->input->post('id_pelanggan'),
			);
			$data = array(
				'jumlah'			=> $cek->jumlah+1
			);
			$data = $this->db->update('temp',$data,$where);
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Jumlah beli produk berhasil ditambahkan!</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		} else {
			$data = array (
				'id_user'		=> $this->session->userdata('id_user'),
				'id_produk'		=> $id_produk,
				'id_pelanggan'	=> $this->input->post('id_pelanggan'),
				'jumlah'		=> $jumlah
			);
			$this->db->insert('temp',$data);
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk berhasil ditambahkan</div>
			');
		}
		redirect($_SERVER["HTTP_REFERER"]);
	}
	public function update_temp() {
		$this->db->from('produk')->where('kode_produk',$this->input->post('kode_produk'));
		$stok = $this->db->get()->row()->stok;
		$id_temp = $this->input->post('id_temp');
		$jumlah = $this->input->post('jumlah');
		if($jumlah>$stok){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Stok tidak mencukupi</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		} else {
			$this->db->set('jumlah', $jumlah);
			$this->db->where('id_temp', $id_temp);
			$this->db->update('temp');
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Jumlah beli berhasil diperbarui</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}
	
	public function hapus_temp($id_temp){
		$where = array('id_temp'   => $id_temp );
        $this->db->delete('temp',$where);
        $this->session->set_flashdata('notifikasi','
		<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk telah dihapus dari keranjang.</div>
        ');
		redirect($_SERVER["HTTP_REFERER"]);
	}
	public function invoice($kode_pelanjualan){
		$this->db->select('*');
		$this->db->from('penjualan')->order_by('tanggal','DESC')->where('kode_penjualan',$kode_pelanjualan);
        $penjualan = $this->db->get()->row();

		$this->db->select('a.*, b.nama, b.kode_produk');
		$this->db->from('detail_penjualan a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.kode_penjualan',$kode_pelanjualan);
		$detail = $this->db->get()->result_array();

		$data = array(
			'judul_halaman' => 'Invoice '.$kode_pelanjualan,
			'nota'			=> $kode_pelanjualan,
			'penjualan'		=> $penjualan,
			'detail'		=> $detail,
			'profil'		=> $this->db->from('konfigurasi')->get()->row()
		);
		$this->template->load('temp','invoice',$data);
	}
	public function cek(){
		$kode_pelanjualan = $this->input->get('kode_penjualan');
		$this->db->select('*');
		$this->db->from('penjualan')->where('kode_penjualan',$kode_pelanjualan);
        $penjualan = $this->db->get()->row();
		if($penjualan==NULL){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Nomor nota tidak ditemukan.</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		} else {
			redirect('admin/penjualan/invoice/'.$kode_pelanjualan);
		}
	}
	public function nota($kode_pelanjualan){
		$this->db->select('*');
		$this->db->from('penjualan ')->order_by('tanggal','DESC')->where('kode_penjualan',$kode_pelanjualan);
        $penjualan = $this->db->get()->row();

		$this->db->select('a.*, b.nama, b.kode_produk');
		$this->db->from('detail_penjualan a');
		$this->db->join('produk b','a.id_produk=b.id_produk','left');
		$this->db->where('a.kode_penjualan',$kode_pelanjualan);
		$detail = $this->db->get()->result_array();

		$data = array(
			'judul_halaman' => 'Invoice '.$kode_pelanjualan,
			'nota'			=> $kode_pelanjualan,
			'penjualan'		=> $penjualan,
			'detail'		=> $detail,
			'profil'		=> $this->db->from('konfigurasi')->get()->row()
		);
		$this->load->view('nota',$data);
	}
	public function addtemp(){
		$this->db->from('produk')->where('id_produk',$this->input->post('id_produk'));
		$stok_lama = $this->db->get()->row()->stok;

		$this->db->from('temp');
		$this->db->where('id_produk',$this->input->post('id_produk'));
		$this->db->where('id_pelanggan',$this->input->post('id_pelanggan'));
		$this->db->where('id_user',$this->session->userdata('id_user'));
		$cek = $this->db->get()->result_array();

		if($stok_lama<$this->input->post('jumlah')){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk yang dipilih tidak mencukupi stoknya.</div>
			');
		} else if($cek<>NULL){
			$this->db->from('temp');
			$this->db->where('id_user',$this->session->userdata('id_user'));
			$jumlah_sekarang = $this->db->get()->row()->jumlah;
			$jumlah_now = $jumlah_sekarang+$this->input->post('jumlah');
			if($stok_lama<$jumlah_now){
				$this->session->set_flashdata('notifikasi','
				<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk yang dipilih tidak mencukupi stoknya.</div>
				');
				redirect($_SERVER["HTTP_REFERER"]);
			}
			$where = array(
				'id_user'			=> $this->session->userdata('id_user'),
				'id_produk'			=> $this->input->post('id_produk'),
				'id_pelanggan'		=> $this->input->post('id_pelanggan'),
			);
			$data = array(
				'jumlah'			=> $jumlah_now
			);
			$this->db->update('temp',$data,$where);
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Jumlah beli produk berhasil ditambahkan!</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		} else {
			$data = array (
				'id_user'		=> $this->session->userdata('id_user'),
				'id_produk'		=> $this->input->post('id_produk'),
				'id_pelanggan'	=> $this->input->post('id_pelanggan'),
				'jumlah'		=> $this->input->post('jumlah')
			);
			$this->db->insert('temp',$data);
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk berhasil ditambahkan</div>
			');
		}
		redirect($_SERVER["HTTP_REFERER"]);
	}
	public function bayarv2(){ 
		$bayar = $this->input->post('bayar');
		$total_bayar = $this->input->post('total_harga');
		$hasil = $bayar-$total_bayar;
		if($hasil<0){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Pembayaran tidak mencukupi.</div>
			');
			redirect($_SERVER["HTTP_REFERER"]);
		}
		//bagian pembuatan nota
		date_default_timezone_set("Asia/Jakarta");
		$tanggal = date('Y-m');
		$this->db->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $tanggal);
		$jumlah = $this->db->count_all_results();
		$nota = date('ymd')."0".$this->input->post('id_pelanggan')."0".$jumlah+1;
		$config['upload_path']          = 'assets/bukti/';
		$config['max_size'] = 500 * 1024; //3 * 1024 * 1024; //3Mb; 0=unlimited
		$config['allowed_types']        = '*';
		$config['overwrite']            = TRUE;
		$config['file_name']            = $nota.".jpg";
		$this->load->library('upload', $config);
		if($_FILES['bukti']['size'] >= 500 * 1024){
			$this->session->set_flashdata('notifikasi','
			<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Ukuran foto terlalu besar, upload dibawah ukuran 500 KB.</div>
			');
			redirect($_SERVER['HTTP_REFERER']);
		}  elseif( ! $this->upload->do_upload('bukti')){
			$error = array('error' => $this->upload->display_errors());
		}else{
			$data = array('upload_data' => $this->upload->data());
		} 
		$this->db->from('temp a')
				->join('produk b','a.id_produk=b.id_produk','left')
				->where('a.id_user',$this->session->userdata('id_user'))
				->where('a.id_pelanggan',$this->input->post('id_pelanggan'));
		$temp = $this->db->get()->result_array();
		$total = 0; //nilai awal
		foreach($temp as $row){
			if($row['stok']<$row['jumlah']){ //jika ada produk yang stok kurang langsung pindah ke halaman transaksi
				$this->session->set_flashdata('notifikasi','
				<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk dipilih tidak mencukupi.</div>
				');
				redirect($_SERVER["HTTP_REFERER"]);
			}
			$total = $total+$row['jumlah']*$row['harga'];
			
			$data = array (
				'kode_penjualan' => $nota,
				'id_produk' => $row['id_produk'],
				'jumlah' => $row['jumlah'],
				'harga ' => $row['harga'],
			);
			$this->db->insert('detail_penjualan',$data); //input ke tabel detail penjualan 
			
			$data2 = array( 'stok' => $row['stok']-$row['jumlah']);
			$where = array( 'id_produk' => $row['id_produk']);
			$this->db->update('produk',$data2,$where); //update tabel produk stoknya
			
			$where2 = array(
				'id_user'		=> $this->session->userdata('id_user'),
				'id_pelanggan'	=> $this->input->post('id_pelanggan')
			);
			$this->db->delete('temp',$where2); //hapus dari tabel temp 
		}
		//bagian input ke tabel penjualan
		$data = array(
			'kode_penjualan' 	=> $nota,
			'total_harga'		=> $total,
			'bayar'				=> $this->input->post('bayar'),
			'id_pelanggan'		=> $this->input->post('id_pelanggan'),
			'pembayaran'		=> $this->input->post('pembayaran'),
			'bukti'				=> $nota.'.jpg',
			'transaksi'			=> 'Offline',
			'status'			=> 'selesai',
			'tanggal'			=> date('Y-m-d'),
		);
		$this->db->insert('penjualan',$data);
		$this->session->set_flashdata('notifikasi','
		<div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Penjualan berhasil.</div>
		');
		redirect('admin/penjualan/invoice/'.$nota);
	}
	public function cancel($kode_penjualan){
		$status = 'dibatalkan';
		$this->db->from('detail_penjualan a')
				->join('produk b','a.id_produk=b.id_produk','left')
				->where('a.kode_penjualan',$kode_penjualan);
		$detail = $this->db->get()->result_array();
		foreach($detail as $row){
			$data2 = array( 'stok' => $row['stok']+$row['jumlah']);
			$where = array( 'id_produk' => $row['id_produk']);
			$this->db->update('produk',$data2,$where); //update tabel produk stoknya
		}
        $data = array(
            'status'  => $status,
        );
        $where = array('kode_penjualan'   => $kode_penjualan );
        $this->db->update('penjualan',$data,$where);
        $this->session->set_flashdata('notifikasi','
        <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Transaksi penjualan telah '.$status.'.</div>
        ');
        redirect($_SERVER["HTTP_REFERER"]);
    }
}