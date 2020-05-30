
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="datetime">Start From <?php echo form_error('tgl1') ?></label>
            <input type="text" class="form-control" name="tgl1" id="tgl1" placeholder="Start From" value="<?php echo $tgl1; ?>" />
        </div>
	    <div class="form-group">
            <label for="datetime">Until <?php echo form_error('tgl2') ?></label>
            <input type="text" class="form-control" name="tgl2" id="tgl2" placeholder="Until" value="<?php echo $tgl2; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Kasir <?php echo form_error('kasir') ?></label>
            <select name="kasir" class="form-control select2">
                <option value="<?php echo $kasir ?>"><?php echo get_data('a_user','id_user',$kasir,'nama_lengkap') ?></option>
                <?php foreach ($this->db->get_where('a_user', array('level'=>'kasir'))->result() as $rw): ?>
                    <option value="<?php echo $rw->id_user ?>"><?php echo $rw->nama_lengkap ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Kas Awal <?php echo form_error('kas_awal') ?></label>
            <input type="text" class="form-control" name="kas_awal" id="kas_awal" placeholder="Kas Awal" value="<?php echo $kas_awal; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Total Jual</label>
            <input type="text" class="form-control" name="total_jual" id="total_jual" placeholder="Total Jual" value="<?php echo $total_jual; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Selisih</label>
            <input type="text" class="form-control" name="selisih" id="selisih" placeholder="Selisih" value="<?php echo $selisih; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Setoran/Kas Akhir</label>
            <input type="text" class="form-control" name="setoran" id="setoran" placeholder="Setoran / Kas Akhir" value="<?php echo $setoran; ?>" />
        </div>

	    <div class="form-group">
            <label for="enum">Status <?php echo form_error('status') ?></label><br>
            <?php if ($status == '1'): ?>
                <input type="radio" name="status" value="0"> On Progress
                <input type="radio" name="status" value="1" checked=""> Finish
            <?php else: ?>
                <input type="radio" name="status" value="0" checked=""> On Progress
                <input type="radio" name="status" value="1"> Finish
            <?php endif ?>
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kas_awal') ?>" class="btn btn-default">Cancel</a>
	</form>

<script type="text/javascript">
    $(document).ready(function() {
        $("#tgl1").datetimepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#tgl2").datetimepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
   