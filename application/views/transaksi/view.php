<div style="margin-left: 10px;">
	<div class="row">
		<div class="col-md-3">
			<label>BARCODE SCANNER</label>
			<input type="text" name="barcode" class="form-control" id="barcode" autofocus="">
			
		</div>
		<div class="col-md-6">
			<label>SEARCH PRODUK</label>
			<select name="produk_search" id="produk_search" class="form-control select2" >
               <option value="">--CARI PRODUK--</option>
               <?php 
               foreach ($this->db->get('produk')->result() as $rw) {
                ?>
                <option value="<?php echo $rw->barcode1 ?>"><?php echo strtoupper($rw->nama_produk) ?></option>
              <?php } ?>
             </select>
		</div>

	</div><br>
	<div class="row">
		<!-- <table class="table table-bordered">
			<thead>
				<tr>
					<th>Barcode</th>
					<th>Nama Produk</th>
					<th>Harga</th>
					<th>QTY</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table> -->
		<div class="col-md-12 table-responsive">
		<table class="table table-bordered">
        	<tr>
        		<th>No.</th>
        		<th>Img</th>
        		<th>Barcode</th>
        		<th>Nama Barang</th>
        		<th>Diskon</th>
        		<th>Nilai Diskon</th>
        		<th>Satuan</th>
        		<th>Jumlah</th>
        		<th>Harga</th>
        		<th>Subtotal</th>
        	</tr>
        	<tr>
        	<?php $i=1; $no=1; $total_disc=0;?>
            <?php foreach($this->cart->contents() as $items):
            	$subtotal_diskon = 0;
            	$diskon = get_produk($items['id'],'diskon');
          //   	$a = get_produk($items['id'],'diskon');
        		// $b = explode("%", $a);
        		// $diskon = $b[0];
        		// if (isset($b[1])) {
        		// 	$n_diskon = $items['price'] * ($diskon/100);
        		// } else {
        		// 	$n_diskon = $diskon;
        		// }
        		

             ?>
        		<td><?php echo $no; ?></td>
                <td><img src="image/produk/<?php echo get_produk($items['id'],'foto') ?>" style="width: 100px;"></td>
                <td><?php echo $items['id']; ?></td>
                <td><?php echo strtoupper($items['name']); ?></td>
                <td><?php echo get_produk($items['id'],'diskon'); ?></td>
                <td><?php echo number_format(get_diskon_beli($diskon,$items['price'])); $total_disc = $total_disc+($items['qty']*get_diskon_beli($diskon,$items['price'])); ?></td>
                <td>
                	<select name="satuan" id="satuan" row-id="<?php echo $items['rowid'] ?>" qty="<?php echo $items['qty'] ?>">
                		<option value="<?php echo strtoupper(get_produk($items['id'],'satuan')) ?>"><?php echo strtoupper(get_produk($items['id'],'satuan')) ?></option>
                		<?php 
                		foreach ($this->db->get_where('produk', array('id_subkategori'=>get_produk($items['id'],'id_subkategori')))->result() as $rw) {
                		 ?>
                		 <option value="<?php echo $rw->id_produk ?>"><?php echo strtoupper($rw->satuan) ?></option>
                		<?php } ?>
                	</select>
                </td>
                <!-- <td><input type="text" name="qty" class="form-control" style="width: 70px;" value="<?php echo $items['qty']; ?>" id="qty<?php echo get_produk($items['id'],'id_produk') ?>"></td> -->
                <td><?php echo $items['qty']; ?></td>
                <td>Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
                <td>Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
                <td>
                    <a href="app/hapus_cart/<?php echo $items['rowid'] ?>" class="btn btn-warning btn-sm">X</a>
                </td>
        	</tr>
        	<?php $i++; $no++; ?>
            <?php endforeach; ?>
            <tr>
        		<th colspan="8" style="text-align: right;">Total Harga Sebelum Disc</th>
        		<th colspan="2">Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></th>
        	</tr>
        	<tr>
        		<th colspan="8" style="text-align: right;">Total Setelah Disc</th>
        		<th colspan="2">Rp. <?php echo $this->cart->format_number($total_disc); ?></th>
        	</tr>
        </table>


        <a href="#" id="bayar" data-toggle="modal" data-target="#myModal" class="btn btn-primary" style="text-align: right;">SIMPAN & CETAK</a>
    	</div>


    	<!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
		    <div class="modal-dialog modal-sm">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Modal Header</h4>
		        </div>
		        <div class="modal-body">
		          <form>
		          	<div class="form-group">
		          		<label>Jenis Pembayaran</label>
		          		<select name="jenis_pembayaran"id="jenis_pembayaran" class="form-control">
		          			<option value="CASH">CASH</option>
		          			<!-- <option value="DOKU">DOKU</option>
		          			<option value="GOPAY">GOPAY</option> -->
		          		</select>
		          	</div>
		          	<div class="form-group">
		          		<label>Total Bayar</label>
		          		<input type="text" name="total_bayar" class="form-control" id="total_bayar" value="<?php echo $total_disc ?>" readonly>
		          	</div>
		          	<div class="form-group">
		          		<label>Dibayar</label>
		          		<input type="text" name="dibayar" v-model='dibayar' class="form-control" id="dibayar" value="" accesskey="b">
		          	</div>
		          	<div class="form-group">
		          		<label>Kembalian</label>
		          		<input type="text" name="kembalian" v-model='kembalian' class="form-control" id="kembalian" value="" readonly="">
		          	</div>
		          </form>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		          <!-- <a target="_blank" :href="link" class="btn btn-primary" accesskey="s">Simpan</a> -->
		          <a class="btn btn-primary" id="simpan_penjualan" accesskey="s">Simpan</a>
		        </div>
		      </div>
		    </div>
		  </div>


	</div>



</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<script type="text/javascript">

	var vm = new Vue({
	  el: '#myModal',
	  data: {
	    dibayar: 0,
	    kembalian: 0,
	    jenis_pembayaran: 0
	  },
	  computed: {
                link: function() {
                    return 'app/simpan_penjualan/<?php echo $this->cart->total()?>/<?php echo $this->cart->total()-$total_disc ?>/'+this.dibayar+'/'+this.kembalian;
                }
            }

	})

	$(document).ready(function() {

		$('#barcode').keypress(function(e) {
			if(e.which == 13) {
				var barcode = $(this).val();
				$.ajax({
					url: 'app/simpan_cart',
					type: 'POST',
					dataType: 'html',
					data: {barcode: barcode},
				})
				.done(function() {
					console.log("success");
					window.location="<?php echo base_url() ?>app/transaksi";
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

		$("#simpan_penjualan").click(function(event) {
			$(this).attr('disabled', 'disabled');
			var jb = $('#jenis_pembayaran').val();
			var total = $('#total_bayar').val();
			var dibayar = $('#dibayar').val();
			var kembalian = $('#kembalian').val();
			$.ajax({
				url: 'app/simpan_penjualan/<?php echo $this->cart->total() ?>/<?php echo $this->cart->total()-$total_disc ?>/'+dibayar+'/'+kembalian+'/'+jb,
				type: 'GET',
				dataType: 'JSON',
			})
			.done(function(a) {
				console.log("success");
				window.open('app/cetak_belanja/'+a.no_penjualan, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
				window.location="<?php echo base_url() ?>app/transaksi";
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});

		$('#produk_search').change(function(e) {
			
				var barcode = $(this).val();
				$.ajax({
					url: 'app/simpan_cart',
					type: 'POST',
					dataType: 'html',
					data: {barcode: barcode},
				})
				.done(function() {
					console.log("success");
					window.location="<?php echo base_url() ?>app/transaksi";
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
				
		        // $('tbody').append();
		    
		});

		$('#satuan').change(function(event) {
            var id_produk=$(this).val();
            var row_id=$(this).attr('row-id');
            var qty=$(this).attr('qty');
              $.ajax({
                url: 'app/ubah_cart_satuan/'+id_produk+'/'+row_id+'/'+qty,
                type: 'GET',
                dataType: 'html',
              })
              .done(function() {
                console.log('berhasil ubah satuan');
                window.location="<?php echo base_url() ?>app/transaksi";
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
              
           });

		$('#bayar').click(function() {
			$('#dibayar').focus();
		});

		$('#dibayar').keyup(function(event) {
			var kembali = parseInt($(this).val()) - parseInt($('#total_bayar').val());
			$('#kembalian').val(kembali); 
			// set nilai dari vue js
			vm.kembalian = kembali;
		});

		

		<?php foreach($this->cart->contents() as $items): ?>
		$('#qty<?php echo get_produk($items['id'],'id_produk') ?>').keypress(function(e) {
			if(e.which == 13) {
				var qty = $(this).val();
				$.ajax({
					url: 'app/update_cart/<?php echo $items['rowid'] ?>',
					type: 'POST',
					dataType: 'html',
					data: {qty: qty},
				})
				.done(function() {
					console.log("success");
					window.location="<?php echo base_url() ?>app/transaksi";
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}
		});
		<?php endforeach; ?>


	});
</script>