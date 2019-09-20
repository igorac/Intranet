<?php 
    $pagina = isset($_GET['pag']) ? $_GET['pag'] : 1;
?>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Perfil
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-id-badge"></i> &nbsp; Perfil </li>
        <li class="active">Lista de perfil</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">


            <div class="col-ws-12 col-sm-12 col-lg-12">

                <div class="box box-danger"> 

                    <div class="box-body">

                        <div class="loading" style="display: none">
                            <div class="spinner" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div> 

                        
                        <table id="example1" class="table table-bordered table-striped">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4 d-flex">
                                        <label for="per_page" style="font-weight: normal; margin: 5px 5px 0 0">Mostrar:</label>    
                                        <select class="form-control" name="per_page" id="per_page" onchange="showing_per_page(1)">
                                            <option value="2">2</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6" style="display: flex; justify-content: flex-end;">
                                    <div class="form-group d-flex">
                                        <label for="search" style="margin: 5px 8px 0 0; font-weight: normal">Buscar:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search" name="search" id="search" onkeyup="carregarPerfil(1)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button id="btn-add" class="btn btn-danger" style="margin: 0 0 8px 0"><i class="fa fa-plus-square"></i></button>

                            <thead>
                                <tr>
                                    <td class='w-1'>&nbsp;</td>
                                    <td>Perfil</td>
                                    <td>Data de Cadastro</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </thead>

                            <tbody id="showData">
                            </tbody>

                        </table>

                        <!-- Mensagem de error (Está vazio) -->
                        <div id="mensagem-vazio"></div>
                        
                        <div class="alert alert-success text-center" id="mensagem" style="display:none" ></div>

                        <!-- Paginate -->
                        <div style='margin-top: 10px;' id='pagination'></div>
        
                    </div>
                    <!-- /.box-body -->


                </div>
                <!-- /box box-danger -->
            </div>
            <!-- /col-ws-12 -->

        </div>

        
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Modal title</h4>
                        <span style="color: #f00">* Campo Obrigatório</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="myForm" action='' method="post">
                            <input type="hidden" name="id_perfil" id="id_perfil" value="0">

                            <div class="form-group">
                                <label for="perfil" class="col-sm-1 control-label">Perfil</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" name="perfil" id="perfil" placeholder="Perfil">
                                    <span class="help-block msg-perfil"></span>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnSave">Salvar</button>
                    </div>
                </div> <!-- /.modal-content -->
            </div> <!-- /.modal-dialog -->
        </div>   <!-- / #myModal -->

        <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    Você tem certeza que deseja excluir esse Perfil?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger" id="btnDelete" >Deletar</button>
                </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- / #myModal -->
      

        <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->

<script src="<?= base_url('assets/js/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?= base_url('assets/js/fastclick/lib/fastclick.js') ?>"></script>
<script src="<?= base_url('assets/js/demo.js') ?>"></script>
<script src="<?= base_url('assets/js/main/perfil.js') ?>"></script>
