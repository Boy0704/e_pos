<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="<?php echo base_url() ?>">
	<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">

	<center>
		<h4>LAPORAN STOCK HPP PER-SUPLIER</h4>
	</center>

	

	<table class="table">
		<tr>
			<td>Nama Produk</td>
			<td>: <?php echo $nama_produk ?></td>
		</tr>
		<tr>
			<td>Periode</td>
			<td>: <?php echo $tgl1 ?> - <?php echo $tgl2 ?></td>
		</tr>
	</table>

	<table class="table table-striped">
		<tr>
			<th>Date Update</th>
			<th>Qty</th>
			<th>Unit</th>
			<th>In Unit</th>
			<th>In</th>
			<th>Out</th>
		</tr>

	<?php 
	$total = 0;
	$sql = "SELECT * FROM stok_transfer WHERE id_produk = '$id_produk' AND date_create BETWEEN '$tgl1' AND '$tgl2' ";
	$cetak = $this->db->query($sql);
	foreach ($cetak->result() as $row) {
	 ?>
		<tr>
			<td><?php echo $row->date_create ?></td>
			<td><?php echo get_data('produk','id_produk',$row->id_produk,'stok'); ?></td>
			<td><?php echo get_data('produk','id_produk',$row->id_produk,'satuan'); ?></td>
			<td><?php echo get_data('produk','id_produk',$row->id_produk,'in_unit'); ?></td>
			<td><?php echo $row->in_qty ?></td>
			<td><?php echo $row->out_qty ?></td>
		</tr>
	<?php } ?>
		
	</table>



</body>
</html>