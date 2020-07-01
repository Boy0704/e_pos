<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subkategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Subkategori_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'subkategori/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'subkategori/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'subkategori/index.html';
            $config['first_url'] = base_url() . 'subkategori/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Subkategori_model->total_rows($q);
        $subkategori = $this->Subkategori_model->get_limit_data($config['per_page'], $start, $q);
        // log_data($this->db->last_query());

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'subkategori_data' => $subkategori,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'subkategori/subkategori_list',
            'konten' => 'subkategori/subkategori_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Subkategori_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_subkategori' => $row->id_subkategori,
		'subkategori' => $row->subkategori,
		'id_kategori' => $row->id_kategori,
	    );
            $this->load->view('subkategori/subkategori_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('subkategori'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'subkategori/subkategori_form',
            'konten' => 'subkategori/subkategori_form',
            'button' => 'Create',
            'action' => site_url('subkategori/create_action'),
	    'id_subkategori' => set_value('id_subkategori'),
	    'subkategori' => set_value('subkategori'),
        'id_kategori' => set_value('id_kategori'),
	    'id_suplier' => set_value('id_suplier'),
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
		'subkategori' => $this->input->post('subkategori',TRUE),
        'id_kategori' => $this->input->post('id_kategori',TRUE),
		'id_suplier' => $this->input->post('id_suplier',TRUE),
	    );

            $this->Subkategori_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('subkategori'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Subkategori_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'subkategori/subkategori_form',
                'konten' => 'subkategori/subkategori_form',
                'button' => 'Update',
                'action' => site_url('subkategori/update_action'),
		'id_subkategori' => set_value('id_subkategori', $row->id_subkategori),
		'subkategori' => set_value('subkategori', $row->subkategori),
        'id_kategori' => set_value('id_kategori', $row->id_kategori),
		'id_suplier' => set_value('id_suplier', $row->id_suplier),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('subkategori'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_subkategori', TRUE));
        } else {
            $data = array(
		'subkategori' => $this->input->post('subkategori',TRUE),
        'id_kategori' => $this->input->post('id_kategori',TRUE),
		'id_suplier' => $this->input->post('id_suplier',TRUE),
	    );

            $this->Subkategori_model->update($this->input->post('id_subkategori', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('subkategori'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Subkategori_model->get_by_id($id);

        if ($row) {
            // $this->Subkategori_model->delete($id);
            $this->db->where('id_subkategori', $id);
            $this->db->update('subkategori', array('status_delete'=>'1'));
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('subkategori'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('subkategori'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('subkategori', 'subkategori', 'trim|required');
	$this->form_validation->set_rules('id_kategori', 'id kategori', 'trim|required');

	$this->form_validation->set_rules('id_subkategori', 'id_subkategori', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Subkategori.php */
/* Location: ./application/controllers/Subkategori.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-25 07:08:33 */
/* https://jualkoding.com */