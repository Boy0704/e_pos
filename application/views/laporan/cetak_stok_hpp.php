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

	<?php 
	$total_all = 0;
	if ($cari_suplier == 'all') {
		$where = '';
	} else {
		$where = "AND nama_suplier='$cari_suplier' ";
	}
	$sql = $this->db->query("SELECT * FROM po_master WHERE date_create BETWEEN '$tgl1' AND '$tgl2' $where ");
	foreach ($sql->result() as $rw): ?>
		
	

	<table class="table">
		<tr>
			<td>Nama Suplier</td>
			<td>: <?php echo $rw->nama_suplier ?></td>
		</tr>
		<tr>
			<td>Periode</td>
			<td>: <?php echo $tgl1 ?> - <?php echo $tgl2 ?></td>
		</tr>
	</table>

	<table class="table table-striped">
		<tr>
			<th>Barcode</th>
			<th>Nama Produk</th>
			<th>Qty</th>
			<th>Unit</th>
			<th>In Unit</th>
			<th>Modal</th>
			<th>Total</th>
		</tr>

	<?php 
	$total = 0;
	$sql = "SELECT * FROM pembelian WHERE no_po = '$rw->no_po' ";
	$cetak = $this->db->query($sql);
	foreach ($cetak->result() as $row) {
	 ?>
		<tr>
			<td><?php echo get_data('produk','id_produk',$row->id_produk,'barcode1'); ?></td>
			<td><?php echo get_data('produk','id_produk',$row->id_produk,'nama_produk'); ?></td>
			<td><?php echo $row->qty ?></td>
			<td><?php echo $row->satuan ?></td>
			<td><?php echo $row->in_unit ?></td>
			<td><?php echo number_format($row->harga_beli) ?></td>
			<td><?php echo number_format($row->total); $total = $total + $row->total; ?></td>
		</tr>
	<?php } ?>
		<tr>
			<th colspan="6">Total</th>
			<th><?php echo number_format($total); $total_all = $total_all + $total; $total=0; ?></th>
		</tr>
	</table>

	<?php endforeach ?>

	<div style="text-align: left; float: left;">
		<h4>Grand Total</h4>
	</div>
	<div style="text-align: right;">
		<h4><?php echo number_format($total_all) ?></h4>
	</div>



</body>
</html>