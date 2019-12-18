<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">
	<center>
	<h4>MULTI MART</h4>
	<h5><?php echo get_setting('alamat') ?> </h5>
	<b>BENGKAYANG</b>
	</center>
	<hr style="border-bottom:3px dashed black;">

	
	<?php 
		$x = 1;
		$no = $this->uri->segment(3);
		foreach ($this->db->get_where('penjualan_detail', array('no_penjualan'=>$no))->result() as $rw) {
		 ?>
		<table width="100%">
			<tr>
				<td><?php echo strtoupper($rw->nama_produk) ?> <br> <?php echo $rw->qty.' '.strtoupper(get_data('produk','id_produk',$rw->id_produk,'satuan')).' x '.$rw->harga ?> <br> DISC <?php get_data('produk','id_produk',$rw->id_produk,'diskon').'/%' ?></td>
				<td><?php echo number_format($rw->subtotal) ?></td>
			</tr>
		</table>
		<hr style="border-bottom:3px dashed black;">
	<?php $x++; } ?>
	

	<table width="100%">
		<tr>
			<td>
				<table>
					<tr>
						<td>ITEM : <?php echo $x; ?></td>
					</tr>
					<tr>
						<td><?php echo $no; ?></td>
					</tr>
					<tr>
						<td><?php echo get_waktu() ?></td>
					</tr>
					<tr>
						<td>LOGIN BY : <?php echo $this->session->userdata('nama'); ?></td>
					</tr>
					<tr>
						<td>KASIR/MOBILE : 1</td>
					</tr>
				</table>
			</td>
			<td>
				<table>
					<tr>
						<td>TOTAL DISC : <?php echo get_data('penjualan_header','no_penjualan',$no,'total_disc'); ?></td>
					</tr>
					<tr>
						<td>TOTAL BAYAR : <?php echo get_data('penjualan_header','no_penjualan',$no,'total_harga'); ?></td>
					</tr>
					<tr>
						<td>CASH/DANA/DOKU : <?php echo get_data('penjualan_header','no_penjualan',$no,'total_bayar'); ?></td>
					</tr>
					<tr>
						<td>KEMBALI : <?php echo get_data('penjualan_header','no_penjualan',$no,'kembalian'); ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<p>
		<center>
			TERIMA KASIH <br>
			TELAH BELANJA DI TOKO KAMI 	<br>
			WEBSITE/APLIKASI	
		</center>
	</p>
	
		
</body>
</html>