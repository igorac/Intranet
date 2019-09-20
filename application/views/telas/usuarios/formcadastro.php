<?php 
    defined('BASEPATH') OR exit('URL inválida.');
    /**/
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema Tutorial Admin Template</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/css/font-awesome.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/Ionicons/css/ionicons.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/Adminlte/AdminLTE.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/iCheck/square/blue.css') ?>">
  
  <link rel="stylesheet" href="<?= base_url('assets/css/main/main.css') ?>">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition register-page">

  <div class="register-box">
    <div class="register-logo">
      <a href="" class="red"><b class="gray">Intra</b>NET</a>
    </div>

    <div class="register-box-body">
      <p class="login-box-msg">Registrar um novo membro</p>

      <form action="<?= site_url('usuario/cadastrar') ?>" method="post">

        <?php echo form_error('nome'); ?>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="nome" placeholder="Nome Completo" value="<?= set_value('nome') ?>">
          <span class="red glyphicon glyphicon-user form-control-feedback"></span>
        </div>

        <?php echo form_error('login'); ?>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="login" placeholder="Login" value="<?= set_value('login') ?>">
          <span class="red glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        
        <?php echo form_error('email'); ?>
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?= set_value('email') ?>">
          <span class="red glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        
        <?php echo form_error('senha'); ?>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="senha" placeholder="Senha" value="<?= set_value('senha') ?>">
          <span class="red glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        
        <?php echo form_error('confirmar-senha'); ?>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="confirmar-senha" placeholder="Confirmar password" value="<?= set_value('confirmar-senha') ?>">
          <span class="red glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        

        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              &nbsp;
            </div>
          </div>

          
          <div class="col-xs-4">
            <button type="submit" class="btn btn-danger btn-block btn-flat">Registrar</button>
          </div>
         
        </div>
      </form> 



      <a class="red" href="<?= site_url('auth/login') ?>" class="text-center">Eu já tenho uma conta</a>
    </div>
    <!-- /.form-box -->
  </div>

  <!-- jQuery 3 -->
  <script src="<?php echo base_url('assets/js/jquery/dist/jquery.min.js') ?>"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo base_url('assets/js/bootstrap/bootstrap.min.js') ?>"></script>
  <!-- iCheck -->
  <script src="<?php echo base_url('assets/js/iCheck/icheck.min.js') ?>"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>
</html>