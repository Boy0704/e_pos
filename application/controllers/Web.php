<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {



	public function index(){

		$data['subview'] = 'front/home';
		$this->load->view('front/components/main', $data);
	}

	public function login() {

		$this->load->view('front/v_login');

	}

	public function register() {

		$this->load->view('front/v_register');

	}

	public function save()
	{
		$this->db->insert('pelanggan',$_POST);
		$this->session->set_flashdata('message', alert_biasa('Berhasil Mendaftar, Silahkan Login','success'));
    	redirect('web/login','refresh');
	}

	public function aksi_login()
	{
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
			$cek_user = $this->db->query("SELECT * FROM pelanggan WHERE email='$email' and password='$password' ");
			// if (password_verify($password, $hashed)) {
			if ($cek_user->num_rows() > 0) {
				foreach ($cek_user->result() as $row) {
					
                    $sess_data['id_pelanggan'] = $row->id_pelanggan;
					$sess_data['nama_pelanggan'] = $row->nama_pelanggan;
					$sess_data['email'] = $row->email;
					$sess_data['password'] = $row->password;
					$sess_data['no_hp'] = $row->no_hp;
					$sess_data['alamat'] = $row->alamat;
					$this->session->set_userdata($sess_data);
				}

				// define('FOTO', $this->session->userdata('foto'), TRUE);
				

				// print_r($this->session->userdata());
				// exit;
				// $sess_data['username'] = $username;
				// $this->session->set_userdata($sess_data);

				redirect('web');
			} else {
				$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n username atau password kamu salah','warning'));
				// $this->session->set_flashdata('message', alert_tunggu('Gagal Login!\n username atau password kamu salah','warning'));
				redirect('login','refresh');
			}
	}

	

	function logout()
	{
		$this->session->unset_userdata('id_pelanggan');
		$this->session->unset_userdata('nama_pelanggan');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('password');
		session_destroy();
		redirect('web/login','refresh');
	}

	public function profil(){
		$email = $this->session->userdata('email');

		$data['profil'] = $this->db->query("SELECT * FROM pelanggan WHERE email = '$email' ")->row();
		$data['subview'] = 'front/profil';
		$this->load->view('front/components/main', $data);
	}

	public function update_profil(){

		$this->db->update('pelanggan',$_POST);
		redirect('web/profil','refresh');
	}
}