
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Username <?php echo form_error('username') ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Password <?php echo form_error('password') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Email <?php echo form_error('email') ?></label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
        </div>
	    <div class="form-group">
            <label for="tinyint">Status <?php echo form_error('status') ?></label>
            <!-- <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" /> -->
            <select name="status" class="form-control">
                <option value="<?php echo $status ?>"><?php echo $status ?></option>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Akses <?php echo form_error('akses') ?></label>
            <!-- <input type="text" class="form-control" name="akses" id="akses" placeholder="Akses" value="<?php echo $akses; ?>" /> -->
            <select name="akses" class="form-control">
                <option value="<?php echo $akses ?>"><?php echo $akses ?></option>
                <option value="admin">Admin</option>
                <option value="panitia">Panitia</option>
            </select>
        </div>
	    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('admin') ?>" class="btn btn-default">Cancel</a>
	</form>
   