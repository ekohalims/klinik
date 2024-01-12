<?php
	foreach($supplier->result() as $row){
?>
<div class="form-group">
	<input type="text" class="form-control" placeholder="Nama Supplier" id="nama_supplier_edit" value="<?php echo $row->supplier; ?>"/>
</div>

<div class="form-group">
	<input type="text" class="form-control" placeholder="Kontak" id="kontak_supplier_edit" value="<?php echo $row->kontak; ?>"/>
</div>

<div class="form-group">
	<input type="text" class="form-control" placeholder="Email" id="email_supplier_edit" value="<?php echo $row->email; ?>"/>
</div>

<div class="form-group">
	<textarea class="form-control" placeholder="Alamat" id="alamat_supplier_edit"><?php echo $row->alamat; ?></textarea>
	<input type="hidden" id="id_supplier_edit" value="<?php echo $row->id_supplier; ?>"/>
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="No Rekening" id="no_rekening" value="<?php echo $row->no_rekening; ?>"/>
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="Bank" id="bank" value="<?php echo $row->bank; ?>"/>
</div>

<div class="form-group">
    <input type="text" class="form-control" placeholder="Atas Nama" id="atas_nama" value="<?php echo $row->atas_nama; ?>"/>
</div>

<?php } ?>

<script type="text/javascript">

	$(document).on("click",".edit-supplier-sql",function(){
		nama 		= $('#nama_supplier_edit').val();
		kontak 		= $('#kontak_supplier_edit').val();
		email 		= $('#email_supplier_edit').val();
		alamat 		= $('#alamat_supplier_edit').val();
		no_rekening = $('#no_rekening').val();
		bank 		= $('#bank').val();
		atas_nama 	= $('#atas_nama').val();

		id 		= $('#id_supplier_edit').val();
		supplier    = "<?php echo base_url('supplier/data_supplier'); ?>";

		url 	= "<?php echo base_url('supplier/edit_supplier_sql'); ?>";

		$.ajax({
					method : "POST",
					url : url,
					data : {email : email, nama : nama, kontak : kontak, alamat : alamat, id : id, no_rekening : no_rekening, bank : bank, atas_nama : atas_nama},
					success : function(data){

			                $.Notification.notify('success', 'top right', 'Supplier', 'Supplier Berhasil Diedit');
			                $('#edit-supplier-modal').modal('hide');
							$('#data-supplier').load(supplier);
							$('.modal-backdrop').hide();
			            
					}
		});
	});
</script>