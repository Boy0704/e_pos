
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
            <label for="varchar">Sales <?php echo form_error('sales') ?></label>
            <input type="text" class="form-control" name="sales" id="sales" placeholder="Sales" value="<?php echo $sales; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Potongan Harga <?php echo form_error('potongan_harga') ?></label>
            <input type="text" class="form-control" name="potongan_harga" id="potongan_harga" placeholder="ex : 100000;10%;20%" value="<?php echo $potongan_harga; ?>" />
        </div>
	    
	    <input type="hidden" name="id_po" value="<?php echo $id_po; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('po_master') ?>" class="btn btn-default">Cancel</a>
	</form>
   