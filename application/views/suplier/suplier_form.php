
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Suplier <?php echo form_error('suplier') ?></label>
            <input type="text" class="form-control" name="suplier" id="suplier" placeholder="Suplier" value="<?php echo $suplier; ?>" />
        </div>
	    <input type="hidden" name="id_suplier" value="<?php echo $id_suplier; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('suplier') ?>" class="btn btn-default">Cancel</a>
	</form>
   