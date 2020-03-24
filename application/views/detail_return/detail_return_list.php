
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('detail_return/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('detail_return/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('detail_return'); ?>" class="btn btn-default">Reset</a>
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
		<th>Id Produk</th>
		<th>Qty</th>
		<th>Satuan</th>
		<th>Harga Beli</th>
		<th>Total</th>
		<th>In Unit</th>
		<th>Harga Jual</th>
		<th>Diskon</th>
		<th>Value Diskon Hb</th>
		<th>Id Return</th>
		<th>Action</th>
            </tr><?php
            foreach ($detail_return_data as $detail_return)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $detail_return->id_produk ?></td>
			<td><?php echo $detail_return->qty ?></td>
			<td><?php echo $detail_return->satuan ?></td>
			<td><?php echo $detail_return->harga_beli ?></td>
			<td><?php echo $detail_return->total ?></td>
			<td><?php echo $detail_return->in_unit ?></td>
			<td><?php echo $detail_return->harga_jual ?></td>
			<td><?php echo $detail_return->diskon ?></td>
			<td><?php echo $detail_return->value_diskon_hb ?></td>
			<td><?php echo $detail_return->id_return ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('detail_return/update/'.$detail_return->id_detail_return),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('detail_return/delete/'.$detail_return->id_detail_return),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    