<div class="wraper container-fluid">
    <div class="portlet"><!-- /primary heading -->
        <div class="portlet-heading">
            <h3 class="portlet-title text-dark text-uppercase">
                Kategori LEVEL 1
            </h3>
        </div>
        
        <div id="portlet2" class="panel-collapse collapse in">
            <div class="portlet-body">
            	<div class="row">
            		<div class="col-md-12 table-responsive">
                  <a href="<?php echo base_url('parameter/kategori_level_1'); ?>" class="btn btn-primary">Add Kategori</a> 
                
                  <br>
                  <br>

                  <?php 
                    if($this->session->userdata("message") !=''){
                      echo $this->session->userdata("message");
                    }
                  ?>
            			<table class="table" style="font-size: 12px;">
                    <tr style="font-weight: bold;">
                      <td width="5%">No</td>
                      <td>Kategori</td>
                      <td width="5%"></td>
                    </tr>
 
                    <?php
                      $i = 1;
                      foreach($kategori as $row){
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row->kategori; ?></td>
                      <td align="center">
                        <a href="<?php echo base_url('parameter/edit_kategori_level_1?id='.$row->id_kategori); ?>"><i class="fa fa-pencil"></i></a> 
                        <a onclick="return confirm('Apakah Anda Yakin ?')" href="<?php echo base_url('parameter/kategori_level_1_hapus?id='.$row->id_kategori); ?>"><i class="fa fa-trash"></i></td></a>
                    </tr>

                    <?php $i++; } ?>
                  </table>
            		</div>
            	</div>               
            </div>
        </div>
    </div> <!-- /Portlet -->	
</div>

