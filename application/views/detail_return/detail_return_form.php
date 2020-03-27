
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Produk <?php echo form_error('id_produk') ?></label>
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
            <label for="int">Qty <?php echo form_error('qty') ?></label>
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
            <!-- <h4 id="s_ppn">Setelah PPN : <span id="h_ppn"></span></h4> -->
        </div>
	    
	    <div class="form-group" style="display: none;">
            <label for="varchar" id="show_diskon_hb">Value Diskon HB </label>
            <input type="text" class="form-control" name="value_diskon_hb" id="value_diskon_hb" placeholder="value_diskon_hb" value="<?php echo $value_diskon_hb; ?>" />
        </div>
       <div><a id="cek" class="btn btn-primary">CEK VALUE</a></div>
        <div class="form-group">
            <label for="varchar">Total <?php echo form_error('total') ?></label>
            <input type="text" class="form-control" name="total" id="total" placeholder="Total" value="<?php echo $total; ?>" readonly/>
        </div>
	    <input type="hidden" class="form-control" name="id_return" value="<?php echo $retVal = ($id_return=='') ? $this->uri->segment(3) : $id_return ; ?>" />
	    <input type="hidden" name="id_detail_return" value="<?php echo $id_detail_return; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('app/isi_return/'.$retVal = ($id_return=='') ? $this->uri->segment(3) : $id_return) ?>" class="btn btn-default">Cancel</a>
	</form>
   
    <script type="text/javascript">
      

      

       $(document).ready(function() {

          //scan barcode
          // $("#id_produk option[value=20 ]").attr('selected', 'selected');

         
          
          

          $('#s_ppn').hide();
          var cek_ppn = '0';
          

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
                $('#diskon_jual').val(param.diskon_jual);
                $('#diskon').val(param.diskon_hb);
                $('#qty').val('');
                $('#stok_now').html("STOK NOW : "+param.stok);
                $('#stok_min').html("STOK MIN : "+param.stok_min);
                $('#note_po').html("NOTE PO : "+param.qty_po);

                  

              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });              
           });


            $("#cek").click(function(event) {
              var xid_produk = $('#id_produk').val();
              var diskon = $('#diskon').val();
              
              console.log(diskon);
              var harga = 0;
              if (cek_ppn == '1') {
                var harga = parseInt($('#harga_beli').val()) + (parseInt($('#harga_beli').val()) * 0.1 );
              } else {
                var harga = parseInt($('#harga_beli').val());
              }
              console.log(harga);
              
              $.ajax({
                url: 'app/cek_diskon_beli_return/'+xid_produk,
                type: 'POST',
                dataType: 'JSON',
                data: {diskon: diskon,harga : harga},
              })
              .done(function(a) {
                console.log("success");
                
                var ppn = parseInt(harga); 
                $('#h_ppn').html(ppn);
                // cek apakah ppn atau tidak
                if (cek_ppn == '1') {
                  var value_diskon_hb = parseInt(harga);
                  var total = parseInt($('#qty').val()) *  parseInt(a.harga_diskon) ;
                  $('#s_ppn').show();
                  $('#h_diskon').html(parseInt(a.harga_diskon));
                  console.log('JIKA ADA PPN');
                  console.log(a.harga_diskon);
                } else {
                  var value_diskon_hb = parseInt(harga); 
                  $('#s_ppn').html('DPP : <span id="h_ppn"></span>');
                  var dpp = parseInt(harga) / 1.1;
                  var total = (parseInt($('#qty').val()) *  parseInt(a.harga_diskon));
                  console.log(a.harga_diskon);
                  $('#h_diskon').html(parseInt(a.harga_diskon));
                  $('#h_ppn').html(Math.floor(dpp));
                  $('#s_ppn').hide();
                  console.log('JIKA TIDAK ADA PPN');
                }
                
                $("#value_diskon_hb").val(value_diskon_hb);

                //load harga_jual_temp
                
                
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