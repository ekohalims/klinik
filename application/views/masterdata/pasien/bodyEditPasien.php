<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-user"></i> Edit Data Pasien</h3> 
        <h6> <a href="<?php echo base_url('pasien'); ?>">Pasien</a> / Edit Pasien</h6>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">No RM</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?php echo $pasien->noPasien; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">NO ID / KTP **</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="NO ID / KTP" id="noID" value="<?php echo $pasien->noID; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama Lengkap **</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Nama Lengkap" id="namaLengkap" value="<?php echo $pasien->namaLengkap; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tempat Lahir</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Tempat Lahir" id="tempatLahir" value="<?php echo $pasien->tempatLahir; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Lahir</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" id="tanggalLahir" value="<?php echo $pasien->tanggalLahir; ?>" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Jenis Kelamin **</label>
                                <div class="col-sm-9" id="jenisKelaminBorder">
                                    <input type="radio" class="jenisKelamin" name="jenisKelamin" id="jenisKelamin" value="L" <?php if($pasien->jenisKelamin=='L'){echo "checked";} ?>>Laki-laki &nbsp &nbsp<input type="radio" class="jenisKelamin" id="jenisKelamin" name="jenisKelamin" value="P" <?php if($pasien->jenisKelamin=='P'){echo "checked";} ?>/>Perempuan
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">No HP **</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="No HP" id="noHP" value="<?php echo $pasien->noHP; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Email" id="email" value="<?php echo $pasien->email; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kontak Lain Yang Dapat Dihubungi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Kontak Lain Yang Dapat Dihubungi" id="anotherPhone" value="<?php echo $pasien->kontakLain; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Pekerjaan</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="pekerjaan">
                                        <option value="">--Pilih Pekerjaan--</option>
                                        <option value="Wiraswasta" <?php if($pasien->pekerjaan=='Wiraswasta'){echo "selected";} ?>>Wiraswasta</option>
                                        <option value="Karyawan Swasta" <?php if($pasien->pekerjaan=='Karyawan Swasta'){echo "selected";} ?>>Karyawan Swasta</option>
                                        <option value="PNS" <?php if($pasien->pekerjaan=='PNS'){echo "selected";} ?>>PNS</option>
                                        <option value="Pelajar/Mahasiswa" <?php if($pasien->pekerjaan=='Pelajar/Mahasiswa'){echo "selected";} ?>>Pelajar/Mahasiswa</option>
                                        <option value="Belum/Tidak Bekerja" <?php if($pasien->pekerjaan=='Belum/Tidak Bekerja'){echo "selected";} ?>>Belum/Tidak Bekerja</option>
                                        <option value="Lainnya"> <?php if($pasien->pekerjaan=='Lainnya'){echo "selected";} ?>Lainnya</option>
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
                                    <input type="text" class="form-control" placeholder="Alamat" id="alamat" value="<?php echo $pasien->alamat; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">RT/TW</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="RT/TW" id="rt" value="<?php echo $pasien->rtrw; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Desa / Kelurahan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"  placeholder="Desa / Kelurahan" id="kelurahan" value="<?php echo $pasien->kelurahan; ?>">
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
                                        <option value="<?php echo $row->id_provinsi; ?>" <?php if($row->id_provinsi==$pasien->provinsi){echo "selected";} ?>><?php echo $row->nama_provinsi; ?></option>
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
                                        <option value="<?php echo $kb->kabupaten_id; ?>" <?php if($kb->kabupaten_id==$pasien->kabupaten) {echo "selected"; } ?>><?php echo $kb->nama_kabupaten; ?></option>
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
                                        <option value="<?php echo $kc->id_kecamatan; ?>" <?php if($kc->id_kecamatan==$pasien->kecamatan) {echo "selected"; } ?>><?php echo $kc->kecamatan; ?></option>
                                        <?php } ?>
                                    </select>

                                    <input type="hidden" id="idPasien" value="<?php echo $idPasien; ?>">
                                </div>
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
