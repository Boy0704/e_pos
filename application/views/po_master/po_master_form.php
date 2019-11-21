
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">No Po <?php echo form_error('no_po') ?></label>
            <input type="text" class="form-control" name="no_po" id="no_po" placeholder="No Po" value="<?php echo $no_po; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Suplier <?php echo form_error('nama_suplier') ?></label>
            <input type="text" class="form-control" name="nama_suplier" id="nama_suplier" placeholder="Nama Suplier" value="<?php echo $nama_suplier; ?>" />
        </div>
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
            <label for="varchar">Qty <?php echo form_error('qty') ?></label>
            <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
        </div>
	    
	    <input type="hidden" name="id_po" value="<?php echo $id_po; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('po_master') ?>" class="btn btn-default">Cancel</a>
	</form>
   