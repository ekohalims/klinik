<div class="wraper container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="page-title"> 
                <h3 class="title"><i class="fa fa-plus"></i> Tambah User Group</h3> 
                <h6><a href="<?= base_url('userGroup'); ?>">User Group</a> / Add</h6>
            </div>
        </div>

        <div class="col-md-6" style="text-align:right;">
            <a class="btn btn-primary" id="simpan"><i class="fa fa-save"></i> Simpan<a>
        </div>
    </div>

    
    <div class="row">
        <div class="col-md-6">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12 table-responsive">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Group Name</label>
                                        <input type="text" class="form-control" id="group" placeholder="Group Name">
                                        <label class="groupError" style='color:red;'></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->	
        </div>

        <div class="col-md-6">
            <div class="portlet" style="border-top:solid 4px #12a89d;"><!-- /primary heading -->
                <div id="portlet2" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12 table-responsive">
                                <?php
                                    $permitAccess = json_decode($permitAccess);

                                    foreach($navigation as $row){

                                        echo "<input type='checkbox' data-id='".$row->id."' id='menu'/>&nbsp".$row->menu."<br>";

                        
                                        $submenu = $this->model1->submenu($row->id);
                                        foreach($submenu as $dt){
                                        echo "&nbsp &nbsp &nbsp <input type='checkbox' data-id='".$dt->idSub."' id='submenu'/>&nbsp".$dt->menu."<br>";
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /Portlet -->	
        </div>
    </div>
</div>

