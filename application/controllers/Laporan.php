<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    
	public function penjualan()
	{
		if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'laporan/lap_penjualan',
            'judul_page' => 'Cari Laporan Penjualan',
		);
		$this->load->view('v_index', $data);
	}

	public function pembelian()
	{
		if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'laporan/lap_pembelian',
            'judul_page' => 'Cetak Laporan Pembelian',
		);
		$this->load->view('v_index', $data);
	}

	public function pembayaran()
	{
		if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'laporan/lap_pembayaran',
            'judul_page' => 'Cetak Laporan Pembayaran',
		);
		$this->load->view('v_index', $data);
	}

	public function barang()
	{
		if ($this->session->userdata('level') != 'admin') {
            redirect('login');
        }
		$data = array(
			'konten' => 'laporan/lap_barang',
            'judul_page' => 'Cetak Laporan Barang',
		);
		$this->load->view('v_index', $data);
	}

	public function proses_penjualan_struk()
	{
		$this->load->view('laporan/cetak_penjualan_struk', $_POST);

	}

	public function cek_barcode()
	{
		$barcode = $this->input->post('barcode');
		echo json_encode(
			array(
				'id_produk' => get_produk($barcode,'id_produk'),
				'barcode' => $barcode,
				'nama_produk' => get_produk($barcode,'nama_produk'),
			)
		);
	}

	public function proses_penjualan_item()
	{
		$this->load->view('laporan/cetak_penjualan_item', $_POST);

	}

	public function proses_penjualan_kasir()
	{
		$this->load->view('laporan/cetak_penjualan_kasir', $_POST);
	}

	public function proses_penjualan_pajak()
	{
		$this->load->view('laporan/cetak_penjualan_pajak', $_POST);
	}

	public function proses_lap_pembelian()
	{
		$this->load->view('laporan/cetak_pembelian', $_POST);
	}

	public function proses_lap_pembayaran()
	{
		$this->load->view('laporan/cetak_pembayaran', $_POST);
	}

	public function proses_lap_stok_hpp()
	{
		$this->load->view('laporan/cetak_stok_hpp', $_POST);
	}

	public function proses_lap_stok_in_out()
	{
		$this->load->view('laporan/cetak_stok_in_out', $_POST);
	}


}

/* End of file Laporan.php */
/* Location: ./application/controllers/Kategori.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-11-21 00:35:20 */
/* https://jualkoding.com */