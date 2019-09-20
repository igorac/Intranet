<?php 
    defined('BASEPATH') OR exit('URL inválida.');
?>

<link rel="stylesheet" href="<?= base_url('assets/css/jquery-tokeninput/token-input-facebook.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/jquery-tokeninput/token-input-mac.css') ?>">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-envelope"></i> &nbsp; Mailbox</li>
        <li class="active">Envio de Mensagem</li>
      </ol>
    </section>

    <!-- Main content -->
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
          <!-- /. box -->
          
        </div>
        
        <div class="col-md-9">
          <form action="<?= base_url('mensagem/enviarMensagem') ?>" method="post">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Enviar nova mensagem</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                  <div class="ui-widget">
                    <input class="form-control" name="usuario_destino[]" id="usuario_destino" placeholder="Para:" value="<?= set_value('usuario_destino[]', isset($usuario[0]['EMAIL']) ? $usuario[0]['EMAIL'] : '' ) ?>">  
                    <?php echo form_error('usuario_destino[]'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <input class="form-control" name="titulo" id="titulo" placeholder="Título:" value="<?= set_value('titulo') ?>">
                  <?php echo form_error('titulo'); ?>
                </div>
                <div class="form-group">
                  <textarea name="editor1" id="editor1">
                    <?= set_value('editor1') ?>
                  </textarea>
                  <?php echo form_error('editor1'); ?>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="pull-right">
                  <!-- <button type="submit" class="btn btn-danger"><i class="fa fa-envelope-o"></i> Enviar</button> -->
                  <button type="submit" class="btn btn-danger" id="btn-enviar-mensagem"><i class="fa fa-envelope-o"></i> Enviar</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </div>
            <!-- /. box -->
          </form>

          <!-- <div class="alert text-center" id="mensagem" style="display:none;"></div> -->
          <?php if (isset($sucesso)) { ?>
            <?php if ($sucesso) { ?>
              <div class="alert alert-success text-center">Mensagem enviada com sucesso!</div>
            <?php } else { ?>
              <div class="alert alert-warning text-center">Erro ao enviar a mensagem!</div>
            <?php } ?>
          <?php } ?>

        </div>

       
      </div>
      
      

    </section>
    <!-- /.content -->
</div>


<script src="<?= base_url('assets/js/jquery-tokeninput/jquery.tokeninput.js') ?>"></script>
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('assets/js/main/mensagem.js') ?>"></script>

<script>

    CKEDITOR.replace('editor1',{
        filebrowserBrowseUrl: '<?= base_url() ?>assets/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: '<?= base_url() ?>assets/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: '<?= base_url() ?>assets/ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl: '<?= base_url() ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: '<?= base_url() ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: '<?= base_url() ?>assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
    });

    // Responsável pelo autocomplete e pelo multiple values no textbox
    $('#usuario_destino').tokenInput('<?= base_url() ?>usuario/consultarPorEmail' ,{
        hintText: "", // Define um placeholder
        noResultsText: "Nenhum resultado encontrado", // Define um placeholder
        searchingText: "Buscando...", // Define um placeholder
        theme: "facebook",  // Define o theme utilizado no input
        searchDelay: 500,  // Define o delay entre a busca e a ocorrência do resultado
        minChars: 1, // Define a quantidade mínima de caracteres necessários para realizar a busca, por default: 1
        onResult: function(response) {  // Define como vai ser exibido o resultado selecionado
       
            $.each(response, function(index, value){
                value.name = value.EMAIL;
                value.id   = value.EMAIL;
            });

            return response;
        },
        method: "post", // Define o verbo HTTP
        resultsFormatter: function(item){ // Define como vai ser exibido o menu de sugestões
            
            if (item.IMAGEM !== null) {
                return '<li class="li-facebook"><img src="<?= site_url()?>assets/upload/160px/' + item.IMAGEM + '" class="imageClass" alt="imagem perfil " />' + item.EMAIL + '</li>' 
            } else {
                return '<li class="li-facebook"><img src="http://localhost:3000/assets/images/default.png" class="imageClass" alt="imagem default " />' + item.EMAIL + '</li>' 
            }    
        },
       queryParam: "search", // Define o param que será recuperado no backend
       preventDuplicates: true, // Define que não haverá valores duplicados no input
    });
    

</script>