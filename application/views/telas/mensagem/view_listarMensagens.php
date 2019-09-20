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
          <a href="<?= site_url('mensagem/enviarMensagem') ?>" class="btn btn-danger btn-block margin-bottom">Enviar Mensagem</a>

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
              <h3 class="box-title"><?= $title ?? '' ?></h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" name="searchTitulo" id="searchTitulo" placeholder="Search Mail" onkeyup="globalMensagens()">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
           
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle selecionar-tudo"><i class="fa fa-square-o"></i>
                </button>

                <div class="btn-group group-funcionalidades" style="display:none;">
                  <button type="button" class="btn btn-default btn-sm deletar-mensagem"><i class="fa fa-trash"></i></button>
                  <button type="button" class="btn btn-default btn-sm lido-naoLido-mensagem"><i class="fa fa-envelope"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                  
                  <?php if (isset($is_recover) && $is_recover) { ?>
                    <button type="button" class="btn btn-default btn-sm recuperar-mensagem"><i class="fa fa-hand-grab-o text-black"></i></button>
                  <?php } ?>
                </div>
                
                <button type="button" class="btn btn-default btn-sm btn-refresh" id="refresh-page"><i class="fa fa-refresh"></i></button>

                <div class="pull-right">
                  <select name="select-favorito" id="select-favorito" class="form-control select-favorito">
                    <option value="">Selecione</option>
                    <option value="2">Favorito</option>
                    <option value="1">Não Favorito</option>
                  </select>
                </div>
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody id="tbody">

                    <div class="alert text-center" id="mensagem" style="display:none;"></div>

                  </tbody>
                </table>
              </div>
            </div>


           <div class="box-footer no-padding">
              <div class="mailbox-controls">
                
                <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle selecionar-tudo"><i class="fa fa-square-o"></i>
                </button>

                
                <div class="btn-group group-funcionalidades" style="display:none;">
                  <button type="button" class="btn btn-default btn-sm deletar-mensagem"><i class="fa fa-trash"></i></button>
                  <button type="button" class="btn btn-default btn-sm lido-naoLido-mensagem"><i class="fa fa-envelope-open"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                  <?php if (isset($is_recover) && $is_recover) { ?>
                    <button type="button" class="btn btn-default btn-sm recuperar-mensagem"><i class="fa fa-hand-grab-o"></i></button>
                  <?php } ?>
                </div>

              
                <button type="button" class="btn btn-default btn-sm btn-refresh"><i class="fa fa-refresh"></i></button> -->

                <div class="pull-right">

                  <div class="btn-group pagination">
                  </div>
                  
                </div>
              
              </div> 
            </div>


          </div>
        
        </div>

       
      </div>
      
      <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Deletar Mensagem</h4>
                    </div>
                    <div class="modal-body">
                        Body
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" id="btnDelete" >Deletar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalRecover" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Recuperar Mensagem</h4>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja recuperar a mensagem para a caixa de entrada?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" id="btnRecover" >Recuperar</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    



</div>

<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<!-- <script src="<?= base_url('assets/js/main/usuario.js') ?>"></script> -->
<script src="<?= base_url('assets/js/main/mensagem.js') ?>"></script>
<script>

$(function(){
    globalMensagens(); // Responsável por listar todas as mensagens de acordo com o href (URL)
});

function globalMensagens() {

    var href = window.location.href;
    href = href.substring(31);

    switch(href) {
        case 'view_enviado':
            carregarMensagensEnviadas(1);
            break;
        
        case 'view_caixaEntrada':
            carregarMensagens(1);
            break;

        case 'view_lixeira':
            carregarMensagensExcluidas(1);    
            break;
    }

}

function carregarMensagens(pag) {
    var search = $.trim($('#searchTitulo').val());
    var is_favorite = $('#select-favorito').val();

    $.ajax({
        url: url_atual+"/mensagem/exibirTodasMensagensCaixaEntrada/"+pag,
        method: "post",
        data: {
          search: search,
          is_favorite: is_favorite
        },
        dataType: "json",
        success: function(response) {
            console.log(response);
            renderCaixaEntrada(response.emails);

            if (response.mensagem) {
                $('#mensagem').text(response.mensagem).removeClass('alert-success alert-danger alert-warning').show('fast');
            } else {
                $('#mensagem').removeClass('alert-success alert-danger alert-warning').hide('fast');
            }

            $('.pagination').html(response.pagination);

        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function carregarMensagensExcluidas(pag) {
    var search = $.trim($('#searchTitulo').val());
    var is_favorite = $('#select-favorito').val();

    $.ajax({
        url: url_atual+"/mensagem/exibirTodasMensagensExcluidas/"+pag,
        method: "post",
        data: {
          search: search,
          is_favorite: is_favorite
        },
        dataType: "json",
        success: function(response) {

            console.log(response);

            renderCaixaEntrada(response.emails);

            if (response.mensagem) {
                $('#mensagem').removeClass('alert-success alert-danger alert-warning').text(response.mensagem).show('fast');
            } else {
                $('#mensagem').removeClass('alert-success alert-danger alert-warning').hide('fast');
            }

            $('.pagination').html(response.pagination);

        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

function carregarMensagensEnviadas(pag) {
    var search = $.trim($('#searchTitulo').val());
    var is_favorite = $('#select-favorito').val();

    $.ajax({
        url: "<?= base_url() ?>/mensagem/exibirTodasMensagensEnviada/"+pag,
        method: "post",
        data: {
          search: search,
          is_favorite: is_favorite
        },
        dataType: "json",
        success: function(response) {
            // console.log(response);

            renderCaixaEntrada(response.emails);

            if (response.mensagem) {
                $('#mensagem').text(response.mensagem).removeClass('alert-success alert-danger alert-warning').show('fast');
            } else {
                $('#mensagem').removeClass('alert-success alert-danger alert-warning').hide('fast');
            }

            $('.pagination').html(response.pagination);

        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}

</script>