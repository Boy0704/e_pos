<?php 
$po_master = $this->db->get_where('po_master', array('no_po'=>$this->uri->segment(3)))->row();
 ?>
<div style="margin-left: 10px;">
	<div class="row">
		<div class="col-md-3">
			<label>BARCODE SCANNER</label>
			<input type="text" name="barcode" class="form-control" id="barcode" autofocus="">
			
		</div>
		<div class="col-md-6">
			<label>SEARCH PRODUK</label>
			<select name="produk_search" id="produk_search" class="form-control select2" >
               <option value="">--CARI PRODUK--</option>
               <?php 
               foreach ($this->db->get('produk')->result() as $rw) {
                ?>
                <option value="<?php echo $rw->barcode1 ?>"><?php echo strtoupper($rw->nama_produk) ?></option>
              <?php } ?>
             </select>
		</div>

	</div><br>
	<p>
		<a href="pembelian/create/<?php echo $no_po ?>" class="btn btn-primary">Tambah Pembelian</a>
	</p>

	<div class="row">
		<div class="col-md-12 table-responsive">
			<div style="text-align: right;">
				<?php echo $retVal = ($po_master->ppn == 1) ? '<h4 class="label label-success"><i class="fa fa-check"></i> PPN</h4>' : '<h4 class="label label-danger"><i class="fa fa-close"></i> PPN</h4>' ; ?>
			</div>
			<table class="table table-bordered" id="example1">
				<thead>
					<tr>
						<th>No</th>
						<th>Barcode</th>
						<th>Produk</th>
						<th>Qty</th>
						<th>Satuan</th>
						<th>In Unit</th>
						<th>Diskon Beli</th>
						<th>Harga Beli</th>
						<th>HB + Diskon</th>
						<th>Subtotal</th>
						<th>Disc Jual</th>
						<th>Harga Jual</th>
						
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
						<td><?php echo strtoupper(get_data('produk','id_produk',$rw->id_produk,'barcode1')); ?></td>
						<td><?php echo strtoupper(get_data('produk','id_produk',$rw->id_produk,'nama_produk')); ?></td>
						
						<td><?php echo $rw->qty; ?></td>
						<td><?php echo $rw->satuan; ?></td>
						<td><?php echo $rw->in_unit; ?></td>
						<td><?php echo $rw->diskon; ?></td>
						<td><?php echo number_format($rw->harga_beli) ?></td>
						<td><?php echo number_format(get_diskon_beli($rw->diskon,$rw->harga_beli)) ?></td>
						<td><?php echo number_format($rw->total); $t = $t + $rw->total ?></td>
						<td><?php echo number_format($rw->diskon_jual); ?></td>
						<td><?php echo number_format($rw->harga_jual) ?></td>
						
						<td>
							<a href="pembelian/update/<?php echo $rw->id_pembelian ?>" class="label label-info">Edit</a>
							<a href="pembelian/delete/<?php echo $rw->id_pembelian.'/'.$rw->no_po ?>" class="label label-danger">Hapus</a>
						</td>
					</tr>
					<?php $no++; } ?>
					<!-- <tr>
						<td colspan="5">Total Harga Sebelum PH</td>
						<td colspan="2"><?php echo number_format($t) ?></td>
					</tr> -->
					<?php if ($po_master->ppn == 1){ ?>
						<tr>
							<td colspan="9">Total PPN</td>
							<td colspan="4"><b id="ppn"><?php echo number_format($t * 0.1) ?></b></td>
							<?php //$t = $t+($t * 0.1) ?>
						</tr>
					<?php } else { ?>
						<tr>
							<td colspan="9">Total DPP</td>
							<td colspan="4"><b id="ppn"><?php echo number_format($t / 1.1) ?></b></td>
							<?php //$t = $t+($t * 0.1) ?>
						</tr>
						<tr>
							<td colspan="9">Total PPN</td>
							<td colspan="4"><b id="ppn"><?php echo number_format($t - ($t/ 1.1) ) ?></b></td>
							<?php //$t = $t+($t * 0.1) ?>
						</tr>

					<?php } ?>
					<tr>
						<td colspan="9">Total Harga</td>
						<td colspan="4">
							<b id="potongan"><?php echo number_format($t) ?></b></td>
					</tr>
					
					
				</tbody>
			</table>
		</div>
		<p>
			<a href="po_master" class="btn btn-warning">Kembali PO Master</a>
		</p>
	</div>
	
</div>

<script type="text/javascript">
	
	$(document).ready(function() {

		$('#barcode').keypress(function(e) {
			if(e.which == 13) {
				var barcode = $(this).val();
				$.ajax({
					url: 'app/simpan_barcode_pembelian/<?php echo $no_po ?>',
					type: 'POST',
					dataType: 'html',
					data: {barcode: barcode},
				})
				.done(function() {
					console.log("success");
					window.location="<?php echo base_url() ?>app/isi_po/<?php echo $no_po ?>";
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
		        // $('tbody').append();
		    }
		});

		$('#produk_search').change(function(e) {
			
				var barcode = $(this).val();
				$.ajax({
					url: 'app/simpan_barcode_pembelian/<?php echo $no_po ?>',
					type: 'POST',
					dataType: 'html',
					data: {barcode: barcode},
				})
				.done(function() {
					console.log("success");
					window.location="<?php echo base_url() ?>app/isi_po/<?php echo $no_po ?>";
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
		        // $('tbody').append();
		    
		});



	});


</script>