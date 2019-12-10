
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">No Po <?php echo form_error('no_po') ?></label>
            <input type="text" class="form-control" name="no_po" id="no_po" placeholder="No Po" value="<?php echo $no_po; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Suplier <?php echo form_error('nama_suplier') ?></label>
            <!-- <input type="text" class="form-control" name="nama_suplier" id="nama_suplier" placeholder="Nama Suplier" value="<?php echo $nama_suplier; ?>" /> -->
            <select name="nama_suplier" class="form-control">
                <option value="<?php echo $nama_suplier ?>"><?php echo $nama_suplier ?></option>
                <?php foreach ($this->db->get('suplier')->result() as $key => $value): ?>
                    <option value="<?php echo $value->suplier ?>"><?php echo $value->suplier ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Sales <?php echo form_error('sales') ?></label>
            <input type="text" class="form-control" name="sales" id="sales" placeholder="Sales" value="<?php echo $sales; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Potongan Harga <?php echo form_error('potongan_harga') ?></label>
            <input type="text" class="form-control" name="potongan_harga" id="potongan_harga" placeholder="ex : 100000;10%;20%" value="<?php echo $potongan_harga; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Total Harga </label>
            <input type="text" class="form-control" name="total_harga" id="total_harga" placeholder="Total Harga PO" value="<?php echo $total_harga; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Status Pembayaran</label>
            <select name="status_pembayaran" class="form-control">
                <option value="<?php echo $status_pembayaran ?>"><?php echo $status_pembayaran ?></option>
                <option value="cash">cash</option>
                <option value="kredit">kredit</option>
            </select>
        </div>
        <div class="form-group">
            <label for="varchar">Jumlah Bayar</label>
            <input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar" placeholder="jumlah bayar" value="<?php echo $jumlah_bayar; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Sisa Bayar</label>
            <input type="text" class="form-control" name="sisa_bayar" id="sisa_bayar" placeholder="Sisa Bayar Jika Kredit" value="<?php echo $sisa_bayar; ?>" readonly/>
        </div>
        <div class="form-group">
            <label for="varchar">Dengan PPN</label>
            <select name="ppn" class="form-control">
                <option value="<?php echo $ppn ?>"><?php echo $retVal = ($ppn == 1) ? 'ya' : 'tidak' ; ?></option>
                <option value="1">ya</option>
                <option value="0">tidak</option>
            </select>
        </div>
	    
	    <input type="hidden" name="id_po" value="<?php echo $id_po; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('po_master') ?>" class="btn btn-default">Cancel</a>
	</form>
   
      <script type="text/javascript">
       $(document).ready(function() {
           $('#jumlah_bayar').keyup(function() {
               var total = parseInt($('#total_harga').val()) -  parseInt($(this).val());
               $('#sisa_bayar').val(total);
           });
       });
   </script>