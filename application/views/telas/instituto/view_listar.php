<?php 
    $pagina = isset($_GET['pag']) ? $_GET['pag'] : 1;
?>

<link rel="stylesheet" href="<?= base_url('assets/js/datatables.net-bs/css/datatables.bootstrap.css') ?>">
 
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Instituto
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-bank"></i> &nbsp; Instituto </li>
        <li class="active">Lista de Instituições</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">


            <div class="col-ws-12 col-sm-12 col-lg-12">

                <div class="box box-danger"> 

                    <div class="box-body">

                        
                        <!-- Mensagem de sucesso -->
                        <div class="mensagem alert alert-success text-center mt-8" style="display:none" ></div>

                        <table id="tableInstituto" class="table table-bordered table-striped">

                            <thead class="text-center">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>Instiuição</td>
                                    <td>Rua</td>
                                    <td>Cidade</td>
                                    <td>Estado</td>
                                    <td>Ensino</td>
                                    <td>CNPJ</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </thead>

                            <tbody id="showData" >
                            </tbody>

                        </table>

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
                        <h4 class="modal-title">Alterar dados do Instituto</h4>

                        <span style="color: #f00">* Campo Obrigatório</span>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="myForm" action='' method="post">
                            <input type="hidden" name="id_inst" id="id_inst" value="0">
                            
                            <div class="form-group">
                                <label for="cnpj" class="col-sm-2 control-label">* CNPJ</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="cnpj" id="cnpj" disabled>
                                    <span class="help-block msg-cnpj"></span>
                                </div>
                                <button type="button" class="btn btn-primary" id="enable-cnpj" style="margin: 2px 0 0 0">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                
                                <button type="button" class="btn btn-primary" id="disabled-cnpj" style="margin: 2px 0 0 0">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>

                            
                            <div class="form-group">
                                <label for="instituto" class="col-sm-2 control-label">* Instituito</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="instituto" id="instituto">
                                    <span class="help-block msg-instituto"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="endereco" class="col-sm-2 control-label">* Endereço</label>

                                <div class="col-sm-6">
                                    <select name="endereco" id="endereco" class="form-control" style="width: 100%;">
                                        <option value=""></option>
                                    </select>
                                    <span class="help-block msg-endereco"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tipo_ensino" class="col-sm-2 control-label">* T. Ensino</label>

                                <div class="col-sm-5">
                                    <select name="tipo_ensino" id="tipo_ensino" class="form-control cursor-pointer">
                                        <option value="">Selecione</option>

                                        <option value="Ensino Fundamental" <?php echo set_select('tipo_ensino', "Ensino Fundamental") ?> >Ensino Fundamental</option>
                                        <option value="Ensino Médio" <?= set_select('tipo_ensino', 'Ensino Médio') ?> >Ensino Médio</option>
                                        <option value="Ensino Técnico" <?= set_select('tipo_ensino', 'Ensino Técnico') ?> >Ensino Técnico</option>
                                        <option value="Ensino Superior" <?= set_select('tipo_ensino', 'Ensino Superior') ?> >Ensino Superior</option>
                                    </select>
                                    <span class="help-block msg-tipo_ensino"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telefone" class="col-sm-2 control-label">* Telefone</label>

                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="telefone" id="telefone" placeholder="(00) 00000-0000" value="<?php echo set_value('telefone') ?>">
                                    <span class="help-block msg-telefone"></span>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnSave" >Salvar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- / #myModal -->

        <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Excluir Instituto</h4>
                    </div>
                    <div class="modal-body">
                        Você tem certeza que deseja excluir esse Endereço?
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


<script src="<?= base_url('assets/js/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<!-- <script src="<?= base_url('assets/js/jquery-slimscroll/jquery.slimscroll.min.js') ?>"></script>
<script src="<?= base_url('assets/js/fastclick/lib/fastclick.js') ?>"></script> -->
<script src="<?= base_url('assets/js/demo.js') ?>"></script>
<script src="<?= base_url('assets/js/main/instituto.js') ?>"></script>
