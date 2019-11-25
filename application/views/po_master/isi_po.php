<div style="margin-left: 10px;">
	<p>
		<a href="pembelian/create/<?php echo $no_po ?>" class="btn btn-primary">Tambah Pembelian</a>
	</p>
	<div class="row">
		<div class="col-md-12 table-responsive">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Qty</th>
						<th>Satuan</th>
						<th>Harga Beli</th>
						<th>Subtotal</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$t = 0;
					$no = 1;
					foreach ($data->result() as $rw) {
					 ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo get_data('produk','id_produk',$rw->id_produk,'nama_produk'); ?></td>
						<td><?php echo $rw->qty; ?></td>
						<td><?php echo $rw->satuan; ?></td>
						<td><?php echo number_format($rw->harga_beli) ?></td>
						<td><?php echo number_format($rw->total); $t = $t + $rw->total ?></td>
						<td>
							<a href="pembelian/update/<?php echo $rw->id_pembelian ?>" class="label label-info">Edit</a>
							<a href="pembelian/delete/<?php echo $rw->id_pembelian.'/'.$rw->no_po ?>" class="label label-danger">Hapus</a>
						</td>
					</tr>
					<?php $no++; } ?>
					<tr>
						<td colspan="5">Total Harga Sebelum PH</td>
						<td colspan="2"><?php echo number_format($t) ?></td>
					</tr>
					<tr>
						<td colspan="5">Total PH</td>
						<td colspan="2">
							<b><?php echo number_format(get_ph($no_po,$t)) ?></b></td>
					</tr>
					<tr>
						<td colspan="5">Total PPN</td>
						<td colspan="2"><b><?php echo number_format(get_ph($no_po,$t) * 0.1) ?></b></td>
					</tr>
				</tbody>
			</table>
		</div>
		<p>
			<a href="po_master" class="btn btn-warning">Kembali PO Master</a>
		</p>
	</div>
	
</div>