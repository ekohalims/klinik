<div class="wraper container-fluid">
    <div class="page-title">
        <h3 class="title"><i class="fa fa-car"></i> Tambah Harta Tetap</h3>
        <h6><a href="<?php echo base_url('hartaTetap'); ?>">Harta Tetap</a> / Tambah Harta Tetap</h6>
    </div>

    <div class="portlet" style="border-top:solid 4px #12a89d;">
        <!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Kelompok <a href='#myModal' data-toggle='modal'><i class='fa fa-plus'></i></a></label>
                                <div class="col-sm-9" id='formKelompokHarta'>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Beli</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepicker" id="tanggalBeli" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Harga Beli</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="hargaBeli">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Nilai Residu</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nilaiResidu">
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Umur Ekonomis</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="umurEkonomis">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Metode</label>
                                <div class="col-sm-9">
                                    <select class='form-control' id="metode">
                                        <option value="1">Tanpa Penyusutan</option>
                                        <option value="2">Garis Lurus</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Akun Harta</label>
                                <div class="col-sm-9">
                                    <select class="select2" id="akunHarta">
                                        <option value="">--Pilih Akun--</option>
                                        <?php
                                            foreach($coa as $row){
                                        ?>
                                        <optgroup label="<?php echo $row->kodeAkun." - ".$row->namaAkun; ?>">
                                            <?php
                                                $coaSub = $this->db->get_where("coa_sub",array("kodeAkun" => $row->kodeAkun))->result();
                                                foreach($coaSub as $dt){
                                            ?>
                                            <option value="<?php echo $dt->kodeSubAkun; ?>"><?php echo $dt->kodeSubAkun." - ".$dt->namaSubAkun; ?></option>
                                            <?php } ?>
                                        </optgroup>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Akumulasi Depresiasi</label>
                                <div class="col-sm-9">
                                    <select class="select2" id="akumulasiDepresiasi">
                                        <option value="">--Pilih Akun--</option>
                                        <?php
                                            foreach($coa as $row){
                                        ?>
                                        <optgroup label="<?php echo $row->kodeAkun." - ".$row->namaAkun; ?>">
                                            <?php
                                                $coaSub = $this->db->get_where("coa_sub",array("kodeAkun" => $row->kodeAkun))->result();
                                                foreach($coaSub as $dt){
                                            ?>
                                            <option value="<?php echo $dt->kodeSubAkun; ?>"><?php echo $dt->kodeSubAkun." - ".$dt->namaSubAkun; ?></option>
                                            <?php } ?>
                                        </optgroup>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Depresiasi</label>
                                <div class="col-sm-9">
                                    <select class="select2" id="depresiasi">
                                        <option value="">--Pilih Akun--</option>
                                        <?php
                                            foreach($coa as $row){
                                        ?>
                                        <optgroup label="<?php echo $row->kodeAkun." - ".$row->namaAkun; ?>">
                                            <?php
                                                $coaSub = $this->db->get_where("coa_sub",array("kodeAkun" => $row->kodeAkun))->result();
                                                foreach($coaSub as $dt){
                                            ?>
                                            <option value="<?php echo $dt->kodeSubAkun; ?>"><?php echo $dt->kodeSubAkun." - ".$dt->namaSubAkun; ?></option>
                                            <?php } ?>
                                        </optgroup>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-12" style="text-align:right;">
                        <button class='btn btn-success btn-rounded' id="simpanAset"><i class='fa fa-save'></i> Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Portlet -->
</div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Kelompok Harta</h4>
            </div>

            <div class="modal-body">      
                <table class='table'>
                    <tr>
                        <td>Nama</td>
                        <td><input type='text' class='form-control' placeholder='Nama Kelompok Harta' id='kelompokHartaAkun'/></td>
                    </tr>
                </table>                            
            </div>
                                            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id='simpanKelompokHarta'>Simpan</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->