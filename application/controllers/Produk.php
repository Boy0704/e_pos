<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk extends CI_Controller
{
    private $image = '';
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'produk/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'produk/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'produk/index.html';
            $config['first_url'] = base_url() . 'produk/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Produk_model->total_rows($q);
        $produk = $this->Produk_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'produk_data' => $produk,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'produk/produk_list',
            'konten' => 'produk/produk_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Produk_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_produk' => $row->id_produk,
		'nama_produk' => $row->nama_produk,
		'satuan' => $row->satuan,
		'stok' => $row->stok,
		'stok_min' => $row->stok_min,
		'harga' => $row->harga,
		'barcode1' => $row->barcode1,
		'barcode2' => $row->barcode2,
		'id_owner' => $row->id_owner,
		'date_update' => $row->date_update,
		'id_user' => $row->id_user,
		'id_subkategori' => $row->id_subkategori,
		'jumlah_satuan' => $row->jumlah_satuan,
	    );
            $this->load->view('produk/produk_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function create($id_subkategori) 
    {
        $data = array(
            'judul_page' => 'produk/produk_form',
            'konten' => 'produk/produk_form',
            'button' => 'Create',
            'action' => site_url('produk/create_action'),
	    'id_produk' => set_value('id_produk'),
	    'nama_produk' => set_value('nama_produk'),
	    'satuan' => set_value('satuan'),
	    'stok' => set_value('stok'),
	    'stok_min' => set_value('stok_min'),
	    'harga' => set_value('harga'),
	    'barcode1' => set_value('barcode1'),
	    'barcode2' => set_value('barcode2'),
	    'id_owner' => set_value('id_owner'),
	    'date_update' => set_value('date_update'),
	    'id_user' => set_value('id_user'),
	    'id_subkategori' => $id_subkategori,
        'jumlah_satuan' => set_value('jumlah_satuan'),
        'in_unit' => set_value('in_unit'),
        'harga_beli' => set_value('harga_beli'),
        'foto' => set_value('foto'),
	    'diskon' => 0,
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $produk_nama = '';
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create($this->input->post('id_subkategori',TRUE));
        } else {
            if (stristr($this->input->post('nama_produk',TRUE), '"')) {
                $produk_nama = str_replace('"', '', $this->input->post('nama_produk',TRUE));
            }
            if (stristr($this->input->post('nama_produk',TRUE), "'")) {
                $produk_nama = str_replace("'", '', $this->input->post('nama_produk',TRUE));
            }
            
            $data = array(
		'nama_produk' => $produk,
		'satuan' => $this->input->post('satuan',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'stok_min' => $this->input->post('stok_min',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'barcode1' => $this->input->post('barcode1',TRUE),
		'barcode2' => $this->input->post('barcode2',TRUE),
		'id_owner' => $this->input->post('id_owner',TRUE),
		'date_update' => get_waktu(),
		'id_user' => $this->session->userdata('id_user'),
		'id_subkategori' => $this->input->post('id_subkategori',TRUE),
        'jumlah_satuan' => $this->input->post('jumlah_satuan',TRUE),
        'in_unit' => $this->input->post('in_unit',TRUE),
        'harga_beli' => $this->input->post('harga_beli',TRUE),
		'diskon' => $this->input->post('diskon',TRUE),
        'foto' => upload_gambar_biasa('produk', 'image/produk/','jpg|jpeg|gif|png', 10000, 'foto')
	    );

            $this->Produk_model->insert($data);
            $stok = $this->input->post('stok') * $this->input->post('in_unit');
            $this->db->insert('stok_transfer', array('id_produk'=>$this->db->insert_id(),'id_subkategori'=>$this->input->post('id_subkategori'),'in_qty'=>$stok));
            $this->session->set_flashdata('message', alert_biasa('produk berhasil di simpan','success'));
            redirect(site_url('app/produk/'.$this->input->post('id_subkategori',TRUE)));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'produk/produk_form',
                'konten' => 'produk/produk_form',
                'button' => 'Update',
                'action' => site_url('produk/update_action'),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'nama_produk' => set_value('nama_produk', $row->nama_produk),
		'satuan' => set_value('satuan', $row->satuan),
		'stok' => set_value('stok', $row->stok),
		'stok_min' => set_value('stok_min', $row->stok_min),
		'harga' => set_value('harga', $row->harga),
		'barcode1' => set_value('barcode1', $row->barcode1),
		'barcode2' => set_value('barcode2', $row->barcode2),
		'id_owner' => set_value('id_owner', $row->id_owner),
		'id_subkategori' => set_value('id_subkategori', $row->id_subkategori),
        'jumlah_satuan' => set_value('jumlah_satuan', $row->jumlah_satuan),
        'in_unit' => set_value('in_unit', $row->in_unit),
        'harga_beli' => set_value('harga_beli', $row->harga_beli),
        'diskon' => set_value('diskon', $row->diskon),
		'foto' => set_value('foto', $row->foto),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }
    
    public function update_action() 
    {
        $produk_nama = '';
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk', TRUE));
        } else {

            // print_r($_FILES);exit();

            if ($_FILES['foto']['name'] != '') {
                $this->image = upload_gambar_biasa('produk', 'image/produk/','jpg|jpeg|gif|png', 10000, 'foto');
                // print_r($this->image);exit();
                
            } else {
                $this->image=$this->input->post('old_foto',TRUE);

            }
            if (stristr($this->input->post('nama_produk',TRUE), '"')) {
                $produk_nama = str_replace('"', '', $this->input->post('nama_produk',TRUE));
            }
            if (stristr($this->input->post('nama_produk',TRUE), "'")) {
                $produk_nama = str_replace("'", '', $this->input->post('nama_produk',TRUE));
            }
            $data = array(
		'nama_produk' => $produk_nama,
		'satuan' => $this->input->post('satuan',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'stok_min' => $this->input->post('stok_min',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'barcode1' => $this->input->post('barcode1',TRUE),
		'barcode2' => $this->input->post('barcode2',TRUE),
		'id_owner' => $this->input->post('id_owner',TRUE),
		'date_update' => get_waktu(),
        'foto'=>$this->image,
		'id_user' => $this->session->userdata('id_user'),
		'id_subkategori' => $this->input->post('id_subkategori',TRUE),
        'jumlah_satuan' => $this->input->post('jumlah_satuan',TRUE),
        'in_unit' => $this->input->post('in_unit',TRUE),
        'harga_beli' => $this->input->post('harga_beli',TRUE),
		'diskon' => $this->input->post('diskon',TRUE),
	    );

            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('app/produk/'.$this->input->post('id_subkategori',TRUE)));
        }
    }
    
    public function delete($id,$id_subkategori) 
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $this->Produk_model->delete($id);
            $this->db->where('id_produk', $id);
            $this->db->delete('stok_transfer');
            $this->session->set_flashdata('message', alert_biasa('produk berhasil di hapus','success'));
            redirect(site_url('app/produk/'.$id_subkategori));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_produk', 'nama produk', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('stok', 'stok', 'trim|required');
	$this->form_validation->set_rules('stok_min', 'stok min', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('barcode1', 'barcode1', 'trim|required');
	$this->form_validation->set_rules('barcode2', 'barcode2', 'trim|required');
	$this->form_validation->set_rules('id_owner', 'id owner', 'trim|required');
	// $this->form_validation->set_rules('date_update', 'date update', 'trim|required');
	// $this->form_validation->set_rules('id_user', 'id user', 'trim|required');
	$this->form_validation->set_rules('id_subkategori', 'id subkategori', 'trim|required');
	// $this->form_validation->set_rules('jumlah_satuan', 'jumlah satuan', 'trim|required');

	$this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-25 07:51:54 */
/* https://jualkoding.com */