<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pembelian_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pembelian/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pembelian/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pembelian/index.html';
            $config['first_url'] = base_url() . 'pembelian/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pembelian_model->total_rows($q);
        $pembelian = $this->Pembelian_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pembelian_data' => $pembelian,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'pembelian/pembelian_list',
            'konten' => 'pembelian/pembelian_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Pembelian_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_pembelian' => $row->id_pembelian,
		'no_po' => $row->no_po,
		'id_produk' => $row->id_produk,
		'qty' => $row->qty,
		'satuan' => $row->satuan,
		'harga_beli' => $row->harga_beli,
		'total' => $row->total,
	    );
            $this->load->view('pembelian/pembelian_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pembelian'));
        }
    }

    public function create($no_po) 
    {
        $data = array(
            'judul_page' => 'pembelian/pembelian_form',
            'konten' => 'pembelian/pembelian_form',
            'button' => 'Create',
            'action' => site_url('pembelian/create_action'),
	    'id_pembelian' => set_value('id_pembelian'),
	    'no_po' => $no_po,
	    'id_produk' => set_value('id_produk'),
	    'qty' => set_value('qty'),
	    'satuan' => set_value('satuan'),
	    'harga_beli' => set_value('harga_beli'),
	    'total' => set_value('total'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'no_po' => $this->input->post('no_po',TRUE),
		'id_produk' => $this->input->post('id_produk',TRUE),
		'qty' => $this->input->post('qty',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'total' => $this->input->post('total',TRUE),
	    );

            $this->Pembelian_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('app/isi_po/'.$this->input->post('no_po',TRUE)));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pembelian_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'pembelian/pembelian_form',
                'konten' => 'pembelian/pembelian_form',
                'button' => 'Update',
                'action' => site_url('pembelian/update_action'),
		'id_pembelian' => set_value('id_pembelian', $row->id_pembelian),
		'no_po' => set_value('no_po', $row->no_po),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'qty' => set_value('qty', $row->qty),
		'satuan' => set_value('satuan', $row->satuan),
		'harga_beli' => set_value('harga_beli', $row->harga_beli),
		'total' => set_value('total', $row->total),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pembelian'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pembelian', TRUE));
        } else {
            $data = array(
		'no_po' => $this->input->post('no_po',TRUE),
		'id_produk' => $this->input->post('id_produk',TRUE),
		'qty' => $this->input->post('qty',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'total' => $this->input->post('total',TRUE),
	    );

            $this->Pembelian_model->update($this->input->post('id_pembelian', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('app/isi_po/'.$this->input->post('no_po',TRUE)));
        }
    }
    
    public function delete($id,$no_po) 
    {
        $row = $this->Pembelian_model->get_by_id($id);

        if ($row) {
            $this->Pembelian_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('app/isi_po/'.$no_po));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pembelian'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_po', 'no po', 'trim|required');
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	$this->form_validation->set_rules('qty', 'qty', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('harga_beli', 'harga beli', 'trim|required');
	$this->form_validation->set_rules('total', 'total', 'trim|required');

	$this->form_validation->set_rules('id_pembelian', 'id_pembelian', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pembelian.php */
/* Location: ./application/controllers/Pembelian.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-25 09:14:24 */
/* https://jualkoding.com */