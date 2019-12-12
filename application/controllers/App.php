<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public $image = '';
	
	public function index()
	{

        if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function admin()
	{
        // if ($this->session->userdata('username') == '') {
        //     redirect('app/login');
        // }
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function ubah_status_po($id_po)
    {
    	$this->db->where('id_po', $id_po);
    	$po_selesai = $this->db->update('po_master', array('selesai'=>'1'));
    	if ($po_selesai) {

    		$lis_pembelian = $this->db->get_where('pembelian', array('no_po'=>get_data('po_master','id_po',$id_po,'no_po')));

    		foreach ($lis_pembelian->result() as $value) {
    			//id_subkategori
    			$id_subkat = get_data('produk','id_produk',$value->id_produk,'id_subkategori');
    			$stok_temp = $value->qty * $value->in_unit;
    			// log_data($value->qty.' '.$value->in_unit);
    			$this->db->insert('stok_transfer', array(
    				'id_produk'=>$value->id_produk,
    				'id_subkategori'=>$id_subkat,
    				'in_qty'=>$stok_temp
    			));
    			    			
    		}
    		// exit;
    	}

    	$this->session->set_flashdata('message', alert_biasa('Berhasil ubah status PO','success'));
    	redirect('po_master','refresh');
    }

    public function get_in_unit($id_produk)
    {
    	$in_unit = get_data('produk','id_produk',$id_produk,'in_unit');
    	$satuan = get_data('produk','id_produk',$id_produk,'satuan');
    	echo json_encode(array('satuan'=>$satuan,'in_unit'=>$in_unit));
    }

    public function transaksi()
    {
    	if ($this->session->userdata('level') != 'admin' and $this->session->userdata('level') != 'kasir') {
    		// log_r($this->session->userdata('level'));
            redirect('login');
        }
		$data = array(
			'konten' => 'transaksi/view',
            'judul_page' => 'Transaksi Penjualan',
		);
		$this->load->view('v_index', $data);
    }

    public function simpan_penjualan($total_harga,$total_disc)
    {
    	$no_penjualan = time();

    	$this->db->insert('penjualan_header', array('no_penjualan'=>$no_penjualan,'date_create'=>get_waktu(),'total_harga'=>$total_harga,'total_disc'=>$total_disc));

    	foreach ($this->cart->contents() as $items) {
    		$data = array(
    			'no_penjualan' => $no_penjualan,
    			'id_produk' => get_produk($items['id'],'id_produk'),
    			'barcode' => $items['id'],
    			'nama_produk' => strtoupper(get_produk($items['id'],'nama_produk')),
    			'qty' => $items['qty'],
    			'harga' => $items['price'],
    			'subtotal' => $items['subtotal']-get_produk($items['id'],'diskon'),
    		);
    		$this->db->insert('penjualan_detail', $data);
    	}
    	$this->cart->destroy();
    	redirect('app/cetak_belanja/'.$no_penjualan,'refresh');
    }

    public function cetak_belanja($no_penjualan)
    {
    	$this->load->view('transaksi/cetak_belanja');
    }

    public function produk($id_subkategori)
	{

        if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'produk/view',
            'judul_page' => 'Produk Subkategori',
            'id_subkategori' => $id_subkategori,
            'data' => $this->db->get_where('produk',array('id_subkategori'=>$id_subkategori)),
		);
		$this->load->view('v_index', $data);
    }

    public function get_produk_transaksi()
    {
    	$barcode = $this->input->post('barcode');
    	$produk = $this->db->query("SELECT * FROM produk where barcode1='$barcode' or barcode2='$barcode'")->row();
    	?>
    		<tr>
    			<td><?php echo $barcode ?></td>
    			<td><?php echo strtoupper($produk->nama_produk) ?></td>
    			<td><span id="price<?php echo $produk->id_produk ?>"><?php echo $produk->harga ?></span></td>
    			<td><input type="number" id="qty<?php echo $produk->id_produk ?>" class="form-control" value="1"></td>
    			<td><span id="subt<?php echo $produk->id_produk ?>"><?php echo $produk->harga ?></span></td>
    		</tr>
    	<?php
    }

    public function simpan_cart()
	{
		$barcode = $this->input->post('barcode');
    	$produk_ = $this->db->query("SELECT * FROM produk where barcode1='$barcode' or barcode2='$barcode'");
		if ($produk_->num_rows() > 0) {
			$produk = $produk_->row();
			 $data = array(
	            'id'    => $barcode,
	            'qty'   => 1,
	            'price' => $produk->harga,
	            'name'  => $produk->nama_produk,
	        );
	        $this->cart->insert($data);
		} else {
			$this->session->set_flashdata('message', alert_biasa('Produk tidak ditemukan','danger'));
		}

        // redirect('app/transaksi');
	}

	public function hapus_cart($id)
	{
		
        $data = array(
            'rowid'    => $id,
            'qty'   => 0,
        );
        $this->cart->update($data);
        redirect('app/transaksi');
	}
	
	public function update_cart($id)
	{
		$qty = $this->input->post('qty');
        $data = array(
            'rowid'    => $id,
            'qty'   => $qty,
        );
        $this->cart->update($data);
        redirect('app/transaksi');
	}

    public function tambah_produk($id_subkategori)
	{
        if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'produk/tambah_produk',
            'judul_page' => 'Produk Subkategori',
            'id_subkategori' => $id_subkategori,
            
		);
		$this->load->view('v_index', $data);
    }

    public function isi_po($po)
	{

        if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'po_master/isi_po',
            'judul_page' => 'Buat PO Pembelian',
            'no_po' => $po,
            'data' => $this->db->get_where('pembelian', array('no_po'=>$po)),
		);
		$this->load->view('v_index', $data);
    }

        
    
	

	

	
}
