<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<th>#</th>
				<th>Nama Produk</th>
				<th>In Unit</th>
				<th>Unit</th>
				<th>Harga Beli</th>
				<th>Setelah Diskon</th>
				<?php 
				$cek_p = cek_ppn($no_po);
				if ($cek_p == '1') {
				 ?>
				<th>Setelah PPN</th>
				<?php } ?>
				<th>Disc Beli</th>
				<th>Disc Jual</th>
				<th>Harga Jual</th>
				<th>Option</th>
			</thead>
			<tbody>
			<?php 
			// error_reporting(0);
			$no = 1;
			$hj_temp = $this->db->get('harga_jual_temp', array('no_po'=>$no_po,'id_subkategori'=>$id_subkategori));
			if ($hj_temp->num_rows() == 0) {
				foreach ($this->db->get_where('produk',array('id_subkategori'=>$id_subkategori))->result() as $dt) {
					$this->db->insert('harga_jual_temp', array(
						'no_po'=>$no_po,
						'id_produk'=>$dt->id_produk,
						'id_subkategori'=>$dt->id_subkategori,
						'harga_jual'=>$dt->harga,
						'harga_beli'=>$dt->harga_beli,
						'setelah_diskon'=>0,
						'setelah_ppn'=>0,
						'diskon_hj'=>$dt->diskon,
						'diskon_hb'=>$dt->diskon_hb,
					));
				}

			}
			
			foreach ($this->db->get_where('harga_jual_temp',array('id_subkategori'=>$id_subkategori,'no_po'=>$no_po))->result() as $rw) {
				
				// $v_hj = $hj_temp->row()->harga_jual;
			 ?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo get_data('produk','id_produk',$rw->id_produk,'nama_produk') ?></td>
					<td><?php echo get_data('produk','id_produk',$rw->id_produk,'in_unit') ?></td>
					<td><?php echo get_data('produk','id_produk',$rw->id_produk,'satuan') ?></td>
					<td><?php echo $rw->harga_beli ?></td>
					<td><?php echo $rw->setelah_diskon ?></td>
					<?php 
						$cek_p = cek_ppn($no_po);
						if ($cek_p == '1') {
					 ?>
					<td><?php echo $rw->setelah_ppn ?></td>
					
					<?php } ?>
					<td><?php echo $rw->diskon_hb ?></td>
					<td>
						<input type="text" class="form-control" id="diskon_hj_<?php echo $rw->id_produk ?>" name="diskon_hj" value="<?php echo $rw->diskon_hj; ?>">
					</td>
					<td>
						<input type="text" class="form-control" id="hj_<?php echo $rw->id_produk ?>" name="harga_jual" value="<?php echo $rw->harga_jual; ?>">
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