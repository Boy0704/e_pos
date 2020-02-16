<div style="margin-left: 10px;">
	<p>
		<a href="produk/create/<?php echo $id_subkategori ?>" class="btn btn-primary">Tambah Produk</a>
	</p>
	<div class="row">
		<div class="col-md-12 table-responsive">
			<table class="table table-bordered" id="example1">
				<thead>
					<tr>
						<th>No</th>
						<th>Foto</th>
						<th>Sub Kategori</th>
						<th>Produk</th>
						<th>Stok</th>
						<th>Satuan</th>
						<th>In Unit</th>
						<th>Stok Min</th>
						<th>Disc HB</th>
						<th>Harga Beli</th>
						<th>Disc</th>
						<th>Price</th>
						<th>Barcode1</th>
						<th>Barcode2</th>
						<th>Note PO</th>
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
						<td><img src="image/produk/<?php echo $rw->foto; ?>" style="width: 100px;"></td>
						<td><?php echo get_data('subkategori','id_subkategori',$rw->id_subkategori,'subkategori'); ?></td>
						<td><?php echo $rw->nama_produk; ?></td>
						<td><?php echo $rw->stok; ?></td>
						<td><?php echo $rw->satuan ?></td>
						<td><?php echo $rw->in_unit ?></td>
						<td><?php echo $rw->stok_min ?></td>
						<td><?php echo $rw->value_diskon_hb ?></td>
						<td><?php echo $rw->harga_beli ?></td>
						<td><?php echo $rw->diskon ?></td>
						<td><?php echo $rw->harga ?></td>
						<td><?php echo $rw->barcode1 ?></td>
						<td><?php echo $rw->barcode2 ?></td>
						<td><?php echo $rw->note_po ?></td>
						<td><?php echo get_data('owner','id_owner',$rw->id_owner,'owner') ?></td>
						<td><?php echo $rw->date_update ?></td>
						<td>
							
							<a href="produk/update/<?php echo $rw->id_produk ?>" class="label label-info">Edit</a>
							<a onclick="javasciprt: return confirm('Yakin hapus produk ini ?')" href="produk/delete/<?php echo $rw->id_produk.'/'.$rw->id_subkategori ?>" class="label label-danger">Hapus</a>
							<a href="#" class="label label-success" data-toggle="modal" data-target="#editStok">Edit Stok Khusus</a>

							<!-- Modal Edit Stok Khusus-->
							  <div class="modal fade" id="editStok" role="dialog">
							    <div class="modal-dialog">
							    
							      <!-- Modal content-->
							      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">Edit Stok Khusus</h4>
							        </div>
							        <div class="modal-body">
							          <form action="app/edit_stok_khusus/<?php echo $rw->id_produk.'/'.$rw->id_subkategori ?>" method="POST">
							          	<label>Stok</label>
							          	<input type="text" name="stok_edit" value="<?php echo $rw->stok ?>" class="form-control">
							          	<input type="hidden" name="stok_now" value="<?php echo $rw->stok ?>">
							          
							        </div>
							        <div class="modal-footer">
							          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							          <button type="submit" class="btn btn-info">UPDATE</button>
							          </form>
							        </div>
							      </div>
							      
							    </div>
							  </div>

						</td>
					</tr>
					<?php $no++; } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>