<div class="col-md-12">
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">LIST DISPLAY</a></li>
      <li><a href="#tab_2" data-toggle="tab">AUTO DISPLAY</a></li>
      
    </ul>

    <div class="tab-content">

      <div class="tab-pane active" id="tab_1">


        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php //echo anchor(site_url('produk_display/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <!-- <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?> -->
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('produk_display/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('produk_display'); ?>" class="btn btn-default">Reset</a>
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
		<th>Subkategori</th>
		<th>Produk</th>
		<th>Stok</th>
        <th>In Unit</th>
        <th>Satuan</th>
        <th>Display Min</th>
        <th>Display Max</th>
        <th>Stok Gudang</th>
        <th>Orderan</th>
        <th>Selisih Gudang</th>
        <th>Selisih Display</th>
		<th>Date Create</th>
		<th>User By</th>
		<th>Action</th>
            </tr><?php
            $start = 0;
            $produk_display_custom = $this->db->get_where('produk_display', array('auto_display'=1));
            foreach ($produk_display_data as $produk_display)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo strtoupper(get_data('subkategori','id_subkategori',$produk_display->id_subkategori,'subkategori')) ?></td>
			<td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'nama_produk')) ?></td>
			<td><?php echo $produk_display->stok ?></td>
            <td><?php echo $produk_display->in_unit ?></td>
			<td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'satuan')) ?></td>
            <td><?php echo $produk_display->display_min ?></td>
            <td><?php echo $produk_display->display_max ?></td>
            <td><?php echo $produk_display->stok_gudang ?></td>
            <td><?php echo $produk_display->orderan ?></td>
            <td><?php echo $produk_display->selisih_gudang ?></td>
            <td><?php echo $produk_display->selisih_display ?></td>
			<td><?php echo $produk_display->date_create ?></td>
			<td><?php echo $produk_display->user_by ?></td>
			<td style="text-align:center" width="100px">
				<?php 
				echo anchor(site_url('produk_display/update/'.$produk_display->id_display),'<span class="label label-info">Ubah</span>'); 
				// echo ' | '; 
				// echo anchor(site_url('produk_display/delete/'.$produk_display->id_display),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
</div>

<div class="tab-pane" id="tab_2">



</div>


</div> <!-- BATAS TAB KONTEN -->
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
</div>
<!-- /.col -->

        
    