<div class="col-md-12">
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">LIST DISPLAY</a></li>
      <li><a href="#tab_2" data-toggle="tab">AUTO DISPLAY</a></li>
      
    </ul>

    <div class="tab-content">

      <div class="tab-pane active" id="tab_1">


       
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
		<th>Subkategori</th>
		<th>Produk</th>
		<th>Stok Display</th>
        <th>Stok Gudang</th>
        <th>Total Stok</th>
        <th>In Unit</th>
        <th>Satuan</th>
        <th>Display Min</th>
        <th>Display Max</th>
        
        <th>Orderan</th>
        <th>Selisih Gudang</th>
        <th>Selisih Display</th>
		<th>Date Create</th>
		<th>User By</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody><?php
            $bg = '';
            $start = 1;
            $produk_display_custom = $this->db->get_where('produk_display', array('auto_display'=>1));
            foreach ($produk_display_custom->result() as $produk_display)
            {
                if ($produk_display->stok <= $produk_display->display_min) {
                    $bg = 'style="background-color: red; color: white"';
                } else {
                    $bg = '';
                }
                ?>
                <tr <?php echo $bg ?> >
			<td width="80px"><?php echo $start ?></td>
			<td><?php echo strtoupper(get_data('subkategori','id_subkategori',$produk_display->id_subkategori,'subkategori')) ?></td>
			<td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'nama_produk')) ?></td>
			<td><?php echo $produk_display->stok ?></td>
            <td><?php echo stok_gudang($produk_display->id_subkategori) ?></td>
            <td><?php $t_stok = (stok_display($produk_display->id_subkategori) + stok_gudang($produk_display->id_subkategori)) / $produk_display->in_unit; echo number_format($t_stok,2); ?></td>
            <td><?php echo $produk_display->in_unit ?></td>
			<td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'satuan')) ?></td>
            <td><?php echo $produk_display->display_min ?></td>
            <td><?php echo $produk_display->display_max ?></td>

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
                $start++;
            }
            ?>
            </tbody>
        </table>
        </div>
</div>

<div class="tab-pane" id="tab_2">

    <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example2">
            <thead>
            <tr>
                <th>No</th>
        <th>Subkategori</th>
        <th>Produk</th>
        <th>Stok Display</th>
        <th>Stok Gudang</th>
        <th>Total Stok</th>
        <th>In Unit</th>
        <th>Satuan</th>
        <th>Display Min</th>
        <th>Display Max</th>
        
        <th>Orderan</th>
        <th>Selisih Gudang</th>
        <th>Selisih Display</th>
        <th>Date Create</th>
        <th>User By</th>
        <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 1;
            $produk_display_custom = $this->db->get_where('produk_display', array('auto_display'=>0));
            foreach ($produk_display_custom->result() as $produk_display)
            {
               
                ?>
                <tr>
            <td width="80px"><?php echo $start ?></td>
            <td><?php echo strtoupper(get_data('subkategori','id_subkategori',$produk_display->id_subkategori,'subkategori')) ?></td>
            <td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'nama_produk')) ?></td>
            <td><?php echo $produk_display->stok ?></td>
            <td><?php echo stok_gudang($produk_display->id_subkategori) ?></td>
            <td><?php $t_stok = (stok_display($produk_display->id_subkategori) + stok_gudang($produk_display->id_subkategori)) / $produk_display->in_unit; echo number_format($t_stok,2); ?></td>
            <td><?php echo $produk_display->in_unit ?></td>
            <td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'satuan')) ?></td>
            <td><?php echo $produk_display->display_min ?></td>
            <td><?php echo $produk_display->display_max ?></td>

            <td><?php echo $produk_display->orderan ?></td>
            <td><?php echo $produk_display->selisih_gudang ?></td>
            <td><?php echo $produk_display->selisih_display ?></td>
            <td><?php echo $produk_display->date_create ?></td>
            <td><?php echo $produk_display->user_by ?></td>
            <td style="text-align:center" width="100px">
                <?php 
                echo anchor(site_url('app/konfirm_auto_display/'.$produk_display->id_produk.'/'.$produk_display->id_subkategori.'/'.$produk_display->orderan),'<span class="label label-info">Finish</span>','onclick="javasciprt: return confirm(\'Apakah kamu yakin finishkan auto display ini ?\')"'); 
                // echo ' | '; 
                // echo anchor(site_url('produk_display/delete/'.$produk_display->id_display),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                ?>


            </td>
        </tr>
        </tbody>
                <?php
                $start++;
            }
            ?>
        </table>
        </div>

</div>


</div> <!-- BATAS TAB KONTEN -->
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
</div>
<!-- /.col -->

        
    