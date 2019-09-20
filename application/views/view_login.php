<?php 
    defined('BASEPATH') OR exit('URL inválida.');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IntraNET</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome/css/font-awesome.min.css') ?>">
  <!-- Theme style  -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/Adminlte/AdminLTE.min.css') ?>">
  <!-- main.css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/main/main.css') ?>">

  <!-- iCheck   
  <link rel="stylesheet" href="<?php echo base_url('assets/css/iCheck/square/blue.css') ?>"> -->
   <!-- Ionicons 
  <link rel="stylesheet" href="<?php echo base_url('assets/css/Ionicons/css/ionicons.min.css') ?>"> -->
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="" class="red">Intra<b class="gray">NET</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Entre para iniciar sua sessão</p>

      <?php 
        echo form_open('auth/login');
      ?> 
      
        <div class="form-group has-feedback">
            <?php echo form_error('login'); ?>
            <input type="text" class="form-control" name="login" placeholder="Usuário" value="<?php echo set_value('login') ?>">
            <span class="red glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
            <?php echo form_error('senha'); ?>
            <input type="password" id="password" class="form-control" name="senha" placeholder="Password" >
            <span class="red glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-6">
                    <a href="<?= site_url('usuario/cadastrar') ?>" class="btn btn-danger btn-block btn-flat">Cadastrar</a>
                </div>

                <div class="col-xs-6">
                    <button type="submit" class="btn btn-danger btn-block btn-flat" id="btn-login">Entrar</button>  
                </div>
            </div>
            <!-- /.col -->
        </div>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/js/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/js/bootstrap/bootstrap.min.js') ?>"></script>

<!-- iCheck 
<script src="<?php echo base_url('assets/js/iCheck/icheck.min.js') ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>-->

</body>
</html>
