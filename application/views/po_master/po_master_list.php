
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('po_master/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('po_master/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('po_master'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>No Po</th>
		<th>Nama Suplier</th>
		<th>Sales</th>
		<th>Potongan Harga</th>
		<th>Date Create</th>
		<th>Action</th>
            </tr><?php
            foreach ($po_master_data as $po_master)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $po_master->no_po ?></td>
			<td><?php echo $po_master->nama_suplier ?></td>
			<td><?php echo $po_master->sales ?></td>
			<td><?php echo $po_master->potongan_harga ?></td>
			<td><?php echo $po_master->date_create ?></td>
			<td style="text-align:center" width="200px">
                <a href="app/isi_po/<?php echo $po_master->no_po ?>" class="label label-primary">Tambah PO Pembelian</a>
				<?php 
				echo anchor(site_url('po_master/update/'.$po_master->id_po),'<span class="label label-info">Ubah</span>'); 
				echo ' '; 
				echo anchor(site_url('po_master/delete/'.$po_master->id_po),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    