
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Owner <?php echo form_error('owner') ?></label>
            <input type="text" class="form-control" name="owner" id="owner" placeholder="Owner" value="<?php echo $owner; ?>" />
        </div>
	    <input type="hidden" name="id_owner" value="<?php echo $id_owner; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('owner') ?>" class="btn btn-default">Cancel</a>
	</form>
   