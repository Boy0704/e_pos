<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-stripped" id="example1">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Level</th>
					<th>Date</th>
					<th>Status</th>
				</tr>
				<tbody>
					<?php
					$no = 1;
					$this->db->order_by('id_log', 'desc');
					 foreach ($this->db->get('log_user')->result() as $rw): ?>
						<tr>
							<td><?php echo $no ?></td>
							<td><?php echo strtoupper($rw->nama) ?></td>
							<td><?php echo strtoupper($rw->level) ?></td>
							<td><?php echo strtoupper($rw->date_at) ?></td>
							<td><?php echo strtoupper($rw->status) ?></td>
						</tr>
					<?php $no++; endforeach ?>
				</tbody>
			</thead>
		</table>
	</div>
</div>