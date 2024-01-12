<div class="form-group">
	<textarea name='editor1' class="ckeditor" id='editor1'><?php echo $hasil; ?></textarea>
	<input type="hidden" id="id" value="<?php echo $id; ?>">
</div>

<script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
</script>