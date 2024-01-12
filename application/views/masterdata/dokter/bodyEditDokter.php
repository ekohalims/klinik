<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-user-md"></i> Edit Dokter</h3> 
        <h6> <a href="<?php echo base_url('dokter'); ?>">Dokter</a> / Edit Dokter</h6>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap **</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  placeholder="Nama Lengkap" id="namaLengkap" value="<?php echo $dokter->nama; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Jenis Kelamin **</label>
                                        <div class="col-sm-9" id="jenisKelaminBorder">
                                            <input type="radio" class="jenisKelamin" name="jenisKelamin" id="jenisKelamin" value="L" <?php if($dokter->jenisKelamin=='L') {echo "checked";} ?>>Laki-laki &nbsp &nbsp<input type="radio" class="jenisKelamin" id="jenisKelamin" name="jenisKelamin" value="P" <?php if($dokter->jenisKelamin=='P') {echo "checked";} ?>/>Perempuan
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">No HP **</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  placeholder="No HP" id="noHP" value="<?php echo $dokter->noHP; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">No Izin Praktek</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  placeholder="No Izin Praktek" id="noIzinPraktek" value="<?php echo $dokter->noIzinPraktek; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Poliklinik **</label>
                                        <div class="col-sm-9" id="poliklinikLabel">
                                            <select class="select2" id="poliklinik">
                                                <option value="">--Pilih Poliklinik--</option>
                                                <?php
                                                    foreach($poli as $pl){
                                                ?>
                                                <option value="<?php echo $pl->id_poliklinik; ?>" <?php if($dokter->idPoliklinik==$pl->id_poliklinik){echo "selected";} ?>><?php echo $pl->poliklinik; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Alamat</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" placeholder="Alamat" id="alamat" value="<?php echo $dokter->alamat; ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Provinsi</label>
                                        <div class="col-sm-9">
                                            <select class="select2" id="provinsi">
                                                <option value="">--Pilih Provinsi--</option>
                                                <?php
                                                    foreach($provinsi as $row){
                                                ?>
                                                <option value="<?php echo $row->id_provinsi; ?>" <?php if($row->id_provinsi==$dokter->provinsi) {echo "selected";} ?>><?php echo $row->nama_provinsi; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Kabupaten</label>
                                        <div class="col-sm-9">
                                            <select class="select2" id="list-kabupaten">
                                                <option value="">--Pilih Kabupaten--</option>
                                                <?php
                                                    foreach($kabupaten as $kb){
                                                ?>
                                                <option value="<?php echo $kb->kabupaten_id; ?>" <?php if($kb->kabupaten_id==$dokter->kabupaten) {echo "selected";} ?>><?php echo $kb->nama_kabupaten; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Kecamatan</label>
                                        <div class="col-sm-9">
                                            <select class="select2" id="list-kecamatan">
                                                <option value="">--Pilih Kecamatan--</option>
                                                <?php 
                                                    foreach($kecamatan as $kc){
                                                ?>
                                                <option value="<?php echo $kc->id_kecamatan; ?>" <?php if($kc->id_kecamatan==$dokter->kecamatan) {echo "selected";} ?>><?php echo $kc->kecamatan; ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" id="idDokter" value="<?php echo $this->input->get("idDokter"); ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-9" id="jenisKelaminBorder">
                                            <input type="radio" name="status" id="status" value="1" <?php if($dokter->status=='1') {echo "checked";} ?>>Aktif &nbsp &nbsp
                                            <input type="radio" id="status" name="status" value="0" <?php if($dokter->status=='0') {echo "checked";} ?>/>Non-Aktif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="text-align: right;">
                                <button class="btn btn-primary" id="simpanDokter"><i class="fa fa-save"></i> Simpan</button> 
                            </div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
