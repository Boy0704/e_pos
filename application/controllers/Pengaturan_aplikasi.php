<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengaturan_aplikasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaturan_aplikasi_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pengaturan_aplikasi/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pengaturan_aplikasi/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pengaturan_aplikasi/index.html';
            $config['first_url'] = base_url() . 'pengaturan_aplikasi/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pengaturan_aplikasi_model->total_rows($q);
        $pengaturan_aplikasi = $this->Pengaturan_aplikasi_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pengaturan_aplikasi_data' => $pengaturan_aplikasi,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'pengaturan_aplikasi/pengaturan_aplikasi_list',
            'konten' => 'pengaturan_aplikasi/pengaturan_aplikasi_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Pengaturan_aplikasi_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_pengaturan' => $row->id_pengaturan,
		'nama_toko' => $row->nama_toko,
		'alamat' => $row->alamat,
		'nama_aplikasi' => $row->nama_aplikasi,
	    );
            $this->load->view('pengaturan_aplikasi/pengaturan_aplikasi_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengaturan_aplikasi'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'pengaturan_aplikasi/pengaturan_aplikasi_form',
            'konten' => 'pengaturan_aplikasi/pengaturan_aplikasi_form',
            'button' => 'Create',
            'action' => site_url('pengaturan_aplikasi/create_action'),
	    'id_pengaturan' => set_value('id_pengaturan'),
	    'nama_toko' => set_value('nama_toko'),
	    'alamat' => set_value('alamat'),
	    'nama_aplikasi' => set_value('nama_aplikasi'),
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
		'nama_toko' => $this->input->post('nama_toko',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'nama_aplikasi' => $this->input->post('nama_aplikasi',TRUE),
	    );

            $this->Pengaturan_aplikasi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pengaturan_aplikasi'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pengaturan_aplikasi_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'pengaturan_aplikasi/pengaturan_aplikasi_form',
                'konten' => 'pengaturan_aplikasi/pengaturan_aplikasi_form',
                'button' => 'Update',
                'action' => site_url('pengaturan_aplikasi/update_action'),
		'id_pengaturan' => set_value('id_pengaturan', $row->id_pengaturan),
		'nama_toko' => set_value('nama_toko', $row->nama_toko),
		'alamat' => set_value('alamat', $row->alamat),
		'nama_aplikasi' => set_value('nama_aplikasi', $row->nama_aplikasi),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengaturan_aplikasi'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pengaturan', TRUE));
        } else {
            $data = array(
		'nama_toko' => $this->input->post('nama_toko',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'nama_aplikasi' => $this->input->post('nama_aplikasi',TRUE),
	    );

            $this->Pengaturan_aplikasi_model->update($this->input->post('id_pengaturan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengaturan_aplikasi'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pengaturan_aplikasi_model->get_by_id($id);

        if ($row) {
            $this->Pengaturan_aplikasi_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengaturan_aplikasi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengaturan_aplikasi'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_toko', 'nama toko', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('nama_aplikasi', 'nama aplikasi', 'trim|required');

	$this->form_validation->set_rules('id_pengaturan', 'id_pengaturan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pengaturan_aplikasi.php */
/* Location: ./application/controllers/Pengaturan_aplikasi.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-12-15 09:34:03 */
/* https://jualkoding.com */