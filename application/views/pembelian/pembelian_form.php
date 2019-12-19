
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">No Po <?php echo form_error('no_po') ?></label>
            <input type="text" class="form-control" name="no_po" id="no_po" placeholder="No Po" value="<?php echo $no_po; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Produk <?php echo form_error('id_produk') ?></label>
            <!-- <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" /> -->
            <?php
             //echo select_option('id_produk','produk','nama_produk','id_produk',null,'select2','id="id_produk"','<option value="'.$id_produk.'">'.get_data('produk','id_produk',$id_produk,'nama_produk').'</option>'); ?>

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
            <label for="int">Qty <?php echo form_error('qty') ?></label>
            <span id="stok_now" class="label label-info"><?php echo get_data('produk','id_produk',$id_produk,'stok') ?></span>
            <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Satuan <?php echo form_error('satuan') ?></label>
            <input type="text" class="form-control" name="satuan" id="satuan" placeholder="Satuan" value="<?php echo $satuan; ?>"  />
        </div>
        <div class="form-group">
            <label for="varchar">In Unit</label>
            <input type="text" class="form-control" name="in_unit" id="in_unit" placeholder="Nilai Satuan terkecil" value="<?php echo $in_unit; ?>" />
        </div>

      <div class="form-group">
            <label for="varchar">Diskon</label>
            <input type="text" class="form-control" name="diskon" id="diskon" placeholder="Diskon Harga Beli" value="<?php echo $diskon; ?>" autocomplete="off" required/>
        </div>
	    <div class="form-group">
            <label for="varchar">Harga Beli <?php echo form_error('harga_beli') ?></label>
            <input type="text" class="form-control" name="harga_beli" id="harga_beli" placeholder="Harga Beli" value="<?php echo $harga_beli; ?>" />
            <br>
            <h4>Setelah Diskon : <span id="h_diskon"></span></h4>
            <h4>Setelah PPN : <span id="h_ppn"></span></h4>
        </div>
        <div class="form-group">
            <label for="varchar">Harga Jual </label>
            <input type="text" class="form-control" name="harga_jual" id="harga_jual" placeholder="Harga Jual" value="<?php echo $harga_jual; ?>" />
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

           $('#id_produk').change(function(event) {
            var id_produk=$(this).val();
              $.ajax({
                url: 'app/get_in_unit/'+id_produk,
                type: 'GET',
                dataType: 'JSON',
              })
              .done(function(param) {
                $('#in_unit').val(param.in_unit);
                $('#satuan').val(param.satuan);
                $('#harga_beli').val(param.harga_beli);
                $('#harga_jual').val(param.harga_jual);
                $('#stok_now').html("STOK NOW : "+param.stok);
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });              
           });


            $("#diskon").keyup(function(event) {
              var diskon = $(this).val();
              console.log(diskon);
              var harga = $('#harga_beli').val();
              $.ajax({
                url: 'app/cek_diskon_beli',
                type: 'POST',
                dataType: 'JSON',
                data: {diskon: diskon,harga : harga},
              })
              .done(function(a) {
                console.log("success");
                $('#h_diskon').html(a.harga_diskon);
                var ppn = parseInt(harga)+(parseInt(harga) * 0.1); 
                $('#h_ppn').html(ppn);
                var total = parseInt($('#qty').val()) *  parseInt(a.harga_diskon);
               $('#total').val(total);
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
              
            });

       });
   </script>