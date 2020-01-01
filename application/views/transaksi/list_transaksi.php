<div style="margin-left: 10px;">
	
	<div class="row">
		<div class="col-md-12 table-responsive">
			<table class="table table-bordered" id="example1">
				<thead>

					<tr>
						<th>No</th>
						<th>No Penjualan</th>
						<th>Total Harga</th>
						<th>Jenis Pembayaran</th>
						<!-- <th>Kembalian</th> -->
						<th>Date Create</th>
						<th>(TH - Return)</th>
						<th>Return</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					$this->db->order_by('id_penjualan', 'desc');
					$data = $this->db->get('penjualan_header');
					foreach ($data->result() as $rw) {
					 ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $rw->no_penjualan; ?></td>
						<td><?php echo number_format($rw->total_harga); ?></td>
						<td><?php echo $rw->jenis_pembayaran; ?></td>
						<!-- <td><?php echo number_format($rw->kembalian); ?></td> -->
						<!-- <td><?php echo cek_return($rw->return,$rw->no_penjualan); ?></td> -->
						<td><?php echo $rw->date_create; ?></td>
						<td><?php echo number_format($rw->total_setelah_return); ?></td>
						<td>
							<?php 
							if ($rw->return == '1') {
								?>
								<a>
									<span class="label label-success" data-toggle="modal" data-target="#no_return<?php echo $rw->no_penjualan ?>">Detail</span>
								</a>
								<?php
							} else {
							 ?>

							<span class="label label-info">no return</span>

							<?php } ?>
							<!-- Modal -->
							<div id="no_return<?php echo $rw->no_penjualan ?>" class="modal fade" role="dialog">
							  <div class="modal-dialog">

							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Detail Return</h4>
							      </div>
							      <div class="modal-body">
							        
							      	<h3>No Return : <?php echo $rw->no_penjualan ?></h3>

							      	<table class="table table-bordered">
							      		<tr>
							      			<th>Produk</th>
							      			<th>Harga</th>
							      			<th>Qty</th>
							      		</tr>
							      		<?php 
							      		foreach ($this->db->get_where('return_list', array('no_return'=>$rw->no_penjualan))->result() as $b) {
							      		 ?>
							      		<tr>
							      			<td><?php echo strtoupper(get_data('produk','id_produk',$b->id_produk,'nama_produk')); ?></td>
							      			<td><?php echo strtoupper(get_data('produk','id_produk',$b->id_produk,'harga')); ?></td>
							      			<td><?php echo $b->jumlah ?></td>
							      		</tr>
							      	<?php } ?>
							      	</table>


							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							      </div>
							    </div>

							  </div>
							</div>

						</td>
						<td>
							<a href="return_list/create/<?php echo $rw->no_penjualan ?>" target="_blank" class="btn btn-primary btn-sm">Return</a>
							<a href="app/cetak_belanja/<?php echo $rw->no_penjualan ?>" target="_blank" class="btn btn-info btn-sm">Cetak Struk</a>
						</td>
					</tr>
					<?php $no++; } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>