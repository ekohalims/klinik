	<div class="row">
		<div class="col-md-12">
			<table width="100%">
				<tr>
					<td width="10%" style="font-weight: bold;">Riwayat Alergi</td>
					<td>
						<input type="text" class="form-control" id="riwayatAlergi" value="<?php echo $riwayatAlergi; ?>">
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="row" style="margin-top:20px;">
		<div class="col-md-2">
			<label>Tinggi Badan (Cm)</label>
			<input type="text" class="form-control" id="tinggiBadan" value="<?php echo $tinggiBadan; ?>"/>
		</div>

		<div class="col-md-2">
			<label>Berat Badan (Kg)</label>
			<input type="text" class="form-control" id="beratBadan" value="<?php echo $beratBadan; ?>"/>
		</div>

		<div class="col-md-2">
			<label>Tekanan Darah (MmHG)</label>
			<input type="text" class="form-control" id="tekananDarah"  value="<?php echo $tekananDarah; ?>"/>
		</div>

		<div class="col-md-2">
			<label>Buta Warna</label>
			<select class="form-control" id="butaWarna">
				<option value="">--Buta Warna--</option>
				<option value="Ya" <?php if($butaWarna=='Ya'){echo "selected";}?>>Ya</option>
				<option value="Tidak" <?php if($butaWarna=='Tidak'){echo "selected";}?>>Tidak</option>
			</select>
		</div>

		<div class="col-md-2">
			<label>Cacat Badan</label>
			<select class="form-control" id="cacatBadan">
				<option value="">--Cacat Badan--</option>
				<option value="Ya" <?php if($cacatBadan=='Ya'){echo "selected";}?>>Ya</option>
				<option value="Tidak" <?php if($cacatBadan=='Tidak'){echo "selected";}?>>Tidak</option>
			</select>
		</div>

		<div class="col-md-2">
			<label>Golongan Darah</label> <br>

			<?php
				if(empty($golonganDarah)){
			?>
			<select class="form-control" id="golonganDarah">
				<option value="">--Golongan Darah--</option>
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="AB">AB</option>
				<option value="O">O</option>
			</select>
			<?php 
				} else {  
			?>

			<select class="form-control" id="golonganDarah">
				<option value="">--Golongan Darah--</option>
				<option value="A" <?php if($golonganDarah=='A') {echo "selected";} ?>>A</option>
				<option value="B" <?php if($golonganDarah=='B') {echo "selected";} ?>>B</option>
				<option value="AB" <?php if($golonganDarah=='AB') {echo "selected";} ?>>AB</option>
				<option value="O" <?php if($golonganDarah=='O') {echo "selected";} ?>>O</option>
			</select>

			<?php
				} 
			?>
		</div>
	</div>

	<div class="row" style="margin-top: 10px;">
		<div class="col-md-12">
			<label>Catatan</label>
			<textarea name='editor1' class="ckeditor" id='editor1'><?php echo $catatan; ?></textarea>
		</div>
	</div>


	<script type="text/javascript">
		CKEDITOR.replace( 'editor1' );

		$('#riwayatAlergi').on("change",function(){
			simpanCatatan();
		});

		$('#tinggiBadan').on("change",function(){
			simpanCatatan();
		});

		$('#beratBadan').on("change",function(){
			simpanCatatan();
		});

		$('#tekananDarah').on("change",function(){
			simpanCatatan();
		});

		$('#butaWarna').on("change",function(){
			simpanCatatan();
		});

		$('#golonganDarah').on("change",function(){
			var golonganDarah = $(this).val();

			var url = "<?php echo base_url('inputTindakanRanap/simpanGolonganDarah'); ?>";

			$.ajax({
				method : "POST",
				url : url,
				data : {golonganDarah : golonganDarah, noPendaftaran : noPendaftaran},
				success : function(){
					//
				}
			});
		});

		$('#cacatBadan').on("change",function(){
			simpanCatatan();
		});

		CKEDITOR.instances.editor1.on('change', function() { 
			simpanCatatan();
		});

		function simpanCatatan(){
			var keluhan = CKEDITOR.instances['editor1'].getData();
			var riwayatAlergi = $('#riwayatAlergi').val();
			var tinggiBadan = $('#tinggiBadan').val();
			var beratBadan = $('#beratBadan').val();
			var tekananDarah = $('#tekananDarah').val();
			var butaWarna = $('#butaWarna').val();
			var cacatBadan = $('#cacatBadan').val();

			var urlSimpanCatatan = "<?php echo base_url('inputTindakanRanap/simpanCatatan'); ?>";

			$.ajax({
				method : "POST",
				url : urlSimpanCatatan,
				data : {noPendaftaran : noPendaftaran, riwayatAlergi : riwayatAlergi,keluhan : keluhan,tinggiBadan : tinggiBadan, beratBadan : beratBadan, tekananDarah : tekananDarah, butaWarna : butaWarna,cacatBadan : cacatBadan},
				beforeSend : function(){
					//$('#simpanCatatan').prop('disabled',true);
				},
				success : function(){
					//$.Notification.autoHideNotify('success', 'top right', 'Berhasil!','Catatan tersimpan');
					//$('#simpanCatatan').prop('disabled',false);
				}
			});
		}
	</script>