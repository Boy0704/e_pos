<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Detail_return extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Detail_return_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'detail_return/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'detail_return/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'detail_return/index.html';
            $config['first_url'] = base_url() . 'detail_return/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Detail_return_model->total_rows($q);
        $detail_return = $this->Detail_return_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'detail_return_data' => $detail_return,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'detail_return/detail_return_list',
            'konten' => 'detail_return/detail_return_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Detail_return_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_detail_return' => $row->id_detail_return,
		'id_produk' => $row->id_produk,
		'qty' => $row->qty,
		'satuan' => $row->satuan,
		'harga_beli' => $row->harga_beli,
		'total' => $row->total,
		'in_unit' => $row->in_unit,
		'harga_jual' => $row->harga_jual,
		'diskon' => $row->diskon,
		'value_diskon_hb' => $row->value_diskon_hb,
		'id_return' => $row->id_return,
	    );
            $this->load->view('detail_return/detail_return_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('detail_return'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'detail_return/detail_return_form',
            'konten' => 'detail_return/detail_return_form',
            'button' => 'Create',
            'action' => site_url('detail_return/create_action'),
	    'id_detail_return' => set_value('id_detail_return'),
	    'id_produk' => set_value('id_produk'),
	    'qty' => set_value('qty'),
	    'satuan' => set_value('satuan'),
	    'harga_beli' => set_value('harga_beli'),
	    'total' => set_value('total'),
	    'in_unit' => set_value('in_unit'),
	    'harga_jual' => set_value('harga_jual'),
	    'diskon' => set_value('diskon'),
	    'value_diskon_hb' => set_value('value_diskon_hb'),
	    'id_return' => set_value('id_return'),
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
		'qty' => $this->input->post('qty',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'total' => $this->input->post('total',TRUE),
		'in_unit' => $this->input->post('in_unit',TRUE),
		'harga_jual' => $this->input->post('harga_jual',TRUE),
		'diskon' => $this->input->post('diskon',TRUE),
		'value_diskon_hb' => $this->input->post('value_diskon_hb',TRUE),
		'id_return' => $this->input->post('id_return',TRUE),
	    );

            $this->Detail_return_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('app/isi_return/'.$this->input->post('id_return',TRUE)));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Detail_return_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'detail_return/detail_return_form',
                'konten' => 'detail_return/detail_return_form',
                'button' => 'Update',
                'action' => site_url('detail_return/update_action'),
		'id_detail_return' => set_value('id_detail_return', $row->id_detail_return),
		'id_produk' => set_value('id_produk', $row->id_produk),
		'qty' => set_value('qty', $row->qty),
		'satuan' => set_value('satuan', $row->satuan),
		'harga_beli' => set_value('harga_beli', $row->harga_beli),
		'total' => set_value('total', $row->total),
		'in_unit' => set_value('in_unit', $row->in_unit),
		'harga_jual' => set_value('harga_jual', $row->harga_jual),
		'diskon' => set_value('diskon', $row->diskon),
		'value_diskon_hb' => set_value('value_diskon_hb', $row->value_diskon_hb),
		'id_return' => set_value('id_return', $row->id_return),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('detail_return'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_detail_return', TRUE));
        } else {
            $data = array(
		'id_produk' => $this->input->post('id_produk',TRUE),
		'qty' => $this->input->post('qty',TRUE),
		'satuan' => $this->input->post('satuan',TRUE),
		'harga_beli' => $this->input->post('harga_beli',TRUE),
		'total' => $this->input->post('total',TRUE),
		'in_unit' => $this->input->post('in_unit',TRUE),
		'harga_jual' => $this->input->post('harga_jual',TRUE),
		'diskon' => $this->input->post('diskon',TRUE),
		'value_diskon_hb' => $this->input->post('value_diskon_hb',TRUE),
		'id_return' => $this->input->post('id_return',TRUE),
	    );

            $this->Detail_return_model->update($this->input->post('id_detail_return', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('app/isi_return/'.$this->input->post('id_return',TRUE)));
        }
    }
    
    public function delete($id,$id_return) 
    {
        $row = $this->Detail_return_model->get_by_id($id);

        if ($row) {
            $this->Detail_return_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('app/isi_return/'.$id_return));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('app/isi_return/'.$id_return));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_produk', 'id produk', 'trim|required');
	$this->form_validation->set_rules('qty', 'qty', 'trim|required');
	$this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
	$this->form_validation->set_rules('harga_beli', 'harga beli', 'trim|required');
	$this->form_validation->set_rules('total', 'total', 'trim|required');
	$this->form_validation->set_rules('in_unit', 'in unit', 'trim|required');
	// $this->form_validation->set_rules('harga_jual', 'harga jual', 'trim|required');
	$this->form_validation->set_rules('diskon', 'diskon', 'trim|required');
	// $this->form_validation->set_rules('value_diskon_hb', 'value diskon hb', 'trim|required');
	$this->form_validation->set_rules('id_return', 'id return', 'trim|required');

	$this->form_validation->set_rules('id_detail_return', 'id_detail_return', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Detail_return.php */
/* Location: ./application/controllers/Detail_return.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2020-03-24 08:28:08 */
/* https://jualkoding.com */