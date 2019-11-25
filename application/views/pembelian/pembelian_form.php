
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">No Po <?php echo form_error('no_po') ?></label>
            <input type="text" class="form-control" name="no_po" id="no_po" placeholder="No Po" value="<?php echo $no_po; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Produk <?php echo form_error('id_produk') ?></label>
            <!-- <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" /> -->
            <?php echo select_option('id_produk','produk','nama_produk','id_produk',null,'select2','id=siswa','<option value="'.$id_produk.'">'.get_data('produk','id_produk',$id_produk,'nama_produk').'</option>'); ?>
        </div>
	    <div class="form-group">
            <label for="int">Qty <?php echo form_error('qty') ?></label>
            <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Satuan <?php echo form_error('satuan') ?></label>
            <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Harga Beli <?php echo form_error('harga_beli') ?></label>
            <input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga Beli" value="<?php echo $harga_beli; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Total <?php echo form_error('total') ?></label>
            <input type="text" class="form-control" name="total" id="total" placeholder="Total" value="<?php echo $total; ?>" readonly/>
        </div>
	    <input type="hidden" name="id_pembelian" value="<?php echo $id_pembelian; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('app/isi_po/'.$no_po) ?>" class="btn btn-default">Cancel</a>
	</form>
   
   <script type="text/javascript">
       $(document).ready(function() {
           $('#harga_beli').keyup(function() {
               var total = parseInt($('#qty').val()) *  parseInt($(this).val());
               $('#total').val(total);
           });
       });
   </script>