<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="<?php echo base_url() ?>">
	<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">

	<center>
		<h4>LAPORAN PENJUALAN PAJAK BULAN/HARIAN</h4>
	</center>

	<table class="table">
		<tr>
			<td>Periode</td>
			<td>: <?php echo $tgl1 ?> - <?php echo $tgl2 ?></td>
		</tr>
	</table>

	<table class="table table-striped">
		<tr>
			<th>Date</th>
			<th>No Struk</th>
			<th>Pembayaran</th>
			<th>Total Jual</th>
			<th>Total Modal</th>
			<th>Profit</th>
			<th>Pajak</th>
		</tr>

	<?php 
	$sql = "SELECT * FROM penjualan_header WHERE date_create BETWEEN '$tgl1' AND '$tgl2' ";
	$cetak = $this->db->query($sql);
	$total_modal = 0;
	$total_profit = 0;
	$total_jual = 0;
	foreach ($cetak->result() as $rw) {
		$modal = total_modal_produk($rw->no_penjualan);
		$profit = $rw->total_harga - $modal; 
		$total_jual = $total_jual + $rw->total_harga;
		$total_modal = $total_modal + $modal;
		$total_profit = $total_profit + $profit;
	 ?>
		<tr>
			<td><?php echo $rw->date_create; ?></td>
			<td><?php echo $rw->no_penjualan; ?></td>
			<td><?php echo $rw->jenis_pembayaran; ?></td>
			<td><?php echo number_format($rw->total_harga); ?></td>
			<td><?php echo number_format($modal) ?></td>
			<td><?php echo number_format($profit) ?></td>
			<td></td>
		</tr>
	<?php } ?>
		<tr>
			<th colspan="3">Total</th>
			<th><?php echo number_format($total_modal) ?></th>
			<th><?php echo number_format($total_modal) ?></th>
			<th><?php echo number_format($total_profit) ?></th>
			<th></th>
		</tr>
	</table>

</body>
</html>