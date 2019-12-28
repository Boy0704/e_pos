<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Return extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Return_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'return/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'return/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'return/index.html';
            $config['first_url'] = base_url() . 'return/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Return_model->total_rows($q);
        $return = $this->Return_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'return_data' => $return,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'return/return_list',
            'konten' => 'return/return_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Return_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_return' => $row->id_return,
		'id_produk' => $row->id_produk,
		'nama_produk' => $row->nama_produk,
		'jumlah' => $row->jumlah,
		'date_create' => $row->date_create,
		'keterangan' => $row->keterangan,
	    );
            $this->load->view('return/return_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'return/return_form',
            'konten' => 'return/return_form',
            'button' => 'Create',
            'action' => site_url('return/create_action'),
	    'id_return' => set_value('id_return'),
	    'id_produk' => set_value('id_produk'),
	    'nama_produk' => set_value('nama_produk'),
	    'jumlah' => set_value('jumlah'),
	    'date_create' => set_value('date_create'),
	    'keterangan' => set_value('keterangan'),
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
		'id_produk' => $this->input->post('id_produk',TRUE),
		'nama_produk' => $this->input->post('nama_produk',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
		'date_create' => $this->input->post('date_create',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Return_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('return'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Return_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'return/return_form',
                'konten' => 'return/return_form',
                'button' => 'Update',
                'action' => site_url('return/update_action'),
		'id_return' => set_value('id_return', $row->id_return),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'nama_produk' => set_value('nama_produk', $row->nama_produk),
		'jumlah' => set_value('jumlah', $row->jumlah),
		'date_create' => set_value('date_create', $row->date_create),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_return', TRUE));
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'nama_produk' => $this->input->post('nama_produk',TRUE),
		'jumlah' => $this->input->post('jumlah',TRUE),
		'date_create' => $this->input->post('date_create',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Return_model->update($this->input->post('id_return', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('return'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Return_model->get_by_id($id);

        if ($row) {
            $this->Return_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('return'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	$this->form_validation->set_rules('nama_produk', 'nama produk', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
	$this->form_validation->set_rules('date_create', 'date create', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id_return', 'id_return', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Return.php */
/* Location: ./application/controllers/Return.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-12-27 23:37:35 */
/* https://jualkoding.com */