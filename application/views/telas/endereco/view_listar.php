<?php 
    $pagina = isset($_GET['pag']) ? $_GET['pag'] : 1;
?>


<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Endereço
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-map"></i> &nbsp; Endereco </li>
        <li class="active">Lista de Endereços</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">


            <div class="col-ws-12 col-sm-12 col-lg-12">

                <div class="box box-danger"> 

                    <div class="box-body">

                        
                        <table id="example1" class="table table-bordered table-striped">
                            
                            <div class="row">
                            
                                <div class="col-sm-2 d-flex" style="margin: 5px 0;">
                                    <div class="form-group">
                                        <label for="per_page" class="label-form col-sm-5 font-normal">Mostrar:</label>
                                        <div class="col-sm-7">
                                            <select class="form-control" name="per_page" id="per_page" onchange="showing_per_page(1)">
                                                <option value="2">2</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-10 d-flex justify-content-end" style="margin: 5px 0;">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="cep_filter" class="label-form col-sm-3 font-normal">Cep:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="cep_filter" name="cep"  onblur="showRecord(1)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="cidade_filter" class="label-form col-sm-3 font-normal">Cidade:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="cidade_filter" name="cidade"  onkeyup="showRecord(1)">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            

                            <button id="btn-add-endereco" class="btn btn-danger" style="margin: 0 0 8px 0"><i class="fa fa-plus-square"></i></button>

                            <thead class="text-center">
                                <tr >
                                    <td>&nbsp;</td>
                                    <td>Rua</td>
                                    <td>Bairro</td>
                                    <td>Cidade</td>
                                    <td>Estado</td>
                                    <td>Cep</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </thead>

                            <tbody class="text-center" id="showData" >
                            </tbody>

                            

                        </table>

                        <!-- Mensagem de error Internal -->
                        <div id="mensagem-internal"></div>

                        <!-- Mensagem de sucesso -->
                        <div class="mensagem alert alert-success text-center" style="display:none"></div>

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
                        <div class="loading" style="display: none">
                            <div class="spinner" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div> 
                        <span style="color: #f00">* Campo Obrigatório</span>
                    </div>

                    <div class="error"></div>    

                    <div class="modal-body">
                        <form class="form-horizontal" id="myForm" action='' method="post">
                            <input type="hidden" name="id_endereco" id="id_endereco" value="0">
                            
                            <div class="form-group">
                                <label for="cep" class="col-sm-2 control-label">* CEP</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-validation" name="cep" id="cep" placeholder="CEP">
                                    <span class="help-block msg-cep"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rua" class="col-sm-2 control-label">* Rua</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-validation" name="rua" id="rua" placeholder="Rua">
                                    <span class="help-block msg-rua"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="bairro" class="col-sm-2 control-label">* Bairro</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-validation" name="bairro" id="bairro" placeholder="Bairro">
                                    <span class="help-block msg-bairro"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="cidade" class="col-sm-2 control-label">* Cidade</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-validation" name="cidade" id="cidade" placeholder="Cidade">
                                    <span class="help-block msg-cidade"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="estado" class="col-sm-2 control-label">* Estado</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input-validation" name="estado" id="estado" placeholder="Estado">
                                    <span class="help-block msg-estado"></span>
                                </div>
                            </div>

                            
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnSaveEnd" >Salvar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- / #myModal -->

        <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Excluir Endereço</h4>
                    </div>
                    <div class="modal-body">
                        Você tem certeza que deseja excluir esse Endereço?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" id="btnDeleteEnd" >Deletar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- / #myModal -->
      

        <!-- /.row -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->


<!-- <script src="<?= base_url('assets/js/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?= base_url('assets/js/fastclick/lib/fastclick.js') ?>"></script> -->
<script src="<?= base_url('assets/js/demo.js') ?>"></script>
<script src="<?= base_url('assets/js/main/endereco.js') ?>"></script>
