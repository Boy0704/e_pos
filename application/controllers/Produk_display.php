<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_display extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Produk_display_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'produk_display/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'produk_display/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'produk_display/index.html';
            $config['first_url'] = base_url() . 'produk_display/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Produk_display_model->total_rows($q);
        $produk_display = $this->Produk_display_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'produk_display_data' => $produk_display,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'produk_display/produk_display_list',
            'konten' => 'produk_display/produk_display_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Produk_display_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_display' => $row->id_display,
		'id_produk' => $row->id_produk,
		'id_subkategori' => $row->id_subkategori,
		'stok' => $row->stok,
		'in_unit' => $row->in_unit,
		'date_create' => $row->date_create,
		'user_by' => $row->user_by,
	    );
            $this->load->view('produk_display/produk_display_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_display'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'produk_display/produk_display_form',
            'konten' => 'produk_display/produk_display_form',
            'button' => 'Create',
            'action' => site_url('produk_display/create_action'),
	    'id_display' => set_value('id_display'),
	    'id_produk' => set_value('id_produk'),
	    'id_subkategori' => set_value('id_subkategori'),
	    'stok' => set_value('stok'),
	    'in_unit' => set_value('in_unit'),
	    'date_create' => set_value('date_create'),
	    'user_by' => set_value('user_by'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        // log_r($_POST);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'id_subkategori' => $this->input->post('id_subkategori',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'in_unit' => $this->input->post('in_unit',TRUE),
		'date_create' => get_waktu(),
		'user_by' => $this->session->userdata('nama'),
	    );
            //cek apakah produk sudah ada di display
            $cek_display = $this->db->get_where('produk_display', array('id_produk'=>$this->input->post('id_produk')));
            if ($cek_display->num_rows() == 0) {
                $this->Produk_display_model->insert($data);
            }

            $out_produk_transfer = array(
                'id_produk' => $this->input->post('id_produk'),
                'id_subkategori' => $this->input->post('id_subkategori'),
                'out_qty' => floatval($this->input->post('stok')) * floatval($this->input->post('in_unit'))
            );
            $this->db->insert('stok_transfer', $out_produk_transfer);

            $in_display_transfer = array(
                'id_produk' => $this->input->post('id_produk'),
                'id_subkategori' => $this->input->post('id_subkategori'),
                'in_qty' => floatval($this->input->post('stok')) * floatval($this->input->post('in_unit')),
                'milik' => 'display'
            );
            $this->db->insert('stok_transfer', $in_display_transfer);

            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('produk_display'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Produk_display_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'produk_display/produk_display_form',
                'konten' => 'produk_display/produk_display_form',
                'button' => 'Update',
                'action' => site_url('produk_display/update_action'),
		'id_display' => set_value('id_display', $row->id_display),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'id_subkategori' => set_value('id_subkategori', $row->id_subkategori),
		'stok' => set_value('stok', $row->stok),
		'in_unit' => set_value('in_unit', $row->in_unit),
		'date_create' => set_value('date_create', $row->date_create),
		'user_by' => set_value('user_by', $row->user_by),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_display'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_display', TRUE));
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'id_subkategori' => $this->input->post('id_subkategori',TRUE),
		'stok' => $this->input->post('stok',TRUE),
		'in_unit' => $this->input->post('in_unit',TRUE),
		'date_create' => get_waktu(),
        'user_by' => $this->session->userdata('nama'),
	    );

            $this->Produk_display_model->update($this->input->post('id_display', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('produk_display'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Produk_display_model->get_by_id($id);

        if ($row) {
            $this->Produk_display_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('produk_display'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('produk_display'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	// $this->form_validation->set_rules('id_subkategori', 'id subkategori', 'trim|required');
	$this->form_validation->set_rules('stok', 'stok', 'trim|required|numeric');
	$this->form_validation->set_rules('in_unit', 'in unit', 'trim|required');
	// $this->form_validation->set_rules('date_create', 'date create', 'trim|required');
	// $this->form_validation->set_rules('user_by', 'user by', 'trim|required');

	$this->form_validation->set_rules('id_display', 'id_display', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Produk_display.php */
/* Location: ./application/controllers/Produk_display.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-12-18 13:18:39 */
/* https://jualkoding.com */