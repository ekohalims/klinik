<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="<?php echo base_url('assets/ypta.png'); ?>">

        <title><?php echo $pageTitle; ?></title>
        <link href="<?php echo base_url('assets'); ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/css/bootstrap-reset.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/css/loader.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo base_url('assets/assets/croppie/croppie.css'); ?>" rel="stylesheet" />
        <link href="<?php echo base_url('assets'); ?>/assets/notifications/notification.css" rel="stylesheet" />
        <link href="<?php echo base_url('assets'); ?>/assets/sweet-alert/sweet-alert.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets'); ?>/assets/printjs/print.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets'); ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/css/helper.css" rel="stylesheet">
        <link href="<?php echo base_url('assets'); ?>/assets/dropzone/dropzone.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets'); ?>/assets/select2/select2.css" />
        <link href="<?php echo base_url('assets'); ?>/assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
        <style type="text/css"> 
            @media print {
              a[href]:after {
                content: none !important;
              }
            }

            .verticalTableHeader {
                text-align:center;
                white-space:nowrap;
                transform: rotate(90deg);
            }
            .verticalTableHeader p {
                margin:0 -999px;/* virtually reduce space needed on width to very little */
                display:inline-block;
            }
            .verticalTableHeader p:before {
                content:'';
                width:0;
                padding-top:110%;
                /* takes width as reference, + 10% for faking some extra padding */
                display:inline-block;
                vertical-align:middle;
            }

        </style>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            function printContent(el){
                    var restorepage = document.body.innerHTML;
                    var printcontent = document.getElementById(el).innerHTML;
                    document.body.innerHTML = printcontent;
                    window.print();
                    document.body.innerHTML = restorepage;
                }
        </script>
    </head>


    <body style="height: 100%;">

        <!-- Aside Start-->
        <aside class="left-panel <?php if($this->uri->segment(1)=='penjualan') {echo "collapsed";} ?>">

            <!-- brand -->
            <div class="logo">
                <a href="<?php echo base_url(); ?>" class="logo-expanded">
                   <img src="<?php echo base_url('assets/ypta.png'); ?>" width="20%"/>
                </a>
            </div>
            <!-- / brand -->
        
            <!-- Navbar Start -->
            <nav class="navigation" style="margin-top: 0px;">
                <ul class="list-unstyled">

                    <?php
                        $permitAccess = json_decode($permitAccess);
                        $permitAccessSub = json_decode($permitAccessSub);

                        foreach($navigation as $row){

                          /**if(empty($permitAccess)){
                            $permitAccess =[];
                          }**/

                          $accessMenu = in_array($row->id,$permitAccess);

                          if($accessMenu > 0){

                          $slug = $row->slug;

                          if($row->slug!=''){
                    ?>
                          <li class="<?php if($slug==$this->uri->segment(1)){echo "active";} ?>"><a href="<?php echo base_url($row->slug); ?>"><i class="<?php echo $row->icon; ?>"></i> <span class="nav-label"><?php echo $row->menu; ?></span></a></li>

                    <?php } else { ?>
                        <?php
                           $getHeader = $this->modelPublic->getHeaderNavigation($this->uri->segment(1));
                        ?>

                        <li class="has-submenu <?php if($getHeader==$row->id){echo "active";}?>"><a href=""><i class="<?php echo $row->icon; ?>"></i><span class="nav-label"><?php echo $row->menu; ?></span></a>
                            <ul class="list-unstyled">
                                  <?php
                                    $submenu = $this->model1->submenu($row->id);

                                    foreach($submenu as $dt){
                                      $accessSubMenu = in_array($dt->idSub,$permitAccessSub);

                                      if($accessSubMenu > 0){
                                  ?>
                                  <li class="<?php if($dt->slug==$this->uri->segment(1)){echo "active";} ?>"><a href="<?php echo base_url($dt->slug); ?>"><?php echo $dt->menu; ?></a></li> 
                                  <?php } } ?>
                            </ul>
                        </li>
                  <?php
                        }//end if slug 
                      }//end if access menu
                    }//end foreach navigation
                  ?>
                    
                </ul>
            </nav>
                
        </aside>
        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
             
                
                <!-- Left navbar -->
                <nav class=" navbar-default" role="navigation">
                

                    <!-- Right navbar -->
                    <ul class="nav navbar-nav navbar-right top-menu top-right-menu">  
                        <!-- user login dropdown start-->
                        <li class="dropdown text-center">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#"> 
                                <span class="username"><?php echo $this->ion_auth->user()->row()->first_name; ?> </span> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                                <li><a href="<?php echo base_url('logout'); ?>"><i class="fa fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </li>
                        <!-- user login dropdown end -->       
                    </ul>
                    <!-- End right navbar -->
                </nav>
                
            </header>
            <!-- Header Ends -->


            <!-- Page Content Start -->
            <!-- ================== -->