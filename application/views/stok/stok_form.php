
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Produk <?php echo form_error('id_produk') ?></label>
            <!-- <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" /> -->
            <select name="id_produk" class="form-control">
                <option value="<?php echo $id_produk ?>"><?php echo $id_produk ?></option>
                <?php 
                foreach ($this->db->get('produk')->result() as $row) {
                 ?>
                <option value="<?php echo $row->id_produk ?>"><?php echo $row->nama_produk ?></option>
            <?php } ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Stok <?php echo form_error('stok') ?></label>
            <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo $stok; ?>" />
        </div>
	    <!-- <div class="form-group">
            <label for="datetime">Date Create <?php echo form_error('date_create') ?></label>
            <input type="text" class="form-control" name="date_create" id="date_create" placeholder="Date Create" value="<?php echo $date_create; ?>" />
        </div>
	    <div class="form-group">
            <label for="datetime">Date Update <?php echo form_error('date_update') ?></label>
            <input type="text" class="form-control" name="date_update" id="date_update" placeholder="Date Update" value="<?php echo $date_update; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id User <?php echo form_error('id_user') ?></label>
            <input type="text" class="form-control" name="id_user" id="id_user" placeholder="Id User" value="<?php echo $id_user; ?>" />
        </div> -->
	    <input type="hidden" name="id_stok" value="<?php echo $id_stok; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('stok') ?>" class="btn btn-default">Cancel</a>
	</form>
   