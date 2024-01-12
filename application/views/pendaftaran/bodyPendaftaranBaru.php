<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-user"></i> Pendaftaran Pasien Baru</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NO ID / KTP **</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="NO ID / KTP" id="noID">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap **</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Nama Lengkap" id="namaLengkap">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tempat Lahir</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Tempat Lahir" id="tempatLahir">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Lahir</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" placeholder="" data-mask="99/99/9999" id="tanggalLahir"/>
                                    <span class="help-inline">dd/mm/yyyy</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis Kelamin **</label>
                                <div class="col-sm-9" id="jenisKelaminBorder">
                                    <input type="radio" class="jenisKelamin" name="jenisKelamin" id="jenisKelamin" value="L">Laki-laki &nbsp &nbsp<input type="radio" class="jenisKelamin" id="jenisKelamin" name="jenisKelamin" value="P" />Perempuan
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">No HP **</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="No HP" id="noHP">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Email" id="email">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kontak Lain Yang Dapat Dihubungi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Kontak Lain Yang Dapat Dihubungi" id="anotherPhone">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Pekerjaan</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="pekerjaan">
                                        <option value="">--Pilih Pekerjaan--</option>
                                        <option value="Wiraswasta">Wiraswasta</option>
                                        <option value="Karyawan Swasta">Karyawan Swasta</option>
                                        <option value="PNS">PNS</option>
                                        <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                        <option value="Belum/Tidak Bekerja">Belum/Tidak Bekerja</option>
                                        <option value="Lainnya">Lainnya</option>
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
                                    <input type="text" class="form-control" placeholder="Alamat" id="alamat">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">RT/TW</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="RT/TW" id="rt">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Desa / Kelurahan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Desa / Kelurahan" id="kelurahan">
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
                                        <option value="<?php echo $row->id_provinsi; ?>"><?php echo $row->nama_provinsi; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kabupaten</label>
                                <div class="col-sm-9">
                                    <select class="select2" id="list-kabupaten">
                                        <option value="">--Pilih Kabupaten--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kecamatan</label>
                                <div class="col-sm-9">
                                    <select class="select2" id="list-kecamatan">
                                        <option value="">--Pilih Kecamatan--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Poliklinik**</label>
                                <div class="col-sm-9" id="poliklinikLabel">
                                    <select class="select2" id="poliklinik">
                                        <option value="">--Pilih Poliklinik--</option>

                                        <?php
                                            foreach($poliklinik as $plk){
                                        ?>
                                        <option value="<?php echo $plk->id_poliklinik; ?>"><?php echo $plk->poliklinik; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Dokter**</label>
                                <div class="col-sm-9" id="dokterLabel">
                                    <select class="select2" id="dokter">
                                        <option value="">--Pilih Dokter--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Penanggung**</label>
                                <div class="col-sm-9" id="layananLabel">
                                    <?php
                                        foreach($layanan as $dt){
                                    ?>
                                    <input type="radio" name="layanan" class="layanan" id="layanan" value="<?php echo $dt->id_layanan; ?>"> <?php echo $dt->layanan; ?>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="form-group" id="tanggunganAsuransi">
                                <input type="hidden" id="asuransi" value=""/>
                            </div>

                            <div class="form-group" id="noKartuForm">
                                <input type="hidden" id="noKartu" value=""/>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <button class="btn btn-primary" id="simpanPasien"><i class="fa fa-save"></i> Simpan</button> 
                    </div> 
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
