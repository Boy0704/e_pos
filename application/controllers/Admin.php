<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'admin/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'admin/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'admin/index.html';
            $config['first_url'] = base_url() . 'admin/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Admin_model->total_rows($q);
        $admin = $this->Admin_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'admin_data' => $admin,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'admin/admin_list',
            'konten' => 'admin/admin_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Admin_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_user' => $row->id_user,
		'nama' => $row->nama,
		'username' => $row->username,
		'password' => $row->password,
		'email' => $row->email,
		'status' => $row->status,
		'akses' => $row->akses,
	    );
            $this->load->view('admin/admin_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'admin/admin_form',
            'konten' => 'admin/admin_form',
            'button' => 'Create',
            'action' => site_url('admin/create_action'),
	    'id_user' => set_value('id_user'),
	    'nama' => set_value('nama'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
	    'email' => set_value('email'),
	    'status' => set_value('status'),
	    'akses' => set_value('akses'),
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
		'nama' => $this->input->post('nama',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => md5($this->input->post('password',TRUE)),
		'email' => $this->input->post('email',TRUE),
		'status' => $this->input->post('status',TRUE),
		'akses' => $this->input->post('akses',TRUE),
	    );

            $this->Admin_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Admin_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'admin/admin_form',
                'konten' => 'admin/admin_form',
                'button' => 'Update',
                'action' => site_url('admin/update_action'),
		'id_user' => set_value('id_user', $row->id_user),
		'nama' => set_value('nama', $row->nama),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'email' => set_value('email', $row->email),
		'status' => set_value('status', $row->status),
		'akses' => set_value('akses', $row->akses),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
            $data = array(
		'nama' => $this->input->post('nama',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => md5($this->input->post('password',TRUE)),
		'email' => $this->input->post('email',TRUE),
		'status' => $this->input->post('status',TRUE),
		'akses' => $this->input->post('akses',TRUE),
	    );

            $this->Admin_model->update($this->input->post('id_user', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Admin_model->get_by_id($id);

        if ($row) {
            $this->Admin_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('akses', 'akses', 'trim|required');

	$this->form_validation->set_rules('id_user', 'id_user', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-30 16:04:46 */
/* https://jualkoding.com */