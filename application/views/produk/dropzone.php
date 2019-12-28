
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
	setTimeout(function() {
		cek_data()
	},5000);

	$.ajax({
		url: 'app/image_m/',
		type: 'default GET (Other values: POST)',
		dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		data: {param1: 'value1'},
	})
	.done(function() {
		console.log("success");
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	

</script>