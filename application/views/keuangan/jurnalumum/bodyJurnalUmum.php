<div id="CssLoader" style="display: none;">
    <div class='spinftw'></div>
</div>

<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-book"></i> Jurnal Umum</h3> 
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <select class="select2" id="kodeAkun">
                            <option value="">--Pilih Akun--</option>
                            <?php
                                foreach($viewHeadAccount as $dt){
                            ?>
                            <optgroup label="<?php echo $dt->kodeAkun." - ".$dt->namaAkun; ?>">
                                <?php
                                    $subAccount = $this->modelJurnalUmum->subAccount($dt->kodeAkun);
                                    foreach($subAccount as $row){
                                ?>
                                <option value="<?php echo $row->kodeSubAkun; ?>"><?php echo $row->kodeSubAkun." - ".$row->namaSubAkun; ?></option>
                                <?php } ?>
                            </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row" style="margin-top:30px;">
                    <div class="col-md-12" style="text-align:right;">
                        <button class='btn btn-success btn-rounded' id="submitJurnal"><i class='fa fa-save'></i> Simpan Jurnal</button>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Akun</th>
                                    <th style="width:20%">Debit</th>
                                    <th style="width:20%">Kredit</th>
                                    <th>Deskripsi</th>
                                    <th style='width:5%;'></th>
                                </tr>
                            </thead>

                            <tbody id="viewJurnal">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>


