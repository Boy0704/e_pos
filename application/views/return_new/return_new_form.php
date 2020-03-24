
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Suplier <?php echo form_error('id_suplier') ?></label>
            <!-- <input type="text" class="form-control" name="id_suplier" id="id_suplier" placeholder="Id Suplier" value="<?php echo $id_suplier; ?>" /> -->
            <select name="id_suplier" class="form-control" id="id_suplier">
                <option value="<?php echo $id_suplier ?>"><?php echo $id_suplier ?></option>
                <?php foreach ($this->db->get('suplier')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_suplier ?>"><?php echo $value->suplier ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Sales <?php echo form_error('sales') ?></label>
            <input type="text" class="form-control" name="sales" id="sales" placeholder="Sales" value="<?php echo $sales; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Total <?php echo form_error('total') ?></label>
            <input type="text" class="form-control" name="total" id="total" placeholder="Total" value="<?php echo $total; ?>" />
        </div>
	    <div class="form-group">
            <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="datetime">Date Create <?php echo form_error('date_create') ?></label>
            <input type="text" class="form-control" name="date_create" id="date_create" placeholder="Date Create" value="<?php echo get_waktu() ?>" readonly="" />
        </div>
	    <input type="hidden" name="id_return" value="<?php echo $id_return; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('return_new') ?>" class="btn btn-default">Cancel</a>
	</form>
   