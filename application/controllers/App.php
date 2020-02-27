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

    public function auto_display()
    {
        $this->db->where('stok <= display_min');
        $this->db->where('auto_display',1);
        foreach ($this->db->get('produk_display')->result() as $v) {
            $this->db->where('id_display', $v->id_display);
            $this->db->update('produk_display', array('auto_display'=>0));
        }
    }

    public function konfirm_auto_display($id_produk,$id_subkategori,$orderan)
    {
        $out_produk_transfer = array(
            'id_produk' => $id_produk,
            'id_subkategori' => $id_subkategori,
            'out_qty' => floatval($orderan) * floatval(1),
            'milik' => 'gudang'
        );
        $this->db->insert('stok_transfer', $out_produk_transfer);

        $in_display_transfer = array(
            'id_produk' => $id_produk,
            'id_subkategori' => $id_subkategori,
            'in_qty' => floatval($orderan) * floatval(1),
            'milik' => 'display'
        );
        $this->db->insert('stok_transfer', $in_display_transfer);

        $this->db->where('id_subkategori', $id_subkategori);
        $this->db->update('produk_display', array('auto_display'=>1,'date_create'=>get_waktu(),'user_by'=>$this->session->userdata('nama')));

        $this->session->set_flashdata('message', alert_biasa('Auto Display berhasil di konfirm','success'));
        redirect(site_url('produk_display'));

    }

    public function insert_manual_display_all()
    {
        $this->load->model('Produk_display_model');

        $this->db->where('in_unit', 1);
        $data_produk = $this->db->get('produk');
        foreach ($data_produk->result() as $rw) {
            
                $data = array(
                'id_produk' => $rw->id_produk,
                'id_subkategori' => $rw->id_subkategori,
                'stok' => 10,
                'in_unit' => $rw->in_unit,
                'display_min' => 5,
                'display_max' => 10,
                'stok_gudang' => $rw->stok,
                'orderan' => 5,
                'selisih_gudang' => 0,
                'selisih_display' => 0,
                'date_create' => get_waktu(),
                'user_by' => $this->session->userdata('nama'),
                'auto_display'=>1,
                );
                    //cek apakah produk sudah ada di display
                    $cek_display = $this->db->get_where('produk_display', array('id_produk'=>$rw->id_produk));
                    if ($cek_display->num_rows() == 0) {
                        $this->Produk_display_model->insert($data);
                    }

                    $out_produk_transfer = array(
                        'id_produk' => $rw->id_produk,
                        'id_subkategori' => $rw->id_subkategori,
                        'out_qty' => floatval(10) * floatval($rw->in_unit)
                    );
                    $this->db->insert('stok_transfer', $out_produk_transfer);

                    $in_display_transfer = array(
                        'id_produk' => $rw->id_produk,
                        'id_subkategori' => $rw->id_subkategori,
                        'in_qty' => floatval(10) * floatval($rw->in_unit),
                        'milik' => 'display'
                    );
                    $this->db->insert('stok_transfer', $in_display_transfer);


        }

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('produk_display'));
        
    }

    public function get_hj_po($subkategori,$no_po)
    {
        $this->load->view('pembelian/list_hj_po',array('id_subkategori'=>$subkategori,'no_po'=>$no_po));
    }

    public function simpan_hj_temp($no_po)
    {
        $this->db->where('no_po', $no_po);
        $this->db->where('id_produk', $this->input->post('id_produk'));
        $this->db->where('id_subkategori', $this->input->post('id_subkategori'));
        $this->db->update('harga_jual_temp', array(
            'harga_jual'=>$this->input->post('harga_jual'),
            'diskon_hj'=>$this->input->post('diskon_hj')
        ));
    }

    public function edit_stok_khusus($id_produk,$id_subkategori,$in_unit)
    {
        if ($_POST['stok_edit'] > $_POST['stok_now']) {
            $nilai = $_POST['stok_edit'] - $_POST['stok_now'];
            $in_qty = $nilai * $in_unit;
            // log_data($_POST);
            // log_r($in_qty);
            $this->db->insert('stok_transfer', array(
                'id_produk'=>$id_produk,
                'id_subkategori'=>$id_subkategori,
                'in_qty'=>$in_qty,
                'milik'=>'gudang',
            ));
        } elseif ($_POST['stok_edit'] < $_POST['stok_now']) {
            $nilai = $_POST['stok_now'] - $_POST['stok_edit'];
            $out_qty = $nilai * $in_unit;
            // log_data($_POST);
            // log_r($in_qty);
            $this->db->insert('stok_transfer', array(
                'id_produk'=>$id_produk,
                'id_subkategori'=>$id_subkategori,
                'out_qty'=>$out_qty,
                'milik'=>'gudang',
            ));
        }
        
        $this->session->set_flashdata('message', alert_biasa('Berhasil ubah stok Produk','success'));
        redirect('app/produk/'.$id_subkategori,'refresh');

    }

    public function edit_stok_khusus_display($id_produk,$id_subkategori,$in_unit)
    {
        if ($_POST['stok_edit'] > $_POST['stok_now']) {
            $nilai = $_POST['stok_edit'] - $_POST['stok_now'];
            $in_qty = $nilai * $in_unit;
            // log_data($_POST);
            // log_r($in_qty);
            $this->db->insert('stok_transfer', array(
                'id_produk'=>$id_produk,
                'id_subkategori'=>$id_subkategori,
                'in_qty'=>$in_qty,
                'milik'=>'display',
            ));
        } elseif ($_POST['stok_edit'] < $_POST['stok_now']) {
            $nilai = $_POST['stok_now'] - $_POST['stok_edit'];
            $out_qty = $nilai * $in_unit;
            // log_data($_POST);
            // log_r($in_qty);
            $this->db->insert('stok_transfer', array(
                'id_produk'=>$id_produk,
                'id_subkategori'=>$id_subkategori,
                'out_qty'=>$out_qty,
                'milik'=>'display',
            ));
        }
        
        $this->session->set_flashdata('message', alert_biasa('Berhasil ubah stok Produk Display','success'));
        redirect('app/produk/'.$id_subkategori,'refresh');

    }

    public function edit_selisih($value,$id_produk)
    {
        $dt = $this->db->get_where('produk_display', array('id_produk'=>$id_produk))->row();
        if ($value == 'gudang') {
            $n = $this->input->post('selisih_gudang');
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk_display', array('selisih_gudang'=>$n,'date_create'=>get_waktu(),'user_by'=>$this->session->userdata('nama')));

            //stok transfer
            $selisih_gudang = $n;
            $id_subkategori = $dt->id_subkategori;
            $stok_gudang = stok_gudang($id_subkategori);
            
            if ($selisih_gudang > 0) {
                $in_display_transfer = array(
                    'id_produk' => $id_produk,
                    'id_subkategori' => $rw->id_subkategori,
                    'in_qty' => -($selisih_gudang),
                    'milik' => 'gudang'
                );
                $this->db->insert('stok_transfer', $in_display_transfer);
            } 
            
            if ($selisih_gudang < 0) {
                $in_display_transfer = array(
                    'id_produk' => $id_produk,
                    'id_subkategori' => $dt->id_subkategori,
                    'in_qty' => $selisih_gudang,
                    'milik' => 'gudang'
                );
                $this->db->insert('stok_transfer', $in_display_transfer);
            }

            
            $data = array(
                'id_produk'=>$id_produk,
                'selisih_gudang'=>$n,
                'date_create'=>get_waktu(),
                'user_by'=>$this->session->userdata('nama')
            );
            $this->db->insert('selisih_display', $data);
            $this->session->set_flashdata('message', alert_biasa('Berhasil Edit Selisih '.$value,'success'));
            redirect('produk_display','refresh');
        } elseif ($value == 'display') {
            $n = $this->input->post('selisih_display');
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk_display', array('selisih_display'=>$n,'date_create'=>get_waktu(),'user_by'=>$this->session->userdata('nama')));

            //stok transfer
            $selisih_display = $n;
            $id_subkategori = $dt->id_subkategori;
            $stok_display = stok_display($id_subkategori);
            if ($selisih_display > 0) {
                $in_display_transfer = array(
                    'id_produk' => $id_produk,
                    'id_subkategori' => $dt->id_subkategori,
                    'in_qty' => -($selisih_display),
                    'milik' => 'display'
                );
                $this->db->insert('stok_transfer', $in_display_transfer);
            } 
            if ($selisih_display < 0) {
                $in_display_transfer = array(
                    'id_produk' => $id_produk,
                    'id_subkategori' => $dt->id_subkategori,
                    'in_qty' => $selisih_display,
                    'milik' => 'display'
                );
                $this->db->insert('stok_transfer', $in_display_transfer);
            } 

           
            
            $data = array(
                'id_produk'=>$id_produk,
                'selisih_display'=>$n,
                'date_create'=>get_waktu(),
                'user_by'=>$this->session->userdata('nama')
            );
            $this->db->insert('selisih_display', $data);
            $this->session->set_flashdata('message', alert_biasa('Berhasil Edit Selisih '.$value,'success'));
            redirect('produk_display','refresh');
        }
    }

    public function ubah_status_po($id_po)
    {
        
        $no_po = get_data('po_master','id_po',$id_po,'no_po');
        $ppn = cek_ppn($no_po);
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
                if ($ppn == '1') {
                    $this->db->update('produk', array('harga_beli'=>$value->value_diskon_hb,'diskon'=>$value->diskon_jual,'value_diskon_hb'=>$value->diskon));
                    //update  harga jual
                    foreach ($this->db->get_where('harga_jual_temp', array('no_po'=>$no_po))->result() as $hj) {
                        $this->db->where('id_produk', $hj->id_produk);
                        $this->db->update('produk', array(
                            'harga'=>$hj->harga_jual,
                            'harga_beli'=>$hj->harga_beli,
                            'value_diskon_hb'=>$hj->diskon_hb,
                            'diskon'=>$hj->diskon_hj,
                        ));
                    }
                } else {
                    $this->db->update('produk', array('harga_beli'=>$value->harga_beli,'diskon'=>$value->diskon_jual,'value_diskon_hb'=>$value->diskon));
                    //update  harga jual
                    foreach ($this->db->get_where('harga_jual_temp', array('no_po'=>$no_po))->result() as $hj) {
                        $this->db->where('id_produk', $hj->id_produk);
                        $this->db->update('produk', array(
                            'harga'=>$hj->harga_jual,
                            'harga_beli'=>$hj->harga_beli,
                            'value_diskon_hb'=>$hj->diskon_hb,
                            'diskon'=>$hj->diskon_hj,
                        ));
                    }
                }
                

    			$this->db->insert('stok_transfer', array(
    				'id_produk'=>$value->id_produk,
    				'id_subkategori'=>$id_subkat,
    				'in_qty'=>$stok_temp,
                    'no_po'=>$no_po
    			));
    			    			
    		}
    		// exit;
    	}

    	$this->session->set_flashdata('message', alert_biasa('Berhasil ubah status PO','success'));
    	redirect('po_master','refresh');
    }

    public function batal_status_po($id_po)
    {
        $no_po = get_data('po_master','id_po',$id_po,'no_po');
        $this->db->where('id_po', $id_po);
        $po_selesai = $this->db->update('po_master', array('selesai'=>'0'));
        if ($po_selesai) {

            $this->db->where('no_po', $no_po);
            $this->db->delete('stok_transfer');
            // exit;
        }

        $this->session->set_flashdata('message', alert_biasa('Berhasil Batalkan PO','success'));
        redirect('po_master','refresh');
    }

    public function cek_produk_for_display()
    {
        $barcode = $this->input->post('barcode');
        $this->db->where('barcode1', $barcode);
        $this->db->or_where('barcode2', $barcode);
        $s = $this->db->get('produk');
        $data = $s->row();
        if ($s->num_rows() == 0) {
            echo json_encode(array('total_row'=>$s->num_rows()));
        } else {
            echo json_encode(
                array(
                    'id_produk' => $data->id_produk,
                    'nama_produk' => $data->nama_produk,
                    'stok_gudang' => $data->stok,
                    'in_unit' => $data->in_unit
                )
            );
        }
    }

    public function get_in_unit($id_produk)
    {
    	$in_unit = get_data('produk','id_produk',$id_produk,'in_unit');
        $satuan = get_data('produk','id_produk',$id_produk,'satuan');
        $stok = get_data('produk','id_produk',$id_produk,'stok');
        $harga = get_data('produk','id_produk',$id_produk,'harga');
        $harga_beli = get_data('produk','id_produk',$id_produk,'harga_beli');
        $diskon_jual = get_data('produk','id_produk',$id_produk,'diskon');
        $note_po = get_data('produk','id_produk',$id_produk,'note_po');
        $stok_min = get_data('produk','id_produk',$id_produk,'stok_min');
        $diskon_hb = get_data('produk','id_produk',$id_produk,'value_diskon_hb');
    	$id_subk = get_data('produk','id_produk',$id_produk,'id_subkategori');
        // $qty_po = explode(' ', $no_po);
    	echo json_encode(array('satuan'=>$satuan,'in_unit'=>$in_unit,'stok'=>$stok,'harga_jual'=>$harga,'harga_beli'=>$harga_beli,'diskon_jual'=>$diskon_jual,'qty_po'=>$note_po,'stok_min'=>$stok_min,
            'diskon_hb'=>$diskon_hb,'id_subkategori'=>$id_subk));
    }

    

    public function cek_diskon_beli($no_po,$id_produk)
    {
        $in_unit_now = get_data('produk','id_produk',$id_produk,'in_unit');
        $id_subkategori = get_data('produk','id_produk',$id_produk,'id_subkategori');
        $diskon = $this->input->post('diskon');
        $total_h = $this->input->post('harga');
        $hd = get_diskon_beli($diskon,$total_h);

        // log_data($_POST);

        //update harga_jual_temp
        foreach ($this->db->get_where('harga_jual_temp', array('no_po'=>$no_po,'id_subkategori'=>$id_subkategori))->result() as $value) {

            // log_r($this->db->last_query());
            //cek_in_unit
            $setelah_diskon = 0;
            $setelah_ppn = 0;
            $harga_beli = 0;
            $diskon_beli = 0;
            $in_unit_temp = get_data('produk','id_produk',$value->id_produk,'in_unit');
            // log_data($id_produk);
            if ($in_unit_now > $in_unit_temp) {
                $setelah_diskon = $hd / ($in_unit_now / $in_unit_temp);
                $setelah_ppn = $total_h/($in_unit_now / $in_unit_temp);
                $harga_beli = $total_h/($in_unit_now / $in_unit_temp);
                $diskon_beli = $diskon/($in_unit_now / $in_unit_temp);
                // echo "$in_unit_now >  $in_unit_temp <br/>";
                // echo "$setelah_diskon = $hd / ($in_unit_now / $in_unit_temp) <br/>";
                // echo "$setelah_ppn = $total_h/($in_unit_now / $in_unit_temp) <br/>";
                // echo "$harga_beli = $total_h/($in_unit_now / $in_unit_temp) <br/>";
                 $this->db->where('id_produk', $value->id_produk);
                $this->db->update('harga_jual_temp', array(
                    'setelah_diskon'=>intval($setelah_diskon),
                    'setelah_ppn'=>intval($setelah_ppn),
                    'harga_beli'=>$harga_beli,
                    'diskon_hb'=>$diskon_beli,
                ));
            } 
            elseif ($in_unit_now < $in_unit_temp) {
                if ($in_unit_now == 1) {
                    $setelah_diskon = $hd * $in_unit_temp;
                    $setelah_ppn = $total_h * $in_unit_temp;
                    $harga_beli = $total_h * $in_unit_temp;
                    $diskon_beli = $diskon * $in_unit_temp;
                    // echo "$in_unit_now ==  1 <br/>";
                    // echo "$setelah_diskon <br/>";
                    // echo "$setelah_ppn <br/>";
                    // echo "$harga_beli <br/>";
                     $this->db->where('id_produk', $value->id_produk);
                        $this->db->update('harga_jual_temp', array(
                            'setelah_diskon'=>intval($setelah_diskon),
                            'setelah_ppn'=>intval($setelah_ppn),
                            'harga_beli'=>$harga_beli,
                            'diskon_hb'=>$diskon_beli,
                        ));
                } 
                if ($in_unit_now > 1) {
                    $setelah_diskon = ($in_unit_temp / $in_unit_now) * $hd;
                    $setelah_ppn = ($in_unit_temp / $in_unit_now) * $total_h;
                    $harga_beli = ($in_unit_temp / $in_unit_now) * $total_h;
                    $diskon_beli = ($in_unit_temp / $in_unit_now) * $diskon;
                    // echo "$in_unit_now > '1' <br/>";
                    // echo "$setelah_diskon <br/>";
                    // echo "$setelah_ppn <br/>";
                    // echo "$harga_beli <br/>";
                     $this->db->where('id_produk', $value->id_produk);
                        $this->db->update('harga_jual_temp', array(
                            'setelah_diskon'=>intval($setelah_diskon),
                            'setelah_ppn'=>intval($setelah_ppn),
                            'harga_beli'=>$harga_beli,
                            'diskon_hb'=>$diskon_beli,
                        ));
                }
                // echo "$in_unit_now <  $in_unit_temp <br/>";
            } elseif ($in_unit_now == $in_unit_temp) {
                $setelah_diskon = $hd;
                $setelah_ppn = $total_h;
                $harga_beli = $total_h;
                $diskon_beli = $diskon;
                // echo "$in_unit_now ==  $in_unit_temp <br/>";
                // echo "$setelah_diskon <br/>";
                // echo "$setelah_ppn <br/>";
                // echo "$harga_beli <br/>";
                 $this->db->where('id_produk', $value->id_produk);
                $this->db->update('harga_jual_temp', array(
                    'setelah_diskon'=>intval($setelah_diskon),
                    'setelah_ppn'=>intval($setelah_ppn),
                    'harga_beli'=>$harga_beli,
                    'diskon_hb'=>$diskon_beli,
                ));
            }

           
                    // log_data($setelah_diskon);
                    // log_data($setelah_ppn);
                    // log_data($harga_beli);  
        }

        echo json_encode(array('harga_diskon'=>$hd,'id_subkategori'=>get_data('produk','id_produk',$id_produk,'id_subkategori')));
    }

    public function get_sales()
    {
        $value = $this->input->post('value');
        $sales = $this->db->get_where('suplier', array('suplier'=>$value))->row()->sales;
        // log_r($sales);
        echo json_encode(array('sales'=>$sales));
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
        $this->db->update('penjualan_header', array('return'=>'1'));
        redirect('app/list_transaksi','refresh');
    }

    public function simpan_barcode_pembelian($no_po)
    {
        $barcode = $this->input->post('barcode');
        
        
        $produk_ = $this->db->query("SELECT * FROM produk where barcode1='$barcode' or barcode2=$barcode ");
        if ($produk_->num_rows() > 0) {
            $rw = $produk_->row();
            $pembelian = array(
                'no_po' => $no_po,
                'id_produk'=>$rw->id_produk,
                'qty'=>$rw->note_po,
                'satuan'=>$rw->satuan,
                'harga_beli'=>$rw->harga_beli,
                'total'=>$rw->note_po * $rw->harga_beli,
                'in_unit'=>$rw->in_unit,
                'harga_jual'=>$rw->harga,
                'diskon_jual'=>$rw->diskon,
                'diskon'=>$rw->value_diskon_hb,
                'total'=> $rw->note_po * get_diskon_beli($rw->value_diskon_hb,$rw->harga_beli)
            );
            log_data($pembelian);
            $this->db->insert('pembelian', $pembelian);
            
        } else {
            $this->session->set_flashdata('message', alert_biasa('Produk tidak ditemukan !','danger'));
        }

        // redirect('app/transaksi');
    }

    public function po_auto()
    {
        $no_po = '';
        $suplier = '';
        $sales = '';
        $sql = "
        SELECT
            * 
        FROM
            produk AS pr
            WHERE pr.stok_min >= (SELECT
        ((COALESCE(SUM(in_qty),0) - COALESCE(SUM(out_qty),0)) ) AS stok_akhir 
    FROM
        stok_transfer
    WHERE
        id_subkategori=pr.id_subkategori) 
            AND pr.id_produk not in (
            SELECT
                pembelian.id_produk 
            FROM
                pembelian,
                po_master 
                WHERE
            po_master.no_po = pembelian.no_po
            and (po_master.selesai='0' or po_master.selesai=0)
            )
        ";
        $get_stok_min = $this->db->query($sql);
        $produk = $get_stok_min->result();

    
        foreach ($produk as $rw) {

            $id_suplier_pro = get_data('subkategori','id_subkategori',$rw->id_subkategori,'id_suplier');
            $suplier_from_produk = get_data('suplier','id_suplier',$id_suplier_pro,'suplier');
            $sales_from_produk = get_data('suplier','id_suplier',$id_suplier_pro,'sales');

            //cek_po master
            $this->db->order_by('id_po', 'desc');
            $cek_po_system = $this->db->get_where('po_master', array('id_user'=>0,'selesai'=>0,'nama_suplier'=>$suplier_from_produk));
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
                log_data($po_master);
                $no_po = get_data('po_master','id_po',$this->db->insert_id(),'no_po');
            }
            // log_r($no_po);

            

            $this->db->order_by('id_pembelian', 'desc');
            $cek_po_last = $this->db->get_where('pembelian', array('id_produk'=>$rw->id_produk));
            if ($cek_po_last->num_rows() > 0) {

                $no_po_ = $cek_po_last->row()->no_po;
                $suplier = get_data('po_master','no_po',$no_po_,'nama_suplier');
                $sales = get_data('po_master','no_po',$no_po_,'sales');

                if (get_data('po_master','no_po',$no_po,'nama_suplier') == '') {
                    //update_po_system
                    $this->db->where('no_po', $no_po);
                    $this->db->update('po_master', array('nama_suplier'=>$suplier_from_produk,'sales'=>$sales_from_produk));
                }

                //cek produk ini sdah ada di pembelian list atau belum
                $cek_pembelian = $this->db->get_where('pembelian', array('id_produk'=>$rw->id_produk,'no_po'=>$no_po));
                if ($cek_pembelian->num_rows() > 0) {
                    echo "Produk 1 sudah ada di NO PO ".$no_po;
                } else {

                    // cek supplier apakah sama, jika sama buat po baru
                    $suplier_skrg = get_data('po_master','no_po',$no_po,'nama_suplier');
                    log_data($suplier_skrg.' - '.$suplier_from_produk.' - '.$no_po);
                    if ($suplier_skrg == $suplier_from_produk) {
                        // buat pembelian_lis
                        $pembelian = array(
                            'no_po' => $no_po,
                            'id_produk'=>$rw->id_produk,
                            'qty'=>$rw->note_po,
                            'satuan'=>$rw->satuan,
                            'harga_beli'=>$rw->harga_beli,
                            'total'=>$rw->note_po * $rw->harga_beli,
                            'in_unit'=>$rw->in_unit,
                            'harga_jual'=>$rw->harga,
                            'diskon_jual'=>$rw->diskon,
                            'diskon'=>$rw->value_diskon_hb,
                            'total'=> $rw->note_po * get_diskon_beli($rw->value_diskon_hb,$rw->harga_beli)
                        );
                        log_data($pembelian);
                        $this->db->insert('pembelian', $pembelian);
                    } else {
                        // buat po baru dengan nama supplier baru
                        $po_master = array(
                            'no_po' => create_random(8),
                            'nama_suplier' => $suplier_from_produk,
                            'sales' => $sales_from_produk,
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
                        log_data($po_master);
                        $no_po = get_data('po_master','id_po',$this->db->insert_id(),'no_po');
                        // buat pembelian_lis
                        $pembelian = array(
                            'no_po' => $no_po,
                            'id_produk'=>$rw->id_produk,
                            'qty'=>$rw->note_po,
                            'satuan'=>$rw->satuan,
                            'harga_beli'=>$rw->harga_beli,
                            'total'=>$rw->note_po * $rw->harga_beli,
                            'in_unit'=>$rw->in_unit,
                            'harga_jual'=>$rw->harga,
                            'diskon_jual'=>$rw->diskon,
                            'diskon'=>$rw->value_diskon_hb,
                            'total'=> $rw->note_po * get_diskon_beli($rw->value_diskon_hb,$rw->harga_beli)
                        );
                        log_data($pembelian);
                        $this->db->insert('pembelian', $pembelian);

                    }

                    
                }

                

            } else {

                $this->db->order_by('id_po', 'desc');
                $cek_po_system = $this->db->get_where('po_master', array('id_user'=>0,'selesai'=>0,'nama_suplier'=>$suplier_from_produk))->row();
                // log_data($this->db->last_query());
                $no_po = $cek_po_system->no_po;

                if (get_data('po_master','no_po',$no_po,'nama_suplier') == '') {
                    //update_po_system


                    $this->db->where('no_po', $no_po);
                    $this->db->update('po_master', array('nama_suplier'=>$suplier_from_produk,'sales'=>$sales_from_produk));
                }

                //cek produk ini sdah ada di pembelian list atau belum
                $cek_pembelian = $this->db->get_where('pembelian', array('id_produk'=>$rw->id_produk,'no_po'=>$no_po));
                if ($cek_pembelian->num_rows() > 0) {
                    echo "Produk 2 sudah ada di NO PO ".$no_po;
                } else {
                    
                     // cek supplier apakah sama, jika sama buat po baru
                    $suplier_skrg = get_data('po_master','no_po',$no_po,'nama_suplier');
                    log_data($suplier_skrg.' - '.$suplier_from_produk.' - '.$no_po);
                    if ($suplier_skrg == $suplier_from_produk) {
                        // buat pembelian_lis
                        $pembelian = array(
                            'no_po' => $no_po,
                            'id_produk'=>$rw->id_produk,
                            'qty'=>$rw->note_po,
                            'satuan'=>$rw->satuan,
                            'harga_beli'=>$rw->harga_beli,
                            'total'=>$rw->note_po * $rw->harga_beli,
                            'in_unit'=>$rw->in_unit,
                            'harga_jual'=>$rw->harga,
                            'diskon_jual'=>$rw->diskon,
                            'diskon'=>$rw->value_diskon_hb,
                            'total'=> $rw->note_po * get_diskon_beli($rw->value_diskon_hb,$rw->harga_beli)
                        );
                        log_data($pembelian);
                        $this->db->insert('pembelian', $pembelian);
                    } else {
                        // buat po baru dengan nama supplier baru
                        $po_master = array(
                            'no_po' => create_random(8),
                            'nama_suplier' => $suplier_from_produk,
                            'sales' => $sales_from_produk,
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
                        log_data($po_master);
                        $no_po = get_data('po_master','id_po',$this->db->insert_id(),'no_po');
                        // buat pembelian_lis
                        $pembelian = array(
                            'no_po' => $no_po,
                            'id_produk'=>$rw->id_produk,
                            'qty'=>$rw->note_po,
                            'satuan'=>$rw->satuan,
                            'harga_beli'=>$rw->harga_beli,
                            'total'=>$rw->note_po * $rw->harga_beli,
                            'in_unit'=>$rw->in_unit,
                            'harga_jual'=>$rw->harga,
                            'diskon_jual'=>$rw->diskon,
                            'diskon'=>$rw->value_diskon_hb,
                            'total'=> $rw->note_po * get_diskon_beli($rw->value_diskon_hb,$rw->harga_beli)
                        );
                        log_data($pembelian);
                        $this->db->insert('pembelian', $pembelian);

                    }

                }

                
            }

        }

        //cek po kosong;
        $this->db->select('no_po');
        $this->db->where('selesai', 0);
        foreach ($this->db->get('po_master')->result() as $rw) {
            $po_beli = $this->db->get_where('pembelian', array('no_po'=>$rw->no_po));
            if ($po_beli->num_rows() == 0) {
                $this->db->where('no_po', $rw->no_po);
                $this->db->delete('po_master');
            }
            log_data($rw->no_po);
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

    public function simpan_penjualan($total_harga,$total_disc,$total_bayar,$kembalian,$jenis_pembayaran)
    {
    	$no_penjualan = time();

    	$this->db->insert('penjualan_header', array('no_penjualan'=>$no_penjualan,'date_create'=>get_waktu(),'total_harga'=>$total_harga,'total_disc'=>$total_disc,'total_bayar'=>$total_bayar,'kembalian'=>$kembalian,'jenis_pembayaran'=>$jenis_pembayaran));

    	foreach ($this->cart->contents() as $items) {
    		$data = array(
    			'no_penjualan' => $no_penjualan,
    			'id_produk' => get_produk($items['id'],'id_produk'),
    			'barcode' => $items['id'],
    			'nama_produk' => strtoupper(get_produk($items['id'],'nama_produk')),
    			'qty' => $items['qty'],
    			'harga' => $items['price'],
    			'subtotal' => $items['subtotal']-floatval(get_produk($items['id'],'diskon')),
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
    	// redirect('app/cetak_belanja/'.$no_penjualan,'refresh');
        echo json_encode(array('no_penjualan'=>$no_penjualan));
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
        
    	$produk_ = $this->db->query("SELECT b.id_produk, b.harga,b.nama_produk,b.id_subkategori FROM produk_display as a,produk b where a.id_subkategori=b.id_subkategori and b.barcode1='$id' or b.barcode2='$id'");
		if ($produk_->num_rows() > 0) {
			$produk = $produk_->row();
            $in_unit = floatval(get_produk($id,'in_unit'));
            //cek stok
            // log_r(get_data('produk_display','id_subkategori',$produk->id_subkategori,'stok'));
            
            // if (get_data('produk_display','id_subkategori',$produk->id_subkategori,'stok') < ($qty*$in_unit)) {
            //     $this->session->set_flashdata('message', alert_biasa('Stok tidak melebihi dari '.$qty,'danger'));
            //     exit;
            // }
			 $data = array(
	            'id'    => $id,
	            'qty'   => $qty,
	            'price' => $produk->harga,
	            'name'  => $produk->nama_produk,
	        );
            log_data($data);
	        $this->cart->insert($data);
            // log_r($this->cart->contents());
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

    public function kirim_po_sales($po)
    {

        if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
        //ubah_status kirim po
        $this->db->where('no_po', $po);
        $this->db->update('po_master', array('dikirim'=>'1'));
        $data = array(
            'konten' => 'po_master/kirim_sales',
            'judul_page' => 'Kirim PO Pembelian',
            'no_po' => $po,
            'data' => $this->db->get_where('pembelian', array('no_po'=>$po)),
        );
        $this->load->view('v_index', $data);
    }

    public function dropzone($id)
    {
        if (!empty($_FILES)) {
             $tempFile = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $targetPath = getcwd() . '/image/produk_mobile/';
            $targetFile = $targetPath . $fileName ;
            move_uploaded_file($tempFile, $targetFile);
            $this->db->insert('image_mobile', array('id_subkategori'=>$id,'img'=>$fileName));
        } else {
            $data = array(
                'konten' => 'produk/dropzone',
                'judul_page' => 'Add Image',
            );
            $this->load->view('v_index', $data);
        }
    }

    public function image_m($id)
    {
        
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($this->db->get_where('image_mobile',array('id_subkategori'=>$id))->result() as $row) {
                 ?>
                <tr>
                    <td><img src="image/produk_mobile/<?php echo $row->img ?>" style="width: 200px; height: 200px;"></td>
                    <td>
                        <a href="app/hapus_img_mobile/<?php echo $id.'/'.$row->img; ?>" class="btn btn-sm btn-danger">hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
    }

    public function hapus_img_mobile($id,$img)
    {
        $this->db->where('id_subkategori', $id);
        $this->db->where('img', $img);
        $this->db->delete('image_mobile');
        unlink('./image/produk_mobile/'.$img);
        $this->session->set_flashdata('message', alert_biasa('Berhasil hapus gambar online','success'));
        redirect('app/dropzone/'.$id,'refresh');
    }
        
    
	

	

	
}
