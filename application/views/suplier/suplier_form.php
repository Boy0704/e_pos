
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Suplier <?php echo form_error('suplier') ?></label>
            <input type="text" class="form-control" name="suplier" id="suplier" placeholder="Suplier" value="<?php echo $suplier; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Sales <?php echo form_error('sales') ?></label>
            <input type="text" class="form-control" name="sales" id="sales" placeholder="Sales" value="<?php echo $sales; ?>" />
        </div>
	    <div class="form-group">
            <label for="alamat">Alamat <?php echo form_error('alamat') ?></label>
            <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
        </div>
	    <input type="hidden" name="id_suplier" value="<?php echo $id_suplier; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('suplier') ?>" class="btn btn-default">Cancel</a>
	</form>
   