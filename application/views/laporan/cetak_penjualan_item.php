<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="<?php echo base_url() ?>">
	<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">

	<center>
		<h4>LAPORAN PENJUALAN ITEM</h4>
	</center>

	<table class="table">
		<tr>
			<td>Barcode</td>
			<td>: <?php echo $barcode ?></td>
		</tr>
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
			<th>Date</th>
			<th>Out</th>
			<th>Satuan</th>
			<th>In Unit</th>
			<th>Harga Beli</th>
			<th>Harga Jual</th>
			<th>Profit</th>
		</tr>

	<?php 
	$sql = "SELECT ph.date_create, pd.qty, pd.subtotal  FROM penjualan_header as ph, penjualan_detail as pd  WHERE ph.no_penjualan=pd.no_penjualan and pd.id_produk='$id_produk' and ph.date_create BETWEEN '$tgl1' AND '$tgl2' ";
	$cetak = $this->db->query($sql);
	$total_profit = 0;
	foreach ($cetak->result() as $rw) {
		$harga_beli = $rw->qty * get_data('produk','id_produk',$id_produk,'harga_beli');
		$profit = $rw->subtotal - $harga_beli; 
		$total_profit = $total_profit + $profit;
	 ?>
		<tr>
			<td><?php echo $rw->date_create; ?></td>
			<td><?php echo $rw->qty; ?></td>
			<td><?php echo get_data('produk','id_produk',$id_produk,'satuan'); ?></td>
			<td><?php echo get_data('produk','id_produk',$id_produk,'in_unit'); ?></td>
			<td><?php echo number_format($harga_beli); ?></td>
			<td><?php echo number_format($rw->subtotal); ?></td>
			<td><?php echo number_format($profit); ?></td>
		</tr>
	<?php } ?>
		<tr>
			<th colspan="6">Total</th>
			<th><?php echo number_format($total_profit) ?></th>
		</tr>
	</table>

</body>
</html>