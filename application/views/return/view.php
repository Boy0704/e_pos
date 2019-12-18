<div style="margin-left: 10px;">
	
	<div class="row">
		<div class="col-md-12 table-responsive">
			<table class="table table-bordered" id="example1">
				<thead>

					<tr>
						<th>No</th>
						<th>No Penjualan</th>
						<th>Total Harga</th>
						<th>Total Bayar</th>
						<th>Kembalian</th>
						<th>Date Create</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$no = 1;
					$data = $this->db->get_where('penjualan_header',array('return'=>1));
					foreach ($data->result() as $rw) {
					 ?>
					<tr>
						<td><?php echo $no; ?></td>
						<td><?php echo $rw->no_penjualan; ?></td>
						<td><?php echo number_format($rw->total_harga); ?></td>
						<td><?php echo number_format($rw->total_bayar); ?></td>
						<td><?php echo number_format($rw->kembalian); ?></td>
						<td><?php echo $rw->date_create; ?></td>
						<td>
							<a href="app/cetak_belanja/<?php echo $rw->no_penjualan ?>" target="_blank" class="btn btn-info btn-sm">Cetak Struk</a>
						</td>
					</tr>
					<?php $no++; } ?>
				</tbody>
			</table>
		</div>
	</div>
	
</div>