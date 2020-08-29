<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>SWBD | Log in</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- icheck bootstrap -->
      <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
      <script>
         <?php
            if(isset($_GET['doLogout'])) {
         ?>
         document.addEventListener('DOMContentLoaded', function() {
            $.ajax({
               url: "<?php echo $restEntrypoint; ?>/sessione/logout",
               type: 'GET',
               contentType: "application/json; charset=utf-8",
               crossDomain: true,
               xhrFields: {
                 withCredentials: true
               },
               dataType: "json",
               success: function() {
                  window.location = '/';
               },
               error: function() {
                  window.location = '/';
               }
            });
         }, false);
         <?php
            }
         ?>
        function ajaxLogin() {
          $.ajax({
              url: "<?php echo $restEntrypoint; ?>/sessione/login",
              type: 'POST',
              data: JSON.stringify({
                  email: ($("#email").val() == '') ? null : $("#email").val(),
                  username: ($("#username").val() == '') ? null : $("#username").val(),
                  password: $("#password").val()
              }),
              contentType: "application/json; charset=utf-8",
              crossDomain: true,
              xhrFields: {
                withCredentials: true
              },
              dataType: "json",
              success: function(data) {
                $.post("/?doLogin", "JWT=" + data.JWT).done(function (data) {
                  window.location = "/";
                });
              },
              error: function() {
                  $("#loginError").show();
              }
          });
        }
      </script>
   </head>
   <body class="login-page" style="min-height: 512.8px;">
      <div class="login-box">
         <div class="login-logo">
            <a href="./"><b>SWBD</b></a>
         </div>
         <!-- /.login-logo -->
         <div class="card">
            <div class="card-body login-card-body">
               <p class="login-box-msg">Accedi all'area riservata</p>
               <div class="info-box bg-danger" id="loginError" style="display: none;">
                  <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                  <div class="info-box-content">
                     <span class="info-box-text">Errore</span>
                     <span class="progress-description">Credenziali sbagliate</span>
                  </div>
                  <!-- /.info-box-content -->
               </div>
               <form id="frm" action="javascript:ajaxLogin();">
                  <div class="input-group mb-3">
                     <input type="email" id="email" class="form-control" placeholder="Email">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-envelope"></span>
                        </div>
                     </div>
                  </div>
                  <p style="text-align: center;">- Oppure -</p>
                  <div class="input-group mb-3">
                     <input id="username" class="form-control" placeholder="Username">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-user"></span>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="input-group mb-3">
                     <input type="password" id="password" class="form-control" required placeholder="Password">
                     <div class="input-group-append">
                        <div class="input-group-text">
                           <span class="fas fa-lock"></span>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-8">
                     </div>
                     <!-- /.col -->
                     <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Log In</button>
                     </div>
                     <!-- /.col -->
                  </div>
               </form>
               <!-- /.social-auth-links -->
            </div>
            <!-- /.login-card-body -->
         </div>
      </div>
      <!-- /.login-box -->
      <!-- jQuery -->
      <script src="../../plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="../../dist/js/adminlte.min.js"></script>
   </body>
</html>