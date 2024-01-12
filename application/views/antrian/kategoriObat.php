<div class="row" id="tableNiceScroll" style="height: 500px;">
	<?php
		foreach($kategori as $row){
	?>
	<div class="col-md-3 col-sm-4 col-xs-4" style="height: 100px;text-align: center;">
		<a class="chooseCategory" id="<?php echo $row->id_kategori; ?>">
			<img src="<?php echo base_url('assets/medicine.png'); ?>" style="height:70px;"/> <br>
			<label><?php echo $row->kategori; ?></label>
		</a>
	</div>
	<?php } ?>
</div>

<script type="text/javascript">
	$("#tableNiceScroll").niceScroll({cursorcolor:"#ddd"});
</script>