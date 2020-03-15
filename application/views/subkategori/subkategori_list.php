
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('subkategori/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <!-- <form action="<?php echo site_url('subkategori/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('subkategori'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form> -->
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px" id="example1">
            <thead>
            <tr>
                <th>No</th>
		<th>Subkategori</th>
        <th>Kategori</th>
        <th>Barcode</th>
        <th style="display: none;">Barcode 2</th>
		<th>Suplier</th>
		<th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($subkategori_data as $subkategori)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $subkategori->subkategori ?></td>
			<td><?php echo get_data('kategori','id_kategori',$subkategori->id_kategori,'kategori') ?></td>
            <td>
                <?php 
                echo $this->db->get_where('produk', array('id_subkategori'=>$subkategori->id_subkategori,'in_unit'=>1))->row()->barcode1;
                 ?>
            </td>
            <td style="display: none;">
                    <?php 
                    $barc = $this->db->query("SELECT barcode1,barcode2 FROM `produk` where id_subkategori='$subkategori->id_subkategori'");
                    foreach ($barc->result() as $br) {
                      echo $br->barcode1.' '.$br->barcode2.' ';
                    }
                     ?>
            </td>
            <td>
                <?php echo get_data('suplier','id_suplier',$subkategori->id_suplier,'suplier') ?>
            </td>
			<td style="text-align:center" width="200px">
                <a href="app/dropzone/<?php echo $subkategori->id_subkategori ?>" class="label label-success">Add Img Online</a>
                <a href="app/produk/<?php echo $subkategori->id_subkategori ?>" class="label label-primary">Tambah Produk</a>
				<?php 
				echo anchor(site_url('subkategori/update/'.$subkategori->id_subkategori),'<span class="label label-info">Ubah</span>'); 
				echo ' '; 
				echo anchor(site_url('subkategori/delete/'.$subkategori->id_subkategori),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    