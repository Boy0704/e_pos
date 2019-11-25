
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php //echo anchor(site_url('pembelian/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('pembelian/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('pembelian'); ?>" class="btn btn-default">Reset</a>
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
		<th>Id Produk</th>
		<th>Qty</th>
		<th>Satuan</th>
		<th>Harga Beli</th>
		<th>Total</th>
		<th>Action</th>
            </tr><?php
            foreach ($pembelian_data as $pembelian)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $pembelian->no_po ?></td>
			<td><?php echo $pembelian->id_produk ?></td>
			<td><?php echo $pembelian->qty ?></td>
			<td><?php echo $pembelian->satuan ?></td>
			<td><?php echo $pembelian->harga_beli ?></td>
			<td><?php echo $pembelian->total ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('pembelian/update/'.$pembelian->id_pembelian),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('pembelian/delete/'.$pembelian->id_pembelian),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    