
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('kas_awal/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('kas_awal/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('kas_awal'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
        <th>Created</th>
		<th>Start From</th>
		<th>Until</th>
		<th>Kasir</th>
        <th>Kas Awal</th>
        <th>Total Jual</th>
        <th>Selisih</th>
		<th>Kas Akhir/Setoran</th>
		<th>Status</th>
		<th>Action</th>
            </tr><?php
            foreach ($kas_awal_data as $kas_awal)
            {
                $selisih = ($kas_awal->selisih == 0 && $kas_awal->setoran < $kas_awal->kas_awal) ? $kas_awal->setoran-$kas_awal->kas_awal : $kas_awal->selisih ;
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
            <td><?php echo $kas_awal->created_at ?></td>
			<td><?php echo $kas_awal->tgl1 ?></td>
			<td><?php echo $kas_awal->tgl2 ?></td>
			<td><?php echo get_data('a_user','id_user',$kas_awal->kasir,'nama_lengkap') ?></td>
			<td><?php echo number_format($kas_awal->kas_awal) ?></td>
            <td><?php echo number_format($kas_awal->total_jual) ?></td>
            <td><?php echo number_format(abs($selisih)) ?></td>
            <td><?php echo number_format($kas_awal->setoran) ?></td>
			<td><?php echo $retVal = ($kas_awal->status == '0') ? '<span class="label label-info">On Progress</span>' : '<span class="label label-success">Finish</span>' ; ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('kas_awal/update/'.$kas_awal->id),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('kas_awal/delete/'.$kas_awal->id),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    