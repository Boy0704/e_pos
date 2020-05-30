<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kas_awal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kas_awal_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kas_awal/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kas_awal/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kas_awal/index.html';
            $config['first_url'] = base_url() . 'kas_awal/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kas_awal_model->total_rows($q);
        $kas_awal = $this->Kas_awal_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kas_awal_data' => $kas_awal,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'kas_awal/kas_awal_list',
            'konten' => 'kas_awal/kas_awal_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Kas_awal_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'tgl1' => $row->tgl1,
		'tgl2' => $row->tgl2,
		'kasir' => $row->kasir,
		'kas_awal' => $row->kas_awal,
		'status' => $row->status,
	    );
            $this->load->view('kas_awal/kas_awal_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kas_awal'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'kas_awal/kas_awal_form',
            'konten' => 'kas_awal/kas_awal_form',
            'button' => 'Create',
            'action' => site_url('kas_awal/create_action'),
	    'id' => set_value('id'),
	    'tgl1' => set_value('tgl1'),
	    'tgl2' => set_value('tgl2'),
	    'kasir' => set_value('kasir'),
	    'kas_awal' => set_value('kas_awal'),
        'status' => set_value('status'),
        'total_jual' => set_value('total_jual'),
        'selisih' => set_value('selisih'),
	    'setoran' => set_value('setoran'),
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
		'tgl1' => $this->input->post('tgl1',TRUE),
		'tgl2' => $this->input->post('tgl2',TRUE),
		'kasir' => $this->input->post('kasir',TRUE),
		'kas_awal' => $this->input->post('kas_awal',TRUE),
        'status' => $this->input->post('status',TRUE),
        'total_jual' => $this->input->post('total_jual',TRUE),
        'selisih' => $this->input->post('selisih',TRUE),
		'setoran' => $this->input->post('setoran',TRUE),
        'created_at' => get_waktu()
	    );

            $this->Kas_awal_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kas_awal'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kas_awal_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'kas_awal/kas_awal_form',
                'konten' => 'kas_awal/kas_awal_form',
                'button' => 'Update',
                'action' => site_url('kas_awal/update_action'),
		'id' => set_value('id', $row->id),
		'tgl1' => set_value('tgl1', $row->tgl1),
		'tgl2' => set_value('tgl2', $row->tgl2),
		'kasir' => set_value('kasir', $row->kasir),
		'kas_awal' => set_value('kas_awal', $row->kas_awal),
        'status' => set_value('status', $row->status),
        'total_jual' => set_value('total_jual', $row->total_jual),
        'selisih' => set_value('selisih', $row->selisih),
		'setoran' => set_value('setoran', $row->setoran),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kas_awal'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'tgl1' => $this->input->post('tgl1',TRUE),
		'tgl2' => $this->input->post('tgl2',TRUE),
		'kasir' => $this->input->post('kasir',TRUE),
		'kas_awal' => $this->input->post('kas_awal',TRUE),
        'status' => $this->input->post('status',TRUE),
        'total_jual' => $this->input->post('total_jual',TRUE),
        'selisih' => $this->input->post('selisih',TRUE),
		'setoran' => $this->input->post('setoran',TRUE),
        'created_at' => get_waktu()
	    );

            $this->Kas_awal_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kas_awal'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kas_awal_model->get_by_id($id);

        if ($row) {
            $this->Kas_awal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kas_awal'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kas_awal'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('tgl1', 'tgl1', 'trim|required');
	$this->form_validation->set_rules('tgl2', 'tgl2', 'trim|required');
	$this->form_validation->set_rules('kasir', 'kasir', 'trim|required');
	$this->form_validation->set_rules('kas_awal', 'kas awal', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kas_awal.php */
/* Location: ./application/controllers/Kas_awal.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-05-30 13:53:13 */
/* https://jualkoding.com */