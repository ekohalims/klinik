<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-user"></i> Pendaftaran Rawat Inap</h3> 
                <h6><a href="<?php echo base_url('pendaftaranRanap'); ?>">Rawat Inap</a> / Pendaftaran Baru</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
        <a href="#newPasien" id="pasienBaru" data-toggle="modal" class="btn btn-info"><i class="fa fa-plus"></i> Pasien Baru</a>
            <a href="#myModal" id="daftarPasien" data-toggle="modal" class="btn btn-success"><i class="fa fa-search"></i> Cari Pasien</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
            		<div class="col-md-12" style="text-align: right;">
            			<div class="form-inline">
	            			<div class="form-group">
	                            <input type="text" class="form-control" id="noPasien" placeholder="Search...">
	                        </div>

	                        <div class="form-group">
	                            <select class="form-control" id="searchBy">
	                            	<option value="noPasien">No RM</option>
	                            	<option value="noID">NIK</option>
	                            </select>
	                        </div>

	                        <div class="form-group">
	                        	<a class="btn btn-success" id="cariPasien"><i class="fa fa-search"></i></a>
	                        </div>
                    	</div>
            		</div>
            	</div>

                <div class="row" style="font-size: 13px;margin-top: 20px;">
                    <div class="col-md-6" style="border-right:solid 1px #ddd;">
                        <table class="table">
                            <tr>
                                <td width="20%" style="font-weight: bold;">No RM</td>
                                <td width="1%">:</td>
                                <td id="noPasienLabel"></td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">NIK</td>
                                <td width="1%">:</td>
                                <td id="noIDLabel"></td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Nama</td>
                                <td width="1%">:</td>
                                <td id="namaLabel"></td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Tanggal Lahir</td>
                                <td width="1%">:</td>
                                <td id="tanggalLahirLabel"></td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Sex / Umur</td>
                                <td width="1%">:</td>
                                <td id="sexLabel"></td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Alamat</td>
                                <td width="1%">:</td>
                                <td id="alamatLabel"></td>
                            </tr>  
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table width="100%">
                            <tr style="height:50px;">
                                <td style="font-weight: bold;" width="30%">Asal Rujukan <a href="#modalRujukan" data-toggle="modal" id="launchRujukan" class="btn btn-success btn-rounded"><i class="fa fa-plus"></i></a></td>
                                <td width="1%">:</td>
                                <td>
                                    <table width="100%">
                                        <tr>
                                            <td width="50%">
                                                <select class="form-control" id="jenisRujukan">
                                                    <option value="">--Pilih Rujukan--</option>
                                                    <?php 
                                                        foreach($jenisRujukan as $row){
                                                    ?>
                                                    <option value="<?php echo $row->idJenis; ?>"><?php echo $row->jenisRujukan; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td id="asalRujukanForm" style="padding-left:10px;vertical-align:middle;">
                                                <input type="hidden" id="asalRujukan" value=""/>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </td>
                            </tr> 
                            
                            <tr>
                                <td style="font-weight: bold;">Keluhan</td>
                                <td width="1%">:</td>
                                <td>
                                    <input type="text" class="form-control" id="keluhan"/>
                                </td>
                            </tr> 

                            <tr style="height: 55px;">
                                <td style="font-weight: bold;">Dokter <label id="labelDokter" style="color:red;"></labe></td>
                                <td width="1%">:</td>
                                <td>
                                    <input type="hidden" id="dokter" style="width:100%;"/>
                                </td>
                            </tr>

                            <tr style="height: 50px;">
                                <td style="font-weight: bold;">
                                    Ruang Inap <label id="ruangInapLabel" style="color:red;"></label>
                                    
                                </td>
                                <td width="1%">:</td>
                                <td id="ruangInapForm">
                                    <a id="launchRuangInap" class="btn btn-default btn-rounded"><i class="fa fa-bed"></i> Pilih Ruang Inap</a>
                                </td>
                            </tr>

                            <tr style="height: 20px;">
                                <td style="font-weight: bold;">Penanggung <label id="penanggungLabel" style="color:red;"></label></td>
                                <td width="1%">:</td>
                                <td>
                                    <?php
                                        foreach($layanan as $dt){
                                    ?>
                                    <input type="radio" name="layanan" class="layanan" value="<?php echo $dt->id_layanan; ?>"> <?php echo $dt->layanan; ?>
                                    <?php } ?>

                                    <input type="hidden" id="idPasien" value="">
                                </td>
                            </tr>    

                            <tr style="height:50px;"> 
                                <td></td>
                                <td></td>
                                <td id="tanggunganAsuransi">
                                    <input type="hidden" id="asuransi" value=""/>           
                                </td>
                            </tr> 

                            <tr style="height:70px;"> 
                                <td></td>
                                <td></td>
                                <td id="noKartuForm">
                                    <input type="hidden" id="noKartu" value=""/>            
                                </td>
                            </tr>                       
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <a class="btn btn-primary btn-rounded" id="submitPendaftaran"> <i class="fa fa-save"></i> Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

<input type="hidden" id="ruangInap" value=""/>

<div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Daftar Pasien</h4>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div id="modalRujukan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Asal Rujukan</h4>
            </div>
            <div class="modal-body" id="formRujukan">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="simpanRujukan">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  


<div id="newPasien" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Pasien Baru</h4>
            </div>
            <div class="modal-body" id="pasienBaruForm">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="simpanPasien">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  

<div id="ruangInapModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Ruang Inap</h4>
            </div>
            <div class="modal-body" id="ruangInapModalContent">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->  





