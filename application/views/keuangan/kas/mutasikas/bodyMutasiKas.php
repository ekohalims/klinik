<div class="wraper container-fluid">
    <div class="page-title"> 
    	<h3 class="title"><i class="fa fa-rotate-right"></i> Mutasi Kas</h3> 
        <h6> <a href="<?php echo base_url('kasDanBank'); ?>">Kas dan Bank</a> / Mutasi Kas</h6>
	</div>

    <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-6">
                        <form role="form">
                            <div class="form-group">
                                <label>Dari Akun</label>
                                <select class="select2" id="dariAkun">
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
                                <input type="number" class="form-control" id="saldo" placeholder="Sebesar">
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
                                <label>Ke Akun</label>
                                <select class="select2" id="keAkun">
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
                                <label>Keterangan</label>
                                <input type="text" class="form-control" placeholder="keterangan" id="keterangan"/>
                            </div>

                            <div class="form-group" style="text-align:right;">
                                <a class="btn btn-primary btn-rounded" id="simpanPembayaran">Simpan</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>
