<div class="col-md-12">
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">LIST DISPLAY</a></li>
      <li><a href="#tab_2" data-toggle="tab">AUTO DISPLAY</a></li>
      <li><a href="#tab_3" data-toggle="tab">RIWAYAT SELISIH</a></li>
      
    </ul>

    <div class="tab-content">

      <div class="tab-pane active" id="tab_1">


       
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
    <th>Foto</th>
    <th>Barcode</th>
    <th style="display: none;">Barcode2</th>
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
                if (stok_gudang($produk_display->id_subkategori) < $produk_display->orderan) {
                    // $bg = 'style="background-color: red; color: white"';
                    $bg = '';
                } else {
                    $bg = '';
                }
                ?>
                <tr <?php echo $bg ?> >
			<td width="80px"><?php echo $start ?></td>
      <td><img src="image/produk/<?php echo get_data('produk','id_produk',$produk_display->id_produk,'foto') ?>" style="width: 100px;"></td>
                   <td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'barcode1')) ?></td>
                   <td style="display: none;">
                    <?php 
                    $barc = $this->db->query("SELECT barcode1,barcode2 FROM `produk` where id_subkategori='$produk_display->id_subkategori'");
                    foreach ($barc->result() as $br) {
                      echo $br->barcode1.' '.$br->barcode2.' ';
                    }
                     ?>
                   </td>
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
                  <input type="hidden" name="ket" id="ket_selisih_gudang" value="">
                  <div class="input-group">
                    <input type="text" class="form-control input-sm" name="selisih_gudang" value="0" id="selisih_gudang">
                    <div class="input-group-btn">
                      <button class="btn btn-info btn-sm" type="submit" onclick="javasciprt: return add_ket_selisih_gudang();">
                        G
                      </button>
                    </div>
                  </div>
                </form>
            </td>
            <td>
                <form action="app/edit_selisih/display/<?php echo $produk_display->id_produk ?>" method="POST">
                  <input type="hidden" name="ket" id="ket_selisih_display" value="">
                  <div class="input-group">
                    <input type="text" class="form-control input-sm" name="selisih_display" value="0" id="selisih_display">
                    <div class="input-group-btn">
                      <button class="btn btn-info btn-sm" type="submit" onclick="javasciprt: return add_ket_selisih_display()">
                        D
                      </button>
                    </div>
                  </div>
                </form>
            </td>
            
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
        <table class="table table-bordered selisih" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
        <th>Foto</th>
        <th>Barcode</th>
        <th >Barcode2</th>
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

                 if (stok_gudang($produk_display->id_subkategori) < $produk_display->orderan) {
                    $bg = 'style="background-color: red; color: white"';
                } else {
                    $bg = '';
                }
                ?>
               
                <tr <?php echo $bg ?>>
            <td width="80px"><?php echo $start ?></td>
            <td><img src="image/produk/<?php echo get_data('produk','id_produk',$produk_display->id_produk,'foto') ?>" style="width: 100px;"></td>
                   <td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'barcode1')) ?></td>
                   <td ><?php 
                    $barc = $this->db->query("SELECT barcode1,barcode2 FROM `produk` where id_subkategori='$produk_display->id_subkategori'");
                    foreach ($barc->result() as $br) {
                      echo $br->barcode1.' '.$br->barcode2.' ';
                    }
                     ?></td>
            <td><?php echo strtoupper(get_data('subkategori','id_subkategori',$produk_display->id_subkategori,'subkategori')) ?></td>
            <td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'nama_produk')) ?></td>
            <td><?php echo $produk_display->stok ?></td>
            <td><?php echo stok_gudang($produk_display->id_subkategori) ?></td>
            <td><?php $t_stok = (stok_display($produk_display->id_subkategori) + stok_gudang($produk_display->id_subkategori)) / $produk_display->in_unit; echo number_format($t_stok,2); ?></td>
            <td><?php echo $produk_display->in_unit ?></td>
            <td><?php echo strtoupper(get_data('produk','id_produk',$produk_display->id_produk,'satuan')) ?></td>
            <td><?php echo $produk_display->display_min ?></td>
            <td><?php echo $produk_display->display_max ?></td>

            <td>
                <form action="app/edit_orderan/<?php echo $produk_display->id_produk.'/'.$produk_display->id_subkategori.'/'.$produk_display->orderan ?>" method="POST">
                    
                  <div class="input-group">
                    <input type="text" class="form-control input-sm" name="orderan" value="<?php echo $produk_display->orderan ?>">
                    <div class="input-group-btn">
                      <button class="btn btn-info btn-sm" type="submit" onclick="javasciprt: return confirm('Yakin Akan Melakukan Edit Orderan ?')">
                        <i class="glyphicon glyphicon-edit"></i>
                      </button>
                    </div>
                  </div>
                </form>
            </td>
            <td>0</td>
            <td>0</td>
            <td><?php echo $produk_display->date_create ?></td>
            <td><?php echo $produk_display->user_by ?></td>
            <td style="text-align:center" width="100px">
                <?php 
                echo anchor(site_url('app/konfirm_auto_display/'.$produk_display->id_produk.'/'.$produk_display->id_subkategori.'/'.$produk_display->orderan),'<span class="label label-info">Finish</span>','onclick="javasciprt: return confirm(\'Apakah kamu yakin finishkan auto display ini ?\')"'); 
                // echo ' | '; 
                // echo anchor(site_url('produk_display/delete/'.$produk_display->id_display),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
                ?>
                <a href="app/cancel_auto_display/<?php echo $produk_display->id_display ?>" class="label label-danger" onclick="javasciprt: return confirm('Yakin Akan Cancel ?')">Cancel</a>


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

<div class="tab-pane" id="tab_3">

  <div class="table-responsive">
    <table class="table table-bordered selisih">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Foto</th>
                  <th>Barcode</th>
                  <th style="display: none;">Barcode2</th>
                  <th>Produk</th>
                  <th>Stok Display Sblmnya</th>
                  <th>Stok Gudang Sblmnya</th>
                  <th>Selisih Display</th>
                  <th>Selisih Gudang</th>
                  <th>Ket Selisih Gudang</th>
                  <th>Ket Selisih Display</th>
                  <th>Date</th>
                  <th>User By</th>
                  <th>Option</th>
              </tr>
          </thead>
          <tbody>
              <?php 
              $no = 1;
              foreach ($this->db->get('selisih_display')->result() as $rw) {
                $id_subkategori = get_data('produk','id_produk',$rw->id_produk,'id_subkategori');
               ?>
               <tr>
                   <td><?php echo $no; ?></td>
                   <td><img src="image/produk/<?php echo get_data('produk','id_produk',$rw->id_produk,'foto') ?>" style="width: 100px;"></td>
                   <td><?php echo strtoupper(get_data('produk','id_produk',$rw->id_produk,'barcode1')) ?></td>
                   <td style="display: none;"><?php 
                    $barc = $this->db->query("SELECT barcode1,barcode2 FROM `produk` where id_subkategori='$id_subkategori'");
                    foreach ($barc->result() as $br) {
                      echo $br->barcode1.' '.$br->barcode2.' ';
                    }
                     ?></td>
                   <td><?php echo strtoupper(get_data('produk','id_produk',$rw->id_produk,'nama_produk')) ?></td>
                   <td><?php echo $rw->stok_display_old ?></td>
                   <td><?php echo $rw->stok_gudang_old ?></td>
                   <td><center><?php echo $rw->selisih_display ?></center></td>
                   <td><center><?php echo $rw->selisih_gudang ?></center></td>
                   <td><?php echo $rw->ket_selisih_gudang ?></td>
                   <td><?php echo $rw->ket_selisih_display ?></td>
                   <td><?php echo $rw->date_create ?></td>
                   <td><?php echo $rw->user_by ?></td>
                   <td>
                     <a href="app/hapus_selisih/<?php echo $rw->id ?>" class="label label-danger" onclick="javasciprt: return confirm('Yakin Akan Hapus ?')">Hapus</a>
                   </td>
               </tr>

            <?php $no++;} ?>
          </tbody>
      </table>
  </div>

</div>


</div> <!-- BATAS TAB KONTEN -->
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
</div>
<!-- /.col -->

<script type="text/javascript">
  function add_ket_selisih_gudang() {
    var ket = prompt("Keterangan Selisih Gudang:", "");
    if (ket == null || ket == "") {
      document.getElementById("selisih_gudang").value = '0';
    } else {
      document.getElementById("ket_selisih_gudang").value = ket;
    }
    

  }

  function add_ket_selisih_display() {
    var ket = prompt("Keterangan Selisih Display:", "");
    if (ket == null || ket == "") {
      document.getElementById("selisih_display").value = '0';
    } else {
      document.getElementById("ket_selisih_display").value = ket;
    }
   

  }
</script>

    