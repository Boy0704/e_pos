<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
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
		'harga' => $row->harga,
		'barcode1' => $row->barcode1,
		'barcode2' => $row->barcode2,
		'id_owner' => $row->id_owner,
		'date_create' => $row->date_create,
		'date_update' => $row->date_update,
		'id_user' => $row->id_user,
	    );
            $this->load->view('produk/produk_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'produk/produk_form',
            'konten' => 'produk/produk_form',
            'button' => 'Create',
            'action' => site_url('produk/create_action'),
	    'id_produk' => set_value('id_produk'),
	    'nama_produk' => set_value('nama_produk'),
	    'satuan' => set_value('satuan'),
	    'harga' => set_value('harga'),
	    'barcode1' => set_value('barcode1'),
	    'barcode2' => set_value('barcode2'),
	    'id_owner' => set_value('id_owner'),
	    'date_create' => set_value('date_create'),
	    'date_update' => set_value('date_update'),
        'id_user' => set_value('id_user'),
	    'id_kategori' => set_value('id_kategori'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
            print_r($_POST);
        } else {
            $data = array(
		'nama_produk' => $this->input->post('nama_produk',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'barcode1' => $this->input->post('barcode1',TRUE),
		'barcode2' => $this->input->post('barcode2',TRUE),
		'id_owner' => $this->input->post('id_owner',TRUE),
		'date_create' => date('Y-m-d H:i:s'),
        'id_user' => $this->session->userdata('id_user'),
		'id_kategori' => $this->input->post('id_kategori',TRUE),
	    );

            $this->Produk_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('produk'));
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
		'harga' => set_value('harga', $row->harga),
		'barcode1' => set_value('barcode1', $row->barcode1),
		'barcode2' => set_value('barcode2', $row->barcode2),
		'id_owner' => set_value('id_owner', $row->id_owner),
		'date_create' => set_value('date_create', $row->date_create),
		'date_update' => set_value('date_update', $row->date_update),
        'id_user' => set_value('id_user', $row->id_user),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk', TRUE));
        } else {
            $data = array(
		'nama_produk' => $this->input->post('nama_produk',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'harga' => $this->input->post('harga',TRUE),
		'barcode1' => $this->input->post('barcode1',TRUE),
		'barcode2' => $this->input->post('barcode2',TRUE),
		'id_owner' => $this->input->post('id_owner',TRUE),
		'date_update' => date('Y-m-d H:i:s'),
        'id_user' => $this->session->userdata('id_user'),
		'id_kategori' => $this->input->post('id_kategori',TRUE),
	    );

            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('produk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $this->Produk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('produk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_produk', 'nama produk', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	$this->form_validation->set_rules('barcode1', 'barcode1', 'trim|required');
	$this->form_validation->set_rules('barcode2', 'barcode2', 'trim|required');
	$this->form_validation->set_rules('id_owner', 'id owner', 'trim|required');
	// $this->form_validation->set_rules('date_create', 'date create', 'trim|required');
	// $this->form_validation->set_rules('date_update', 'date update', 'trim|required');
 //    $this->form_validation->set_rules('id_user', 'id_user', 'trim|required');
	$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim|required');

	$this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-21 00:39:43 */
/* https://jualkoding.com */