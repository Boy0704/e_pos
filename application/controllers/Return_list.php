<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Return_list extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Return_list_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'return_list/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'return_list/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'return_list/index.html';
            $config['first_url'] = base_url() . 'return_list/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Return_list_model->total_rows($q);
        $return_list = $this->Return_list_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'return_list_data' => $return_list,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'return_list/return_list_list',
            'konten' => 'return_list/return_list_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Return_list_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_return' => $row->id_return,
		'id_produk' => $row->id_produk,
		'jumlah' => $row->jumlah,
		'date_create' => $row->date_create,
		'keterangan' => $row->keterangan,
	    );
            $this->load->view('return_list/return_list_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return_list'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'return_list/return_list_form',
            'konten' => 'return_list/return_list_form',
            'button' => 'Create',
            'action' => site_url('return_list/create_action'),
	    'id_return' => set_value('id_return'),
	    'id_produk' => set_value('id_produk'),
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
		'jumlah' => $this->input->post('jumlah',TRUE),
		'date_create' => $this->input->post('date_create',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Return_list_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('return_list'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Return_list_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'return_list/return_list_form',
                'konten' => 'return_list/return_list_form',
                'button' => 'Update',
                'action' => site_url('return_list/update_action'),
		'id_return' => set_value('id_return', $row->id_return),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'jumlah' => set_value('jumlah', $row->jumlah),
		'date_create' => set_value('date_create', $row->date_create),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return_list'));
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
		'jumlah' => $this->input->post('jumlah',TRUE),
		'date_create' => $this->input->post('date_create',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Return_list_model->update($this->input->post('id_return', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('return_list'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Return_list_model->get_by_id($id);

        if ($row) {
            $this->Return_list_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('return_list'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return_list'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	$this->form_validation->set_rules('jumlah', 'jumlah', 'trim|required');
	$this->form_validation->set_rules('date_create', 'date create', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id_return', 'id_return', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Return_list.php */
/* Location: ./application/controllers/Return_list.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-12-28 09:49:48 */
/* https://jualkoding.com */