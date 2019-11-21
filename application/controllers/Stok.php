<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Stok_model');
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'stok/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'stok/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'stok/index.html';
            $config['first_url'] = base_url() . 'stok/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Stok_model->total_rows($q);
        $stok = $this->Stok_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'stok_data' => $stok,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'stok/stok_list',
            'konten' => 'stok/stok_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Stok_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_stok' => $row->id_stok,
		'id_produk' => $row->id_produk,
		'stok' => $row->stok,
		'date_create' => $row->date_create,
		'date_update' => $row->date_update,
		'id_user' => $row->id_user,
	    );
            $this->load->view('stok/stok_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stok'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'stok/stok_form',
            'konten' => 'stok/stok_form',
            'button' => 'Create',
            'action' => site_url('stok/create_action'),
	    'id_stok' => set_value('id_stok'),
	    'id_produk' => set_value('id_produk'),
	    'stok' => set_value('stok'),
	    'date_create' => set_value('date_create'),
	    'date_update' => set_value('date_update'),
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
		'id_produk' => $this->input->post('id_produk',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'date_create' => date('Y-m-d H:i:s'),
		'id_user' => $this->input->post('id_user',TRUE),
	    );

            $this->Stok_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('stok'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Stok_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'stok/stok_form',
                'konten' => 'stok/stok_form',
                'button' => 'Update',
                'action' => site_url('stok/update_action'),
		'id_stok' => set_value('id_stok', $row->id_stok),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'stok' => set_value('stok', $row->stok),
		'date_create' => set_value('date_create', $row->date_create),
		'date_update' => set_value('date_update', $row->date_update),
		'id_user' => set_value('id_user', $row->id_user),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stok'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_stok', TRUE));
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'date_update' => date('Y-m-d H:i:s'),
		'id_user' => $this->input->post('id_user',TRUE),
	    );

            $this->Stok_model->update($this->input->post('id_stok', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('stok'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Stok_model->get_by_id($id);

        if ($row) {
            $this->Stok_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('stok'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('stok'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	$this->form_validation->set_rules('stok', 'stok', 'trim|required');
	// $this->form_validation->set_rules('date_create', 'date create', 'trim|required');
	// $this->form_validation->set_rules('date_update', 'date update', 'trim|required');
	// $this->form_validation->set_rules('id_user', 'id user', 'trim|required');

	$this->form_validation->set_rules('id_stok', 'id_stok', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Stok.php */
/* Location: ./application/controllers/Stok.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-21 00:44:45 */
/* https://jualkoding.com */