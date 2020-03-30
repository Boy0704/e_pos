
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('return_new/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <!-- <div class="col-md-3 text-right">
                <form action="<?php echo site_url('return_new/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('return_new'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div> -->
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
		<th>Suplier</th>
		<th>Sales</th>
		<th>Total</th>
		<th>Keterangan</th>
		<th>Date Create</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($return_new_data as $return_new)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo get_data('suplier','id_suplier',$return_new->id_suplier,'suplier') ?></td>
			<td><?php echo $return_new->sales ?></td>
			<td><?php echo $return_new->total ?></td>
			<td><?php echo $return_new->keterangan ?></td>
			<td><?php echo $return_new->date_create ?></td>
			<td style="text-align:center" width="200px">
				<?php 
                echo anchor(site_url('app/isi_return/'.$return_new->id_return),'<span class="label label-success">Detail</span>'); 
                echo ' | '; 
				echo anchor(site_url('return_new/update/'.$return_new->id_return),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('return_new/delete/'.$return_new->id_return),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <!-- <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div> -->
    