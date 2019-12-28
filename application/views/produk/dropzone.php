
<link href="<?php echo base_url(); ?>assets/dropzone/dist/dropzone.css" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/dropzone/dist/min/dropzone.min.js"></script>

<?php 
$id = $this->uri->segment(3);
 ?>
<h1>Upload Produk Mobile</h1>
<form action="<?php echo site_url('app/dropzone/'.$id); ?>" class="dropzone" >
</form>

<br><br>

<div id="img_mobile">
	
</div>

<script type="text/javascript">
	$(document).ready(function() {
		setInterval(function() {
			cek_data();
			console.log('berhasil');
		}, 1000);

		function cek_data()
		{
			$.ajax({
				url: 'app/image_m/<?php echo $id ?>',
				type: 'GET',
				dataType: 'html',
			})
			.done(function(a) {
				console.log("success");
				$('#img_mobile').html(a);
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}


	});
	

</script>