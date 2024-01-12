<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-user"></i> Pendaftaran Pasien Baru</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row" style="font-size: 13px;">
                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="20%" style="font-weight: bold;">No Pasien</td>
                                <td width="1%">:</td>
                                <td><?php echo $pasien->noPasien; ?></td>
                            </tr>

                            <tr>
                                <td width="20%" style="font-weight: bold;">No ID</td>
                                <td width="1%">:</td>
                                <td><?php echo $pasien->noID; ?></td>
                            </tr>

                            <tr>
                                <td width="20%" style="font-weight: bold;">Nama</td>
                                <td width="1%">:</td>
                                <td><?php echo $pasien->namaLengkap; ?></td>
                            </tr>

                            <tr>
                                <td width="20%" style="font-weight: bold;">Tanggal Lahir</td>
                                <td width="1%">:</td>
                                <td><?php echo $pasien->tempatLahir.",".date_format(date_create($pasien->tanggalLahir),'d M Y'); ?></td>
                            </tr>

                            <tr>
                                <td width="20%" style="font-weight: bold;">Sex / Umur</td>
                                <td width="1%">:</td>
                                <td><?php echo $pasien->jenisKelamin; ?> / <?php echo $umur; ?> Thn</td>
                            </tr>

                            <tr>
                                <td width="20%" style="font-weight: bold;">Alamat</td>
                                <td width="1%">:</td>
                                <td><?php echo $pasien->alamat; ?></td>
                            </tr>  
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="20%" style="font-weight: bold;">Poliklinik</td>
                                <td width="1%">:</td>
                                <td>
                                    <select class="select2" id="poliklinik">
                                        <option value="">--Pilih Poliklinik--</option>

                                        <?php
                                            foreach($poliklinik as $plk){
                                        ?>
                                        <option value="<?php echo $plk->id_poliklinik; ?>"><?php echo $plk->poliklinik; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr> 

                            <tr style="height: 50px;">
                                <td width="20%" style="font-weight: bold;">Dokter</td>
                                <td width="1%">:</td>
                                <td>
                                    <select class="select2" id="dokter">
                                        <option value="">--Pilih Dokter--</option>
                                    </select>

                                    <input type="hidden" id="idPasien" value="<?php echo $this->input->get("idPasien"); ?>">
                                </td>
                            </tr>

                            <tr style="height: 20px;">
                                <td width="20%" style="font-weight: bold;">Jenis Layanan</td>
                                <td width="1%">:</td>
                                <td>
                                    <?php
                                        foreach($layanan as $dt){
                                    ?>
                                    <input type="radio" name="layanan" id="layanan" value="<?php echo $dt->id_layanan; ?>"> <?php echo $dt->layanan; ?>
                                    <?php } ?>
                                </td>
                            </tr>                           
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;" id="kartuOrButton">
                    
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
