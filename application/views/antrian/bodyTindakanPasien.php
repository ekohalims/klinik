<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-stethoscope"></i> Catatan Tindakan Pasien</h3> 
        <h6> <a href="<?php echo base_url('antrian'); ?>">Input Tindakan</a> / Tindakan Pasien</h6>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="border-bottom: solid 1px #ccc;padding-bottom: 5px;text-align: right;">
                            <a class="btn btn-warning btn-rounded" id="tindakanSelesai"><i class="fa fa-ticket"></i> Selesai</a>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="35%" style="font-weight: bold;">No Pendaftaran</td>
                                <td width="1%">:</td>
                                <td>
                                    <?php echo $dataPasien->noPendaftaran; ?>
                                    <input type="hidden" id="noPendaftaran" value="<?php echo $this->input->get('noPendaftaran'); ?>">
                                </td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">No Pasien</td>
                                <td>:</td>
                                <td><?php echo $dataPasien->noPasien; ?></td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">Nama</td>
                                <td>:</td>
                                <td><?php echo $dataPasien->namaLengkap; ?></td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">TTL</td>
                                <td>:</td>
                                <td><?php echo $dataPasien->tempatLahir.",".date_format(date_create($dataPasien->tanggalLahir),'d F Y'); ?></td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">Sex / Umur</td>
                                <td>:</td>
                                <td><?php echo $dataPasien->jenisKelamin." / ".$umur." Thn"; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table width="100%">
                            <tr>
                                <td width="35%" style="font-weight: bold;">Tanggal</td>
                                <td width="1%">:</td>
                                <td><?php echo date_format(date_create($dataPasien->tanggalDaftar),'d F Y'); ?></td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">Jam Kunjungan</td>
                                <td>:</td>
                                <td><?php echo date_format(date_create($dataPasien->tanggalDaftar),'H:i'); ?></td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">Penanggung</td>
                                <td>:</td>
                                <td><?php echo $dataPasien->layanan." ".$dataPasien->namaAsuransi; ?></td>
                            </tr>

                            <tr>
                                <td width="35%" style="font-weight: bold;">Jenis Kunjungan</td>
                                <td>:</td>
                                <td><?php echo $jenisKunjungan; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs"> 
                            <li class="active"> 
                                <a data-toggle="tab" aria-expanded="false" class="tabsMedic" id="catatan"> 
                                    <span>Catatan</span> 
                                </a> 
                            </li> 

                            <li class=""> 
                                <a data-toggle="tab" aria-expanded="true" class="tabsMedic" id="laboratorium">  
                                    <span>Laboratorium</span> 
                                </a> 
                            </li> 

                            <li class=""> 
                                <a data-toggle="tab" aria-expanded="false" class="tabsMedic" id="radiologi"> 
                                    <span>Radiologi</span> 
                                </a> 
                            </li> 

                            <li class=""> 
                                <a data-toggle="tab" aria-expanded="false" class="tabsMedic" id="diagnosa">  
                                    <span>Diagnosa</span> 
                                </a> 
                            </li>

                            <li class=""> 
                                <a data-toggle="tab" class="tabsMedic" id="resep"> 
                                    <span>Resep</span> 
                                </a> 
                            </li>

                            <li class=""> 
                                <a data-toggle="tab" class="tabsMedic" id="tindakan"> 
                                    <span>Tindakan</span> 
                                </a> 
                            </li> 

                            <li class=""> 
                                <a data-toggle="tab" class="tabsMedic" id="tindakLanjut"> 
                                    <span>Tindak Lanjut</span> 
                                </a> 
                            </li>

                            <li class=""> 
                                <a data-toggle="tab" class="tabsMedic" id="riwayatBerobat"> 
                                    <span>Riwayat Berobat</span> 
                                </a> 
                            </li>
                        </ul> 

                        <div class="tab-content table-responsive" style="margin-top:5px;border-left: solid 1px #ccc;border-right: solid 1px #ccc;border-bottom: solid 1px #ccc;border-top: solid 1px #ccc;"> 
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
