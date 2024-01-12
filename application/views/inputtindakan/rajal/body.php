<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-user-md"></i> Input Tindakan Rawat Jalan</h3> 
            </div>
        </div>

        <div class="col-md-6" style='text-align:right;'>
            <a class="btn btn-success" id="btn-filter"><i class="fa fa-filter"></i> Filter</a>
            <!--jangan tampil, harus pilih dokter terlebih dahulu-->
        </div>
    </div>
    
	<div class="row" id="filter-form" style="margin-bottom:10px;display:none">
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-3 control-label" style="padding-top:10px">Dokter</label>
				<div class="col-md-9">
					<select id="dokter" class="select2" style="vertical-align:middle">
					<option value="">Semua Dokter</option>
					<?php if($listdokter):?>
					<?php foreach ($listdokter as $l):?>
						<option value="<?= $l->nama ?>"><?= $l->nama ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>	
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-3 control-label" style="padding-top:10px">Poliklinik</label>
				<div class="col-md-9">
					<select id="poli" class="select2" style="vertical-align:middle">
					<option value="">Semua Poliklinik</option>
					<?php if($listpoli):?>
					<?php foreach ($listpoli as $l):?>
						<option value="<?= $l->poliklinik ?>"><?= $l->poliklinik ?></option>
					<?php endforeach; ?>
					<?php endif; ?>
					</select>
				</div>	
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="col-md-3 control-label">Tanggal Daftar</label>
				<div class="col-md-9">
					<input id="tgl_daftar" class="datepicker form-control" style="vertical-align:middle">					
				</div>	
			</div>
		</div>
		<div class="col-md-4" style='text-align:right;'>
			<a class="btn btn-success" id="btn-dofilter"><i class="fa fa-filter"></i> Do Filter</a>
			<a class="btn btn-info" id="btn-clearfilter"><i class="fa fa-filter"></i> Clear Filter</a>
		</div>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>No Antrian</th>
                                    <th>No Register</th>
                                    <th>No RM</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Nama</th>
                                    <th>Sex</th>
                                    <th>Tgl Lahir</th>
                                    <th>Nama Poli</th>
                                    <th>Nama Dokter</th>
                                    <th>Penanggung</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

