<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Return_new extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Return_new_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'return_new/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'return_new/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'return_new/index.html';
            $config['first_url'] = base_url() . 'return_new/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Return_new_model->total_rows($q);
        $return_new = $this->Return_new_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'return_new_data' => $return_new,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'return_new/return_new_list',
            'konten' => 'return_new/return_new_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Return_new_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_return' => $row->id_return,
		'id_suplier' => $row->id_suplier,
		'sales' => $row->sales,
		'total' => $row->total,
		'keterangan' => $row->keterangan,
		'date_create' => $row->date_create,
	    );
            $this->load->view('return_new/return_new_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return_new'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'return_new/return_new_form',
            'konten' => 'return_new/return_new_form',
            'button' => 'Create',
            'action' => site_url('return_new/create_action'),
	    'id_return' => set_value('id_return'),
	    'id_suplier' => set_value('id_suplier'),
	    'sales' => set_value('sales'),
	    'total' => set_value('total'),
	    'keterangan' => set_value('keterangan'),
	    'date_create' => set_value('date_create'),
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
		'id_suplier' => $this->input->post('id_suplier',TRUE),
		'sales' => $this->input->post('sales',TRUE),
		'total' => $this->input->post('total',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'date_create' => $this->input->post('date_create',TRUE),
	    );

            $this->Return_new_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('return_new'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Return_new_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'return_new/return_new_form',
                'konten' => 'return_new/return_new_form',
                'button' => 'Update',
                'action' => site_url('return_new/update_action'),
		'id_return' => set_value('id_return', $row->id_return),
		'id_suplier' => set_value('id_suplier', $row->id_suplier),
		'sales' => set_value('sales', $row->sales),
		'total' => set_value('total', $row->total),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'date_create' => set_value('date_create', $row->date_create),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return_new'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_return', TRUE));
        } else {
            $data = array(
		'id_suplier' => $this->input->post('id_suplier',TRUE),
		'sales' => $this->input->post('sales',TRUE),
		'total' => $this->input->post('total',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'date_create' => $this->input->post('date_create',TRUE),
	    );

            $this->Return_new_model->update($this->input->post('id_return', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('return_new'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Return_new_model->get_by_id($id);

        if ($row) {
            $this->Return_new_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('return_new'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('return_new'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_suplier', 'id suplier', 'trim|required');
	$this->form_validation->set_rules('sales', 'sales', 'trim|required');
	$this->form_validation->set_rules('total', 'total', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('date_create', 'date create', 'trim|required');

	$this->form_validation->set_rules('id_return', 'id_return', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Return_new.php */
/* Location: ./application/controllers/Return_new.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-24 07:30:03 */
/* https://jualkoding.com */