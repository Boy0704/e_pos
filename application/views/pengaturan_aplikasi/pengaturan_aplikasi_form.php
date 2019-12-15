
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Toko <?php echo form_error('nama_toko') ?></label>
            <input type="text" class="form-control" name="nama_toko" id="nama_toko" placeholder="Nama Toko" value="<?php echo $nama_toko; ?>" />
        </div>
	    <div class="form-group">
            <label for="alamat">Alamat <?php echo form_error('alamat') ?></label>
            <textarea class="form-control" rows="3" name="alamat" id="alamat" placeholder="Alamat"><?php echo $alamat; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Aplikasi <?php echo form_error('nama_aplikasi') ?></label>
            <input type="text" class="form-control" name="nama_aplikasi" id="nama_aplikasi" placeholder="Nama Aplikasi" value="<?php echo $nama_aplikasi; ?>" />
        </div>
	    <input type="hidden" name="id_pengaturan" value="<?php echo $id_pengaturan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('pengaturan_aplikasi') ?>" class="btn btn-default">Cancel</a>
	</form>
   