<div style="margin-left: 10px;">
	<p>
		<a href="produk/create/<?php echo $id_subkategori ?>" class="btn btn-primary">Tambah Produk</a>
	</p>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered" id="example1">
				<thead>
					<tr>
						<th>No</th>
						<th>Sub Kategori</th>
						<th>Produk</th>
						<th>Stok</th>
						<th>Satuan</th>
						<th>Jumlah Satuan</th>
						<th>Stok Min</th>
						<th>Harga</th>
						<th>Barcode1</th>
						<th>Barcode2</th>
						<th>Owner</th>
						<th>Date Update</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					foreach ($data->result() as $rw) {
					 ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo get_data('subkategori','id_subkategori',$rw->id_subkategori,'subkategori'); ?></td>
						<td><?php echo $rw->nama_produk; ?></td>
						<td><?php echo $rw->stok; ?></td>
						<td><?php echo $rw->satuan ?></td>
						<td><?php echo $rw->jumlah_satuan ?></td>
						<td><?php echo $rw->stok_min ?></td>
						<td><?php echo $rw->harga ?></td>
						<td><?php echo $rw->barcode1 ?></td>
						<td><?php echo $rw->barcode2 ?></td>
						<td><?php echo get_data('owner','id_owner',$rw->id_owner,'owner') ?></td>
						<td><?php echo $rw->date_update ?></td>
						<td>
							<a href="produk/update/<?php echo $rw->id_produk ?>" class="label label-info">Edit</a>
							<a href="produk/delete/<?php echo $rw->id_produk.'/'.$rw->id_subkategori ?>" class="label label-danger">Hapus</a>
						</td>
					</tr>
					<?php $no++; } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>