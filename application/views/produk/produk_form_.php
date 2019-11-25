
        <form action="<?php echo $action; ?>" method="post">
        <div class="form-group">
            <label for="int">Kategori Produk <?php echo form_error('id_kategori') ?></label>
            <!-- <input type="text" class="form-control" name="id_owner" id="id_owner" placeholder="Id Owner" value="<?php echo $id_owner; ?>" /> -->
            <select name="id_kategori" class="form-control">
                <option value="<?php echo $id_kategori ?>"><?php echo $id_kategori ?></option>
                <?php 
                foreach ($this->db->get('kategori')->result() as $row) {
                 ?>
                <option value="<?php echo $row->id_kategori ?>"><?php echo $row->kategori ?></option>
            <?php } ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Produk <?php echo form_error('nama_produk') ?></label>
            <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Nama Produk" value="<?php echo $nama_produk; ?>" />
        </div>
	    <div class="form-group">
            <label for="varbinary">Satuan <?php echo form_error('satuan') ?></label>
            <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" />
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
            <select name="id_owner" class="form-control">
                <option value="<?php echo $id_owner ?>"><?php echo $id_owner ?></option>
                <?php 
                foreach ($this->db->get('owner')->result() as $row) {
                 ?>
                <option value="<?php echo $row->id_owner ?>"><?php echo $row->owner ?></option>
            <?php } ?>
            </select>
        </div>
        </div>
	    <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('produk') ?>" class="btn btn-default">Cancel</a>
	</form>
   