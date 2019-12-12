<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">
	<center>
	<h4>TOKO ABC</h4>
	<h5>Jl. Suryahadi Kec.Talang Bakung No.Telp: 0778-93455 </h5>
	</center>
	<hr>

	<table class="table">
		<tr>
			<th>Produk</th>
			<th>qty</th>
			<th>Price</th>
			<th>Subtotal</th>
		</tr>

		<?php 
		$no = $this->uri->segment(3);
		foreach ($this->db->get_where('penjualan_detail', array('no_penjualan'=>$no))->result() as $rw) {
		 ?>
		<tr>
			<td><?php echo $rw->nama_produk ?></td>
			<td><?php echo $rw->qty ?></td>
			<td><?php echo number_format($rw->harga) ?></td>
			<td><?php echo number_format($rw->subtotal) ?></td>
		</tr>
	<?php } ?>
		<tr>
			<td colspan="3">Total Disc</td>
			<td><?php echo number_format(get_data('penjualan_header','no_penjualan',$no,'total_disc')); ?></td>
		</tr>
		<tr>
			<td colspan="3">Total Bayar</td>
			<td><?php echo number_format(get_data('penjualan_header','no_penjualan',$no,'total_harga')); ?></td>
		</tr>
	</table>

</body>
</html>