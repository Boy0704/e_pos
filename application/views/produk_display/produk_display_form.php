
        <!-- <div class="form-group">
            <label>BARCODE SCANNER</label>
            <input type="text" name="barcode" class="form-control" id="barcode" autofocus="" autocomplete="off">
        </div> -->
        <form action="<?php echo $action; ?>" method="post">
        
	    <div class="form-group">
            <label for="int">Nama Produk <?php echo form_error('id_produk') ?></label>
            <input type="text" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo get_data('produk','id_produk',$id_produk,'nama_produk') ?>" readonly/>
            <input type="hidden" class="form-control" name="id_produk" id="id_produk" placeholder="Id Produk" value="<?php echo $id_produk; ?>" />
            <!-- <select name="id_produk" id="id_produk" class="form-control select2">
                <option value="<?php echo $id_produk ?>"><?php echo get_data('produk','id_produk',$id_produk,'nama_produk') ?></option>
                <?php 
                foreach ($this->db->get('produk')->result() as $rw) {
                 ?>
                <option value="<?php echo $rw->id_produk ?>"><?php echo strtoupper($rw->nama_produk) ?></option>
                <?php } ?>
            </select> -->
        </div>
        <input type="hidden" class="form-control" name="id_subkategori" id="id_subkategori" placeholder="Subkategori" value="<?php echo $id_subkategori; ?>" />
	    <!-- <div class="form-group">
            <label for="int">Subkategori <?php echo form_error('id_subkategori') ?></label>
            <input type="text" class="form-control" name="id_subkategori" id="id_subkategori" placeholder="Subkategori" value="<?php echo $id_subkategori; ?>" />
            <select name="id_subkategori" id="id_subkategori" class="form-control select2">
                <option value="<?php echo get_data('subkategori','id_subkategori',$id_subkategori,'subkategori') ?>"><?php echo get_data('subkategori','id_subkategori',$id_subkategori,'subkategori') ?></option>
                <?php 
                foreach ($this->db->get('subkategori')->result() as $rw) {
                 ?>
                <option value="<?php echo $rw->id_subkategori ?>"><?php echo strtoupper($rw->subkategori) ?></option>
                <?php } ?>
            </select>
        </div> -->
	    <div class="form-group">
            <label for="double">Stok Display <?php echo form_error('stok') ?> <span id="stok_now" class="label label-info"></span></label>
            <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok" value="<?php echo stok_display($id_subkategori); ?>" />
        </div>
	    <div class="form-group">
            <label for="int">In Unit <?php echo form_error('in_unit') ?></label>
            <input type="text" class="form-control" name="in_unit" id="in_unit" placeholder="In Unit" value="<?php echo $in_unit; ?>" />
        </div>

        <div class="form-group">
            <label for="int">Display Min </label>
            <input type="text" class="form-control" name="display_min" id="display_min" placeholder="Display Min" value="<?php echo $display_min; ?>" />
        </div>

        <div class="form-group">
            <label for="int">Display Max </label>
            <input type="text" class="form-control" name="display_max" id="display_max" placeholder="Display Max" value="<?php echo $display_max; ?>" />
        </div>

        <div class="form-group">
            <label for="int">Stok Gudang </label>
            <input type="text" class="form-control" name="stok_gudang" id="stok_gudang" placeholder="Stok Gudang" value="<?php echo stok_gudang($id_subkategori) ?>" />
        </div>
        

         <div class="form-group">
            <label for="int">Orderan </label>
            <input type="text" class="form-control" name="orderan" id="orderan" placeholder="Orderan" value="<?php echo $orderan; ?>" />
        </div>

         <div class="form-group">
            <label for="int">Selisih Gudang </label>
            <input type="text" class="form-control" name="selisih_gudang" id="selisih_gudang" placeholder="Selisih Gudang" value="0" />
        </div>

        <div class="form-group">
            <label for="int">Selisih Display </label>
            <input type="text" class="form-control" name="selisih_display" id="selisih_display" placeholder="Selisih Display" value="0" />
        </div>

<!-- 	    <div class="form-group">
            <label for="datetime">Date Create <?php echo form_error('date_create') ?></label>
            <input type="text" class="form-control" name="date_create" id="date_create" placeholder="Date Create" value="<?php echo $date_create; ?>" />
        </div>
	    <div class="form-group">
            <label for="varbinary">User By <?php echo form_error('user_by') ?></label>
            <input type="text" class="form-control" name="user_by" id="user_by" placeholder="User By" value="<?php echo $user_by; ?>" />
        </div> -->
	    <input type="hidden" name="id_display" value="<?php echo $id_display; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('produk_display') ?>" class="btn btn-default">Cancel</a>
	</form>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#id_produk').change(function(event) {
            var id_produk=$(this).val();
              $.ajax({
                url: 'app/get_produk/'+id_produk,
                type: 'GET',
                dataType: 'JSON',
              })
              .done(function(param) {
                console.log(param.id_subkategori);
                $('#in_unit').val(param.in_unit);
                $('#id_subkategori').val(param.id_subkategori);
                // $('#id_subkategori option[value='+param.id_subkategori+']').attr('selected','selected');
                $('#stok_now').html("STOK NOW : "+param.stok);
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
              
           });


        $('#barcode').keypress(function(e) {
            if(e.which == 13) {
                var barcode = $(this).val();
                $("#barcode").val('');
                $.ajax({
                    url: 'app/cek_produk_for_display',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {barcode: barcode},
                })
                .done(function(a) {
                    console.log("success");
                    if (a.total_row == 0) {
                        // console.log('a');
                        swal("Barcode Tidak di temukan di produk_list", "You clicked the button!", "info");
                    } else {

                        // console.log('b');
                        $('#id_produk').select2("val",a.id_produk);
                        $('#stok_gudang').val(a.stok_gudang);

                    }
                    
                })
                .fail(function() {
                    console.log("error");
                })
                .always(function() {
                    console.log("complete");
                });
                
                // $('tbody').append();
            }
        });


        });
    </script>
   