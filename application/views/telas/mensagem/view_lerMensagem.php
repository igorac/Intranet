<?php 
    defined('BASEPATH') OR exit('URL inválida.');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-envelope"></i> &nbsp; Mailbox</li>
        <li class="active">Visualizar a Mensagem</li>
      </ol>
    </section>

  
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="<?= site_url('mensagem/view_caixaEntrada') ?>" class="btn btn-danger btn-block margin-bottom">Voltar para a caixa de entrada</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Funcionalidades</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="<?= site_url('mensagem/view_caixaEntrada') ?>"><i class="fa fa-inbox"></i> Caixa de entrada
                  <span class="label label-danger pull-right">12</span></a></li>
                <li><a href="<?= site_url('mensagem/view_enviado') ?>"><i class="fa fa-envelope-o"></i> Enviado</a></li>
                <li><a href="<?= site_url('mensagem/view_lixeira') ?>"><i class="fa fa-trash"></i> Lixeira <span class="label label-warning pull-right">65</span></a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
       
        <div class="col-md-9">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Ler a Mensagem</h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?= $mensagem[0]['TITULO'] ?></h3>
                <h5>De: <?= $mensagem[0]['USUARIO_ORIGEM'] ?>
                  <span class="mailbox-read-time pull-right"><?= date('d-m-Y', strtotime($mensagem[0]['DATA_ENVIO'])) ?></span></h5>
              </div>

              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <!-- <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                    <i class="fa fa-trash-o"></i></button> -->
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                    <i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                    <i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                  <i class="fa fa-print"></i></button>
              </div>
              <!-- /.mailbox-controls -->

              <div class="mailbox-read-message custom-read-message">
                <?= $mensagem[0]['DESCRICAO'] ?>
              </div>

            </div>
           
          
            <!-- /.box-footer -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
                <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>
              </div>
              <!-- <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Delete</button> -->
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>

       
      </div>
      
      

    </section>
    


</div>

<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('assets/js/main/usuario.js') ?>"></script>