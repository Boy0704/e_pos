<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Po_master extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Po_master_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'po_master/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'po_master/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'po_master/index.html';
            $config['first_url'] = base_url() . 'po_master/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Po_master_model->total_rows($q);
        $po_master = $this->Po_master_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'po_master_data' => $po_master,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'po_master/po_master_list',
            'konten' => 'po_master/po_master_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Po_master_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_po' => $row->id_po,
		'no_po' => $row->no_po,
		'nama_suplier' => $row->nama_suplier,
		'sales' => $row->sales,
		'potongan_harga' => $row->potongan_harga,
		'date_create' => $row->date_create,
		'id_user' => $row->id_user,
	    );
            $this->load->view('po_master/po_master_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('po_master'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'po_master/po_master_form',
            'konten' => 'po_master/po_master_form',
            'button' => 'Create',
            'action' => site_url('po_master/create_action'),
	    'id_po' => set_value('id_po'),
	    'no_po' => set_value('no_po'),
	    'nama_suplier' => set_value('nama_suplier'),
	    'sales' => set_value('sales'),
	    'potongan_harga' => set_value('potongan_harga'),
	    'date_create' => set_value('date_create'),
	    'id_user' => set_value('id_user'),
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
		'nama_suplier' => $this->input->post('nama_suplier',TRUE),
		'sales' => $this->input->post('sales',TRUE),
		'potongan_harga' => $this->input->post('potongan_harga',TRUE),
		'date_create' => get_waktu(),
		'id_user' => $this->session->userdata('id_user'),
	    );

            $this->Po_master_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('po_master'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Po_master_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'po_master/po_master_form',
                'konten' => 'po_master/po_master_form',
                'button' => 'Update',
                'action' => site_url('po_master/update_action'),
		'id_po' => set_value('id_po', $row->id_po),
		'no_po' => set_value('no_po', $row->no_po),
		'nama_suplier' => set_value('nama_suplier', $row->nama_suplier),
		'sales' => set_value('sales', $row->sales),
		'potongan_harga' => set_value('potongan_harga', $row->potongan_harga),
		'date_create' => set_value('date_create', $row->date_create),
		'id_user' => set_value('id_user', $row->id_user),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('po_master'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_po', TRUE));
        } else {
            $data = array(
		'no_po' => $this->input->post('no_po',TRUE),
		'nama_suplier' => $this->input->post('nama_suplier',TRUE),
		'sales' => $this->input->post('sales',TRUE),
		'potongan_harga' => $this->input->post('potongan_harga',TRUE),
		'date_create' => get_waktu(),
		'id_user' => $this->session->userdata('id_user'),
	    );

            $this->Po_master_model->update($this->input->post('id_po', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('po_master'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Po_master_model->get_by_id($id);

        if ($row) {
            $this->Po_master_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('po_master'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('po_master'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('no_po', 'no po', 'trim|required');
	$this->form_validation->set_rules('nama_suplier', 'nama suplier', 'trim|required');
	$this->form_validation->set_rules('sales', 'sales', 'trim|required');
	$this->form_validation->set_rules('potongan_harga', 'potongan harga', 'trim|required');
	// $this->form_validation->set_rules('date_create', 'date create', 'trim|required');
	// $this->form_validation->set_rules('id_user', 'id user', 'trim|required');

	$this->form_validation->set_rules('id_po', 'id_po', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Po_master.php */
/* Location: ./application/controllers/Po_master.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-25 08:17:49 */
/* https://jualkoding.com */