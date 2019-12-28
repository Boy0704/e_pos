
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">ID Produk <?php echo form_error('id_produk') ?></label>
            <!-- <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" /> -->
            <select name="id_produk" id="id_produk" class="form-control select2" >
               <option value="<?php echo $id_produk ?>"><?php echo get_data('produk','id_produk',$id_produk,'nama_produk') ?></option>
               <?php 
               foreach ($this->db->get('produk')->result() as $rw) {
                ?>
                <option value="<?php echo $rw->id_produk ?>"><?php echo strtoupper($rw->nama_produk) ?></option>
              <?php } ?>
             </select>
        </div>
	    <div class="form-group">
            <label for="int">Jumlah <?php echo form_error('jumlah') ?></label>
            <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" />
        </div>
	    <div class="form-group">
            <label for="datetime">Date Create <?php echo form_error('date_create') ?></label>
            <input type="text" class="form-control" name="date_create" id="date_create" placeholder="Date Create" value="<?php echo get_waktu(); ?>" />
        </div>
	    <div class="form-group">
            <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
	    <input type="hidden" name="id_return" value="<?php echo $id_return; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('return_list') ?>" class="btn btn-default">Cancel</a>
	</form>
   