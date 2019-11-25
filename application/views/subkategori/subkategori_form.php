
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Subkategori <?php echo form_error('subkategori') ?></label>
            <input type="text" class="form-control" name="subkategori" id="subkategori" placeholder="Subkategori" value="<?php echo $subkategori; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Kategori <?php echo form_error('id_kategori') ?></label>
            <!-- <input type="text" class="form-control" name="id_kategori" id="id_kategori" placeholder="Id Kategori" value="<?php echo $id_kategori; ?>" /> -->
            <?php echo select_option('id_kategori','kategori','kategori','id_kategori',null,null,'id=siswa','<option value="'.$id_kategori.'">'.get_data('kategori','id_kategori',$id_kategori,'kategori').'</option>'); ?>
        </div>
	    <input type="hidden" name="id_subkategori" value="<?php echo $id_subkategori; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('subkategori') ?>" class="btn btn-default">Cancel</a>
	</form>
   