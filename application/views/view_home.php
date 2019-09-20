<?php 
    defined('BASEPATH') OR exit('URL inválida.');
?>

<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IntraNET</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script> -->
  

  <!-- Boostrap CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap/dist/css/bootstrap.min.css') ?>">
  
  <!-- Font-awesome css -->
  <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome/css/font-awesome.min.css') ?>">
 
  <!-- <link rel="stylesheet" href="<?= base_url('assets/css/Ionicons/css/ionicons.min.css') ?>"> -->
    
  <!-- AdminLTE css -->  
  <link rel="stylesheet" href="<?= base_url('assets/css/Adminlte/AdminLTE.css') ?>">
  
  <!-- Skin red do admin-lte -->
  <link rel="stylesheet" href="<?= base_url('assets/css/Skins/skin-red.min.css') ?>">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/main/main.css') ?>">

  <!-- Select2 CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/select2/css/select2.css') ?>">

  <!-- Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
       
</head>


<!-- jquery js -->
<script src="<?= base_url('assets/js/jquery/dist/jquery.min.js') ?>"></script>
<!-- bootstrap js -->
<script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js') ?>"></script>
<!-- AdminLTE JS -->
<script src="<?= base_url('assets/js/adminlte/adminlte.min.js') ?>"></script>
<!-- jQuery MASK -->
<script src="<?= base_url('assets/js/jquery.mask.min.js') ?>"></script>
<!-- Select2 JS -->
<script src="<?= base_url('assets/js/select2/js/select2.js') ?>"></script>



<body class="hold-transition skin-red sidebar-mini">
   
    <div class="wrapper">

    <?php
        
        /* Topbar */
        $this->load->view('layout/topbar');

        /* Sidebar */
        $this->load->view('layout/sidebar');
        

        if (isset($tela) && !empty($tela)) {
            
            $this->load->view('telas/'.$tela);
        }

        /* Footer */
        $this->load->view('layout/footer');
    ?>
    
    </div>
    <!--/wrapper -->



</body>


</html>

    