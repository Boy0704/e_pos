<div style="margin-left: 10px;">
	<div class="row">
		<div class="col-md-3">
			<label>BARCODE SCANNER</label>
			<input type="text" name="barcode" class="form-control" id="barcode" autofocus="">
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
        		<th>Satuan</th>
        		<th>Jumlah</th>
        		<th>Harga</th>
        		<th>Subtotal</th>
        	</tr>
        	<tr>
        	<?php $i=1; $no=1; $total_disc=0;?>
            <?php foreach($this->cart->contents() as $items): ?>
        		<td><?php echo $no; ?></td>
                <td><img src="image/produk/<?php echo get_produk($items['id'],'foto') ?>" style="width: 100px;"></td>
                <td><?php echo $items['id']; ?></td>
                <td><?php echo strtoupper($items['name']); ?></td>
                <td><?php echo $items['qty']*floatval(get_produk($items['id'],'diskon')); $total_disc = $total_disc+($items['qty']*floatval(get_produk($items['id'],'diskon'))); ?></td>
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
                <td>Rp. <?php echo $this->cart->format_number($items['subtotal']-floatval(get_produk($items['id'],'diskon'))); ?></td>
                <td>
                    <a href="app/hapus_cart/<?php echo $items['rowid'] ?>" class="btn btn-warning btn-sm">X</a>
                </td>
        	</tr>
        	<?php $i++; $no++; ?>
            <?php endforeach; ?>
            <tr>
        		<th colspan="8" style="text-align: right;">Total Disc</th>
        		<th colspan="2">Rp. <?php echo $this->cart->format_number($total_disc); ?></th>
        	</tr>
            <tr>
        		<th colspan="8" style="text-align: right;">Total Harga</th>
        		<th colspan="2">Rp. <?php echo $this->cart->format_number($this->cart->total()-$total_disc); ?></th>
        	</tr>
        </table>


        <a target="_blank" href="app/simpan_penjualan/<?php echo $this->cart->total()-$total_disc ?>/<?php echo $total_disc ?>" class="btn btn-primary" style="text-align: right;">SIMPAN & CETAK</a>
    	</div>



	</div>



</div>

<script type="text/javascript">
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