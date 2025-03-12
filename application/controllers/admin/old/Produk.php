<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Produk extends CI_Controller {
	public function __construct(){
		parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
		if($this->session->userdata('login')!=="Backend"){
			redirect('auth');
		}
	}
	public function index(){
        $this->db->select('a.*,b.kategori')->from('produk a')->join('kategori b','a.id_kategori=b.id_kategori','left');
        $this->db->order_by('a.nama','ASC');
        $user = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Produk',
            'user'          => $user,
            'kategori'      => $this->View_model->get_kategori()
		);
		$this->template->load('temp','produk_index',$data);
	}
    public function kategori($id_kategori){
        $this->db->select('*')
                 ->from('produk a')
                 ->join('kategori b','a.id_kategori=b.id_kategori','left')
                 ->order_by('a.nama','ASC');
        if($id_kategori==0){
            $this->db->where('b.id_kategori IS NULL');
        } else {
            $this->db->where('a.id_kategori',$id_kategori);
        }
        $user = $this->db->get()->result_array();
		$data = array(
			'judul_halaman' => 'Produk',
            'user'          => $user,
            'kategori'      => $this->View_model->get_kategori()
		);
		$this->template->load('temp','produk_index',$data);
	}
    public function simpan(){
        $this->db->from('produk')->where('kode_produk',$this->input->post('kode_produk'));
        $cek = $this->db->get()->result_array();
        if($cek==NULL){
            $data = array(
                'kode_produk'  => $this->input->post('kode_produk'),
                'stok'         => $this->input->post('stok'),
                'nama'         => $this->input->post('nama'),
                'harga'        => $this->input->post('harga'),
                'id_kategori'  => $this->input->post('id_kategori')
            );
            $this->db->insert('produk',$data);
            $this->session->set_flashdata('notifikasi','
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk berhasil ditambahkan.</div>
            ');
        } else {
            $this->session->set_flashdata('notifikasi','
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Kode produk atau produk sudah dimasukan, silahkan ulangi lagi.</div>
            ');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function simpansuara(){
        $this->db->from('suara')->where('tps',$this->input->post('tps'));
        $cek = $this->db->get()->result_array();
        $suara = $this->input->post('total_suara');
        $suaraSah = $this->input->post('total_suara_sah');
        $suaraTidakSah = $this->input->post('total_suara_tidak_sah');
        $cekSuara=$suaraSah+$suaraTidakSah;
        $no1 = $this->input->post('no1');
        $no2 = $this->input->post('no2');
        $no3 = $this->input->post('no3');
        $cekSuara2 = $no1+$no2+$no3;
        if($suara!=$cekSuara){
            $this->session->set_flashdata('notifikasi','
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Total Suara tidak sama.</div>
            ');
        } else if($cekSuara2!=$suaraSah){
            $this->session->set_flashdata('notifikasi','
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Total Suara Sahtidak sama.</div>
            ');
        } else if($cek==NULL){
            $data = array(
                'tps'  => $this->input->post('tps'),
                'total_suara'         => $this->input->post('total_suara'),
                'total_suara_sah'         => $this->input->post('total_suara_sah'),
                'total_suara_tidak_sah'        => $this->input->post('total_suara_tidak_sah'),
                'no1'  => $this->input->post('no1'),
                'no2'  => $this->input->post('no2'),
                'no3'  => $this->input->post('no3'),
            );
            $this->db->insert('suara',$data);
            $this->session->set_flashdata('notifikasi','
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Suara berhasil ditambahkan.</div>
            ');
        } else {
            $this->session->set_flashdata('notifikasi','
            <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">TPS sudah diinputkan.</div>
            ');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function hapus($id_produk){
        $where = array('id_produk'   => $id_produk );
        $this->db->delete('produk',$where);
        $this->session->set_flashdata('notifikasi','
        <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk sudah dihapus.</div>
        ');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function update(){
        $data = array(
            'kode_produk'  => $this->input->post('kode_produk'),
            'stok'         => $this->input->post('stok'),
            'nama'         => $this->input->post('nama'),
            'harga'        => $this->input->post('harga'),
            'id_kategori'  => $this->input->post('id_kategori')
        );
        $where = array('id_produk'   => $this->input->post('id_produk') );
        $this->db->update('produk',$data,$where);
        $this->session->set_flashdata('notifikasi','
        <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk berhasil diperbarui.</div>
        ');
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function mutasi(){
        $jenis = $this->input->post('jenis');
        $this->db->from('produk')->where('id_produk',$this->input->post('id_produk'));
        $dataLama = $this->db->get()->row();
        $jumlah = $this->input->post('jumlah');
        if($jenis=="gudang_ke_toko"){
            $data = array(
                'stok'         => $dataLama->stok+$jumlah,
                'stok_gudang'  => $dataLama->stok_gudang-$jumlah
            );
        } else {
            $data = array(
                'stok'         => $dataLama->stok-$jumlah,
                'stok_gudang'  => $dataLama->stok_gudang+$jumlah
            );
        }
        $where = array('id_produk'   => $this->input->post('id_produk') );
        $this->db->update('produk',$data,$where);
        //bagian input ke tabel mutasi
		$data = array(
			'id_produk' 	    => $dataLama->id_produk,
			'jumlah'			=> $jumlah,
			'id_user'			=> $this->session->userdata('id_user'),
			'tanggal'			=> date('Y-m-d'),
		);
		$this->db->insert('mutasi',$data);
        $this->session->set_flashdata('notifikasi','
        <div class="rounded-md px-5 py-4 mb-2 bg-theme-1 text-white">Produk telah berhasil dipindahkan ke toko.</div>
        ');
        redirect($_SERVER['HTTP_REFERER']);
    }
    // Controller function to fetch mutasi data
    public function get_mutasi_produk(){
        $this->db->select('*')
                ->from('mutasi a')
                ->join('produk b','a.id_produk=b.id_produk','left')
                ->order_by('a.id_mutasi','DESC');
        $mutasi_data = $this->db->get()->result_array();
        // Format tanggal
        foreach ($mutasi_data as &$mutasi) {
            $mutasi['tanggal'] = date('l, d F Y', strtotime($mutasi['tanggal']));
        }
        echo json_encode($mutasi_data);
    }
}
