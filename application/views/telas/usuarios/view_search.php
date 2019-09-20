<?php 
    defined('BASEPATH') OR exit('URL inválida.');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listar Usuários
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"><i class="fa fa-user"></i>Usuario</a></li>
        <li class="active">Listar Usuários</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            <div class="box box-danger">

                <div class="box-header with-border">
                    <h3 class="box-title">Pesquisar</h3>
                </div>

                <form class="form-horizontal">

                    <div class="box-body">
                        <div class="container-topo-search">

                            <div class="form-group">
                                <label for="per_page" class="col-sm-2 control-label">Mostrar:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" name="per_page" id="per_page" value="1" min="1" max="20" onchange="limiteRegPorPagina(1)">
                                </div>
                                <span style="font-weight:bold; line-height: 35px;">registros por página</span>
                            </div>

                            <div class="form-group">
                                <label for="nome" class="col-sm-2 control-label">Nome:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nome_search" id="nome_search" placeholder="Nome" onkeyup="carregarUsuario(1)">
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

                <div class="box-body">
                    <ul id="lista-usuario">
                    </ul> 
                    
                    <div class="alert alert-danger text-center" id="mensagem" style="display:none;"></div>
                </div>

                
                <div class="box-footer">
                    <nav>
                        <div id="pagination">
                        </div>
                    </nav>
                </div>

            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<script src="<?= base_url('assets/js/main/usuario.js') ?>"></script>