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
        <th>Log Display</th>
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
            <td>
                <form action="app/edit_selisih/gudang/<?php echo $produk_display->id_produk ?>" method="POST">
                    
                  <div class="input-group">
                    <input type="text" class="form-control input-sm" name="selisih_gudang" value="<?php echo $produk_display->selisih_gudang ?>">
                    <div class="input-group-btn">
                      <button class="btn btn-info btn-sm" type="submit" onclick="javasciprt: return confirm('Yakin Akan Melakukan Edit Selisih ?')">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </div>
                  </div>
                </form>
            </td>
            <td>
                <form action="app/edit_selisih/display/<?php echo $produk_display->id_produk ?>" method="POST">
                    
                  <div class="input-group">
                    <input type="text" class="form-control input-sm" name="selisih_display" value="<?php echo $produk_display->selisih_display ?>">
                    <div class="input-group-btn">
                      <button class="btn btn-info btn-sm" type="submit" onclick="javasciprt: return confirm('Yakin Akan Melakukan Edit Selisih ?')">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </div>
                  </div>
                </form>
            </td>
            <td>
                <a href="#" class="label label-warning" data-toggle="modal" data-target="#l_selisih<?php echo $produk_display->id_produk; ?>">lihat log selisih</a>

                <!-- Modal Edit Stok Khusus-->
                  <div class="modal fade" id="l_selisih<?php echo $produk_display->id_produk; ?>" role="dialog">
                    <div class="modal-dialog modal-lg">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Riwayat Selisih <b><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'nama_produk')) ?></b></h4>
                        </div>
                        <div class="modal-body">
                          
                          <table class="table table-bordered selisih">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Selisih Display</th>
                                      <th>Selisih Gudang</th>
                                      <th>Date</th>
                                      <th>User By</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                  $no = 1;
                                  foreach ($this->db->get_where('selisih_display', array('id_produk'=>$produk_display->id_produk))->result() as $rw) {
                                   ?>
                                   <tr>
                                       <td><?php echo $no; ?></td>
                                       <td><center><?php echo $rw->selisih_display ?></center></td>
                                       <td><center><?php echo $rw->selisih_gudang ?></center></td>
                                       <td><?php echo $rw->date_create ?></td>
                                       <td><?php echo $rw->user_by ?></td>
                                   </tr>

                                <?php $no++;} ?>
                              </tbody>
                          </table>
                          
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      
                    </div>
                  </div>
            </td>
			<td><?php echo $produk_display->date_create ?></td>
			<td><?php echo $produk_display->user_by ?></td>
			<td style="text-align:center" width="100px">
				<?php 
				echo anchor(site_url('produk_display/update/'.$produk_display->id_display),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('produk_display/delete/'.$produk_display->id_display),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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

        
    