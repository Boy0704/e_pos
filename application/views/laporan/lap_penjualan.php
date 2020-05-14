<div class="panel panel-info">
  <div class="panel-heading">LAPORAN PENJUALAN | STRUK</div>
  <div class="panel-body">
  	<form action="laporan/proses_penjualan_struk" method="POST" target="_blank">
  		<div class="form-group">
  			<label>From</label>
  			<input type="date" name="tgl1" class="form-control">
  		</div>
  		<div class="form-group">
  			<label>Until</label>
  			<input type="date" name="tgl2" class="form-control">
  		</div>
  		<div class="form-group">
  			<button type="submit" class="btn btn-info"><i class="fa fa-print"> Cetak</i></button>
  		</div>
  	</form>

  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">LAPORAN PENJUALAN | ITEM</div>
  <div class="panel-body">
      <div class="form-group">
        <label>SCAN BARCODE</label>
        <input type="text" id="barcode" class="form-control" autofocus="">
      </div>
  	<form action="laporan/proses_penjualan_item" method="POST" target="_blank">
  		
  		<div class="form-group">
  			<label>Nama Produk</label>
        <input type="hidden" name="id_produk" id="id_produk">
        <input type="hidden" name="barcode" id="x_barcode">
  			<input type="text" name="nama_produk" id="nama_produk" class="form-control" readonly="">
  		</div>
  		<div class="form-group">
  			<label>From</label>
  			<input type="date" name="tgl1" class="form-control" id="tgl1" disabled="">
  		</div>
  		<div class="form-group">
  			<label>Until</label>
  			<input type="date" name="tgl2" class="form-control" id="tgl2" disabled="">
  		</div>
  		<div class="form-group">
  			<button type="submit" class="btn btn-info"><i class="fa fa-print"> Cetak</i></button>
  		</div>
  	</form>

  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">LAPORAN PENJUALAN | KASIR/CLIENT</div>
  <div class="panel-body">
  	<form action="laporan/proses_penjualan_kasir" method="POST" target="_blank">
  		<div class="form-group">
  			<label>Cari Kasir/Client</label>
  			<select name="kasir" class="form-control select2">
  				<option value="">--ALL Client--</option>
  				<?php foreach ($this->db->get_where('a_user', array('level'=>'kasir'))->result() as $rw): ?>
  					<option value="<?php echo $rw->id_user ?>"><?php echo $rw->nama_lengkap ?></option>
  				<?php endforeach ?>
  			</select>
  		</div>
  		<div class="form-group">
  			<label>From</label>
  			<input type="date" name="tgl1" class="form-control">
  		</div>
  		<div class="form-group">
  			<label>Until</label>
  			<input type="date" name="tgl2" class="form-control">
  		</div>
  		<div class="form-group">
  			<button type="submit" class="btn btn-info"><i class="fa fa-print"> Cetak</i></button>
  		</div>
  	</form>

  </div>
</div>

<div class="panel panel-info">
  <div class="panel-heading">LAPORAN PENJUALAN | PAJAK BULANAN / HARIAN</div>
  <div class="panel-body">
  	<form action="laporan/proses_penjualan_pajak" method="POST" target="_blank">
  		<div class="form-group">
  			<label>From</label>
  			<input type="date" name="tgl1" class="form-control">
  		</div>
  		<div class="form-group">
  			<label>Until</label>
  			<input type="date" name="tgl2" class="form-control">
  		</div>
  		<div class="form-group">
  			<button type="submit" class="btn btn-info"><i class="fa fa-print"> Cetak</i></button>
  		</div>
  	</form>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    
    $("#barcode").change(function(event) {
      var barcode = $(this).val();
      jQuery.ajax({
        url: 'laporan/cek_barcode',
        type: 'POST',
        dataType: 'json',
        data: {barcode: barcode},
        beforeSend: function() {
          swal({
            text: "Silahkan Tunggu!",
            icon: "info",
            button: false
          });
        },
        complete: function(xhr, textStatus) {
          console.log('selesai');
        },
        success: function(data, textStatus, xhr) {
          if (data.id_produk != null) {
            swal.close();
            $("#id_produk").val(data.id_produk);
            $("#nama_produk").val(data.nama_produk);
            $("#x_barcode").val(data.barcode);
            $("#tgl1").removeAttr('disabled');
            $("#tgl2").removeAttr('disabled');
          } else {
            swal({
              text: "Produk tidak ditemukan!",
              icon: "error",
            });
            setTimeout(function(){ swal.close() }, 1000);
            $("#barcode").val('');
            $("#barcode").focus();

          }
        },
        error: function(xhr, textStatus, errorThrown) {
          console.log('error');
        }
      });
      

     
      
    });



  });
</script>