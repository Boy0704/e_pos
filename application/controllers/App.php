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

                $this->db->where('id_produk', $value->id_produk);
                $this->db->update('produk', array('harga_jual'=>$value->harga_jual,'harga_beli'=>$value->harga_beli));

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
        $stok = get_data('produk','id_produk',$id_produk,'stok');
    	$harga = get_data('produk','id_produk',$id_produk,'harga');
    	echo json_encode(array('satuan'=>$satuan,'in_unit'=>$in_unit,'stok'=>$stok,'harga_jual'=>$harga));
    }

    public function get_produk($id_produk)
    {
        $in_unit = get_data('produk','id_produk',$id_produk,'in_unit');
        $id_subkategori = get_data('produk','id_produk',$id_produk,'id_subkategori');
        $stok = get_data('produk','id_produk',$id_produk,'stok');
        $harga = get_data('produk','id_produk',$id_produk,'harga');
        echo json_encode(array('id_subkategori'=>$id_subkategori,'in_unit'=>$in_unit,'stok'=>$stok,'harga_jual'=>$harga));
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

    public function list_transaksi()
    {
        if ($this->session->userdata('level') != 'admin' and $this->session->userdata('level') != 'kasir') {
            // log_r($this->session->userdata('level'));
            redirect('login');
        }
        $data = array(
            'konten' => 'transaksi/list_transaksi',
            'judul_page' => 'Transaksi Penjualan',
        );
        $this->load->view('v_index', $data);
    }

    public function return_list()
    {
        if ($this->session->userdata('level') != 'admin' and $this->session->userdata('level') != 'kasir') {
            // log_r($this->session->userdata('level'));
            redirect('login');
        }
        $data = array(
            'konten' => 'return/view',
            'judul_page' => 'Return Penjualan',
        );
        $this->load->view('v_index', $data);
    }

    public function ubah_return($no_penjualan)
    {
        $this->db->where('no_penjualan', $no_penjualan);
        $this->db->update('penjualan_header', array('return'=>1));
        redirect('app/list_transaksi','refresh');
    }

    public function po_auto()
    {
        $no_po = '';
        $suplier = '';
        $sales = '';
        $get_stok_min = $this->db->query("SELECT * FROM produk WHERE stok_min >= stok");
        $produk = $get_stok_min->result();

        //cek_po master
        $cek_po_system = $this->db->get_where('po_master', array('id_user'=>0,'selesai'=>0));
        if ($cek_po_system->num_rows() > 0) {
            $no_po = $cek_po_system->row()->no_po;

        } else {
            // buat po master
            $po_master = array(
                'no_po' => create_random(8),
                'nama_suplier' => '',
                'sales' => '',
                'potongan_harga' => 0,
                'total_harga' => 0,
                'status_pembayaran' => 'cash',
                'jumlah_bayar' => 0,
                'sisa_bayar' => 0,
                'ppn' => '0',
                'date_create' => get_waktu(),
                'id_user' => 0,
                'selesai' => 0,
            );
            $this->db->insert('po_master', $po_master);
            $no_po = get_data('po_master','id_po',$this->db->insert_id(),'no_po');
        }
        // log_r($no_po);


        foreach ($produk as $rw) {
            $this->db->order_by('id_pembelian', 'desc');
            $cek_po_last = $this->db->get_where('pembelian', array('id_produk'=>$rw->id_produk));
            if ($cek_po_last->num_rows > 0) {

                $no_po_ = $cek_po_last->row()->no_po;
                $suplier = get_data('po_master','no_po',$no_po_,'nama_suplier');
                $sales = get_data('po_master','no_po',$no_po_,'sales');

                if (get_data('po_master','no_po',$no_po,'nama_suplier') == '') {
                    //update_po_system
                    $this->db->where('no_po', $no_po);
                    $this->db->update('po_master', array('nama_suplier'=>$suplier,'sales'=>$sal));
                }

                //cek produk ini sdah ada di pembelian list atau belum
                $cek_pembelian = $this->db->get('pembelian', array('id_produk'=>$rw->id_produk));
                if ($cek_pembelian->num_rows() > 0) {
                    echo "Produk sudah ada";
                } else {
                    // buat pembelian_lis
                    $pembelian = array(
                        'no_po' => $no_po,
                        'id_produk'=>$rw->id_produk,
                        'qty'=>0,
                        'satuan'=>$rw->satuan,
                        'harga_beli'=>$rw->harga_beli,
                        'total'=>0,
                        'in_unit'=>$rw->in_unit,
                    );
                    $this->db->insert('pembelian', $pembelian);
                }

                

            } else {

                if (get_data('po_master','no_po',$no_po,'nama_suplier') == '') {
                    //update_po_system
                    $this->db->where('no_po', $no_po);
                    $this->db->update('po_master', array('nama_suplier'=>'SUPLIER CASH','sales'=>'NOT SET'));
                }

                //cek produk ini sdah ada di pembelian list atau belum
                $cek_pembelian = $this->db->get('pembelian', array('id_produk'=>$rw->id_produk));
                if ($cek_pembelian->num_rows() > 0) {
                    echo "Produk sudah ada";
                } else {
                    // buat pembelian_lis
                    $pembelian = array(
                        'no_po' => $no_po,
                        'id_produk'=>$rw->id_produk,
                        'qty'=>0,
                        'satuan'=>$rw->satuan,
                        'harga_beli'=>$rw->harga_beli,
                        'total'=>0,
                        'in_unit'=>$rw->in_unit,
                    );
                    $this->db->insert('pembelian', $pembelian);
                }

                
            }

        }

    }

    public function ubah_cart_satuan($id_produk,$row_id,$qty)
    {
        $data = array(
            'rowid'    => $row_id,
            'qty'   => 0,
        );
        $this->cart->update($data);

        $produk_ = $this->db->query("SELECT * FROM produk where id_produk='$id_produk'");
        $produk = $produk_->row();
         $data = array(
            'id'    => $produk->barcode1,
            'qty'   => $qty,
            'price' => $produk->harga,
            'name'  => $produk->nama_produk,
        );
        $this->cart->insert($data);

    }

    public function simpan_penjualan($total_harga,$total_disc,$total_bayar,$kembalian)
    {
    	$no_penjualan = time();

    	$this->db->insert('penjualan_header', array('no_penjualan'=>$no_penjualan,'date_create'=>get_waktu(),'total_harga'=>$total_harga,'total_disc'=>$total_disc,'total_bayar'=>$total_bayar,'kembalian'=>$kembalian));

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

            $simpan_stok_transfer = array(
                'id_produk' => get_produk($items['id'],'id_produk'),
                'id_subkategori' => get_produk($items['id'],'id_subkategori'),
                'out_qty' => $items['qty'] * floatval(get_produk($items['id'],'in_unit')),
                'milik' => 'display'
            );
    		$this->db->insert('stok_transfer', $simpan_stok_transfer);
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
        $id = '';
        $qty = 1;
        if (stristr($barcode, '+')) {
            $p = explode('+', $barcode);
            $qty = $p[0];
            $id = $p[1];
            if ($p[0] < 1) {
                $qty = 1;
            }
        } else {
            $id = $barcode;
            $qty = 1;
        }
        
    	$produk_ = $this->db->query("SELECT b.id_produk, b.harga,b.nama_produk FROM produk_display as a,produk b where a.id_produk=b.id_produk and b.barcode1='$id' or b.barcode2='$id'");
		if ($produk_->num_rows() > 0) {
			$produk = $produk_->row();
            //cek stok
            if (get_data('produk_display','id_produk',$produk->id_produk,'stok') < $qty) {
                $this->session->set_flashdata('message', alert_biasa('Stok tidak melebihi dari '.$qty,'danger'));
                exit;
            }
			 $data = array(
	            'id'    => $id,
	            'qty'   => $qty,
	            'price' => $produk->harga,
	            'name'  => $produk->nama_produk,
	        );
	        $this->cart->insert($data);
		} else {
			$this->session->set_flashdata('message', alert_biasa('Produk tidak ditemukan di Display List','danger'));
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
