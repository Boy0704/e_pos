<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<th>#</th>
				<th>Nama Produk</th>
				<th>Unit</th>
				<th>Harga Jual</th>
				<th>Option</th>
			</thead>
			<tbody>
			<?php 
			error_reporting(0);
			$no = 1;
			foreach ($this->db->get_where('produk',array('id_subkategori'=>$id_subkategori))->result() as $rw) {
				$hj_temp = $this->db->get('harga_jual_temp', array('no_po'=>$no_po,'id_produk'=>$rw->id_produk));
				$v_hj = $hj_temp->row()->harga_jual;
			 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $rw->nama_produk ?></td>
					<td><?php echo $rw->satuan ?></td>
					<td>
						<input type="text" class="form-control" id="hj_<?php echo $rw->id_produk ?>" name="harga_jual" value="<?php echo $retVal = ($hj_temp->num_rows() > 0) ? $v_hj : $rw->harga ; ?>">
						<input type="hidden" class="form-control" id="id_produk_<?php echo $rw->id_produk ?>" name="id_produk" value="<?php echo $rw->id_produk ?>">
						<input type="hidden" class="form-control" id="id_subkategori_<?php echo $rw->id_produk ?>" name="id_subkategori" value="<?php echo $rw->id_subkategori ?>">
					</td>
					<td>
						<a id="simpan_<?php echo $rw->id_produk ?>" onclick="simpan_hj('<?php echo $rw->id_produk ?>');" class="btn btn-primary" >Simpan</a>
					</td>
					</form>
				</tr>
			<?php $no++; } ?>
			</tbody>
		</table>
	</div>
</div>

<!-- <script type="text/javascript">
	$(document).ready(function() {
		
	});
</script> -->