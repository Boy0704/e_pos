<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="<?php echo base_url() ?>">
	<link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
</head>
<body onload="print()">

	<center>
		<h4>LAPORAN PENJUALAN KASIR/CLIENT</h4>
	</center>

	<table class="table">
		<tr>
			<td>Periode</td>
			<td>: <?php echo $tgl1 ?> - <?php echo $tgl2 ?></td>
		</tr>
	</table>

	<table class="table table-striped">
		<tr>
			<th>From</th>
			<th>Until</th>
			<th>Kasir</th>
			<th>Kas Awal</th>
			<th>Total Jual</th>
			<th>Kas Akhir Atau Setoran</th>
		</tr>

	
	</table>

</body>
</html>