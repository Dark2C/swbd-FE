<!DOCTYPE html>
<html style="height: auto;" class="">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>SWBD - <?php echo htmlentities($page_title, ENT_QUOTES); ?></title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
      <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
      <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
      <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
      <style type="text/css">/* Chart.js */
         @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
      </style>
   </head>
   <body class="sidebar-mini layout-fixed" style="height: auto;">
      <div class="wrapper">
         <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                  <a href="/" class="nav-link">Dashboard</a>
               </li>
            </ul>
            <ul class="navbar-nav ml-auto">
               <li class="nav-item d-none d-sm-inline-block">
                  <a href="/?doLogout" class="nav-link">Logout</a>
               </li>
            </ul>
         </nav>
         <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
            <span class="brand-text font-weight-light">SWBD</span>
            </a>
            <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-host-scrollbar-vertical-hidden">
               <div class="os-resize-observer-host observed">
                  <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
               </div>
               <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
                  <div class="os-resize-observer"></div>
               </div>
               <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 513px;"></div>
               <div class="os-padding">
                  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="">
                     <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                           <div class="info">
                              <a href="#" class="d-block">Salve, <i><b><span class="userName"></span></b></i></a>
                           </div>
                        </div>
                        <nav class="mt-2">
                           <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                              <?php
                                 include 'menu.php';
                              ?>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
               <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
                  <div class="os-scrollbar-track">
                     <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px);"></div>
                  </div>
               </div>
               <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden">
                  <div class="os-scrollbar-track">
                     <div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px);"></div>
                  </div>
               </div>
               <div class="os-scrollbar-corner"></div>
            </div>
         </aside>
         <div class="content-wrapper" style="min-height: 457px;">
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0 text-dark"><?php echo htmlentities($page_title, ENT_QUOTES); ?></h1>
                     </div>
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="/">Home</a></li>
                           <li class="breadcrumb-item active"><?php echo htmlentities($page_title, ENT_QUOTES); ?></li>
                        </ol>
                     </div>
                  </div>
               </div>
            </div>
            <section class="content">
               <div class="container-fluid">
                  <div>
                     <?php include($requestedPage . '.php'); ?>
                  </div>
               </div>
            </section>
         </div>
         <footer class="main-footer">
            <strong>Copyright © 2020 <b>Ciampaglia &amp; Oliva</b>.</strong>
            All rights reserved.
         </footer>
         <div id="sidebar-overlay"></div>
      </div>
      <script src="plugins/jquery/jquery.min.js"></script>
      <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
      <script>
         $.widget.bridge('uibutton', $.ui.button)
      </script>
      <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/chart.js/Chart.min.js"></script>
      <script src="plugins/sparklines/sparkline.js"></script>
      <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
      <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
      <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
      <script src="plugins/moment/moment.min.js"></script>
      <script src="plugins/daterangepicker/daterangepicker.js"></script>
      <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
      <script src="plugins/summernote/summernote-bs4.min.js"></script>
      <script src="plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="dist/js/adminlte.js"></script>
      <div class="daterangepicker ltr show-ranges opensright">
         <div class="ranges">
            <ul>
               <li data-range-key="Today">Today</li>
               <li data-range-key="Yesterday">Yesterday</li>
               <li data-range-key="Last 7 Days">Last 7 Days</li>
               <li data-range-key="Last 30 Days">Last 30 Days</li>
               <li data-range-key="This Month">This Month</li>
               <li data-range-key="Last Month">Last Month</li>
               <li data-range-key="Custom Range">Custom Range</li>
            </ul>
         </div>
         <div class="drp-calendar left">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
         </div>
         <div class="drp-calendar right">
            <div class="calendar-table"></div>
            <div class="calendar-time" style="display: none;"></div>
         </div>
         <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
      </div>
      <script>
         var currentUser;
         $.ajax("<?php echo $restEntrypoint; ?>/utente/self", {
            type: "GET",
            contentType: "application/json; charset=utf-8",
            success: function(data) {
               currentUser = JSON.parse(data);
               $(".userName").html(currentUser.username);
            },
            error: function () {
               window.location = '/?doLogout';
            },
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true
         });
      </script>
   </body>
</html>