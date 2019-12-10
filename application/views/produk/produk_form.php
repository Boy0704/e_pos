
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="varchar">Foto Produk</label>
            <input type="file" class="form-control" name="foto" />
            <input type="hidden" name="old_foto" value="<?php echo $foto; ?>">
            <?php 
            if ($foto != '') {
             ?>
            <p><b>*) Foto Sebelumnya</b></p>
            <img src="image/produk/<?php echo $foto ?>" style="width: 100px;">
            <?php } ?>
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Produk <?php echo form_error('nama_produk') ?></label>
            <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>" />
        </div>
	    <div class="form-group">
            <label for="varbinary">Unit <?php echo form_error('satuan') ?></label>
            <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" />
        </div>
        <div class="form-group">
            <label for="varbinary">IN Unit </label>
            <input type="text" class="form-control" name="in_unit" id="in_unit" placeholder="In unit" value="<?php echo $in_unit; ?>" />
        </div>
        <div class="form-group">
            <label for="varbinary">Harga Beli </label>
            <input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder="Modal" value="<?php echo $harga_beli; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Stok <?php echo form_error('stok') ?></label>
            <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Stok Min <?php echo form_error('stok_min') ?></label>
            <input type="text" class="form-control" name="stok_min" id="stok_min" placeholder="Stok Min" value="<?php echo $stok_min; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Harga <?php echo form_error('harga') ?></label>
            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Barcode1 <?php echo form_error('barcode1') ?></label>
            <input type="text" class="form-control" name="barcode1" id="barcode1" placeholder="Barcode1" value="<?php echo $barcode1; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Barcode2 <?php echo form_error('barcode2') ?></label>
            <input type="text" class="form-control" name="barcode2" id="barcode2" placeholder="Barcode2" value="<?php echo $barcode2; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Owner <?php echo form_error('id_owner') ?></label>
            <!-- <input type="text" class="form-control" name="id_owner" id="id_owner" placeholder="Id Owner" value="<?php echo $id_owner; ?>" /> -->
            <?php echo select_option('id_owner','owner','owner','id_owner',null,null,'id=owner','<option value="'.$id_owner.'">'.get_data('owner','id_owner',$id_owner,'owner').'</option>'); ?>
        </div>
	    
	    
	    <div class="form-group">
            <label for="int">Subkategori <?php echo form_error('id_subkategori') ?></label>
            <!-- <input type="text" class="form-control" name="id_subkategori" id="id_subkategori" placeholder="Id Subkategori" value="<?php echo $id_subkategori; ?>" /> -->
            <?php echo select_option('id_subkategori','subkategori','subkategori','id_subkategori',null,null,'id=subkategori','<option value="'.$id_subkategori.'">'.get_data('subkategori','id_subkategori',$id_subkategori,'subkategori').'</option>'); ?>
        </div>
	    <div class="form-group">
            <label for="int">Jumlah Satuan <?php echo form_error('jumlah_satuan') ?></label>
            <input type="text" class="form-control" name="jumlah_satuan" id="jumlah_satuan" placeholder="Jumlah Satuan" value="<?php echo $jumlah_satuan; ?>" />
        </div>
	    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('app/produk/'.$id_subkategori) ?>" class="btn btn-default">Cancel</a>
	</form>
   