<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-arrow-circle-left"></i> Kas Keluar</h3> 
                <h6> <a href="<?php echo base_url('kasDanBank'); ?>">Kas dan Bank</a> / Kas Keluar</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;vertical-align:bottom;">
            <a href="<?php echo base_url('kasDanBank/listKasKeluar'); ?>" class="btn btn-default btn-rounded"><i class='fa fa-list'></i> List Kas Keluar</a>
        </div>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <form role="form">
                            <div class="form-group">
                                <label>Akun Kas</label>
                                <select class="select2" id="kas">
                                    <option value="">--Pilih Kas--</option>
                                    <optgroup label="Kas">
                                        <?php
                                            foreach($kasAktif as $ks){
                                        ?>
                                        <option value="<?php echo $ks->kodeSubAkun; ?>"><?php echo $ks->kodeSubAkun." - ".$ks->namaSubAkun; ?></option>
                                        <?php } ?>
                                    </optgroup>

                                    <optgroup label="Bank">
                                        <?php
                                            foreach($bankAktif as $bk){
                                        ?>
                                        <option value="<?php echo $bk->kodeSubAkun; ?>"><?php echo $bk->kodeSubAkun." - ".$bk->namaSubAkun; ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Sebesar</label>
                                <input type="number" class="form-control" id="nilaiKas" placeholder="Sebesar">
                            </div>

                            <div class="form-group" style="border:solid 1px #ccc;padding:10px;">
                                <label for="exampleInputEmail1">Terbilang</label>
                                <p id="terbilang"></p>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form role="form">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Memo</label>
                                <input type="text" class="form-control" id="memo" placeholder="Memo">
                            </div>

                            <div class="form-group">
                                <label>Alokasi</label>
                                <select class="select2" id="alokasi">
                                    <option>--Pilih Alokasi Akun--</option>
                                    <?php
                                        foreach($coa as $row){
                                    ?>
                                    <optgroup label="<?php echo $row->kodeAkun." - ".$row->namaAkun; ?>">
                                        <?php
                                            $coaSub = $this->db->get_where("coa_sub",array("kodeAkun" => $row->kodeAkun))->result();
                                            foreach($coaSub as $dt){
                                        ?>
                                        <option value="<?php echo $dt->kodeSubAkun; ?>"><?php echo $dt->kodeSubAkun." ".$dt->namaSubAkun; ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group" style="text-align:right;">
                                <a class='btn btn-success btn-rounded' id="simpanKasKeluar"><i class='fa fa-save'></i> Simpan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
