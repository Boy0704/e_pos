<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Suplier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Suplier_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'suplier/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'suplier/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'suplier/index.html';
            $config['first_url'] = base_url() . 'suplier/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Suplier_model->total_rows($q);
        $suplier = $this->Suplier_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'suplier_data' => $suplier,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'suplier/suplier_list',
            'konten' => 'suplier/suplier_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Suplier_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_suplier' => $row->id_suplier,
		'suplier' => $row->suplier,
		'sales' => $row->sales,
		'alamat' => $row->alamat,
	    );
            $this->load->view('suplier/suplier_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('suplier'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'suplier/suplier_form',
            'konten' => 'suplier/suplier_form',
            'button' => 'Create',
            'action' => site_url('suplier/create_action'),
	    'id_suplier' => set_value('id_suplier'),
	    'suplier' => set_value('suplier'),
	    'sales' => set_value('sales'),
	    'alamat' => set_value('alamat'),
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
		'suplier' => $this->input->post('suplier',TRUE),
		'sales' => $this->input->post('sales',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Suplier_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('suplier'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Suplier_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'suplier/suplier_form',
                'konten' => 'suplier/suplier_form',
                'button' => 'Update',
                'action' => site_url('suplier/update_action'),
		'id_suplier' => set_value('id_suplier', $row->id_suplier),
		'suplier' => set_value('suplier', $row->suplier),
		'sales' => set_value('sales', $row->sales),
		'alamat' => set_value('alamat', $row->alamat),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('suplier'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_suplier', TRUE));
        } else {
            $data = array(
		'suplier' => $this->input->post('suplier',TRUE),
		'sales' => $this->input->post('sales',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
	    );

            $this->Suplier_model->update($this->input->post('id_suplier', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('suplier'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Suplier_model->get_by_id($id);

        if ($row) {
            $this->Suplier_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('suplier'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('suplier'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('suplier', 'suplier', 'trim|required');
	$this->form_validation->set_rules('sales', 'sales', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

	$this->form_validation->set_rules('id_suplier', 'id_suplier', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Suplier.php */
/* Location: ./application/controllers/Suplier.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-12-19 16:28:35 */
/* https://jualkoding.com */