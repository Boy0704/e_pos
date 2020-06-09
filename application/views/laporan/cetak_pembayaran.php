<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="<?php echo base_url() ?>">
	<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">

	<center>
		<h4>LAPORAN PEMBAYARAN PELUNASAN & HUTANG SUPLIER</h4>
	</center>

	<table class="table">
		<tr>
			<td>Periode</td>
			<td>: <?php echo $tgl1 ?> - <?php echo $tgl2 ?></td>
		</tr>
	</table>

	<table class="table table-striped">
		<tr>
			<th>Date Update</th>
			<th>No PO</th>
			<th>Supplier</th>
			<th>Tipe Pembayaran</th>
			<th>Status</th>
			<th>Jumlah Bayar</th>
			<th>Sisa Bayar</th>
			<th>Total</th>
			<th>Pajak</th>
		</tr>

	<?php 
	$total = 0;
	$total_pajak = 0;
	$sql = "SELECT * FROM po_master WHERE date_create BETWEEN '$tgl1' AND '$tgl2' ";
	$cetak = $this->db->query($sql);
	foreach ($cetak->result() as $rw) {
		
	 ?>
		<tr>
			<td><?php echo $rw->date_create; ?></td>
			<td><?php echo $rw->no_po; ?></td>
			<td><?php echo $rw->nama_suplier; ?></td>
			<td><?php echo $rw->status_pembayaran; ?></td>
			<td><?php echo ($rw->selesai == '1') ? 'Finish' : 'Proses'; ?></td>
			<td><?php echo number_format($rw->jumlah_bayar) ?></td>
			<td><?php echo number_format($rw->sisa_bayar) ?></td>
			<td><?php echo number_format($rw->total_harga); $total = $total + $rw->total_harga ?></td>
			<td><?php echo number_format($rw->total_harga * 0.1); $total_pajak = $total_pajak + ($rw->total_harga * 0.1) ?></td>
			<td></td>
		</tr>
	<?php } ?>
		<tr>
			<th colspan="7">Total</th>
			<th><?php echo number_format($total) ?></th>
			<th><?php echo number_format($total_pajak) ?></th>
			<th></th>
		</tr>
	</table>

</body>
</html>