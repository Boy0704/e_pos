<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success">
			<h2>Selamat Datang kembali, <?php echo $this->session->userdata('username'); ?></h2>
		</div>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<h2>Stok yang sudah mau habis </h2>
		<table class="table table-bordered table-hover">
			<thead style="background-color: red;color: white">
				<tr>
					<th>#</th>
					<th>Subkategori</th>
					<th>Nama Produk</th>
					<th>Stok</th>
					<th>Stok Min</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1; 
				foreach ($this->db->query("SELECT * FROM produk as p WHERE p.stok_min >= (SELECT
		((COALESCE(SUM(in_qty),0) - COALESCE(SUM(out_qty),0)) ) AS stok_akhir 
	FROM
		stok_transfer
	WHERE
		id_subkategori=p.id_subkategori)")->result() as $rw) {
				 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo strtoupper(get_data('subkategori','id_subkategori',$rw->id_subkategori,'subkategori')); ?></td>
					<td><?php echo strtoupper($rw->nama_produk) ?></td>
					<td><?php echo stok_display($rw->id_subkategori) + stok_gudang($rw->id_subkategori) ?></td>
					<td><?php echo $rw->stok_min ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
