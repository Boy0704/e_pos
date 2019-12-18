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
				foreach ($this->db->query("SELECT * FROM produk WHERE stok_min >= stok")->result() as $rw) {
				 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo strtoupper(get_data('subkategori','id_subkategori',$rw->id_subkategori,'subkategori')); ?></td>
					<td><?php echo strtoupper($rw->nama_produk) ?></td>
					<td><?php echo $rw->stok ?></td>
					<td><?php echo $rw->stok_min ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
