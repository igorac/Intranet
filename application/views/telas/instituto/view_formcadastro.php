<link rel="stylesheet" href="<?= base_url('assets/js/datatables.net-bs/css/datatables.bootstrap.css') ?>">

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Cadastro de Instituto
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-bank"></i> &nbsp;  Instituto </li>
        <li class="active">Cadastro de Instituto</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">

        <div class="col-ws-12 col-sm-12 col-lg-12">

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Informe os dados</h3>
                    <p class="text-danger">* Campos Obrigatórios</p>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form role="form" class="form-horizontal" action="<?php echo site_url('instituto/cadastrar') ?> " method="post">

                        <div class="form-group">
                            <label for="cnpj" class="col-sm-2 control-label">* CNPJ</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ" value="<?php echo set_value('cnpj') ?>">
                                <?php echo form_error('cnpj'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="instituto" class="col-sm-2 control-label">* Instituto</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="instituto" id="instituto" placeholder="Instituto" value="<?php echo set_value('instituto') ?>">
                                <?php echo form_error('instituto'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="endereco" class="col-sm-2 control-label">* Endereço</label>
                            <button id="btn-add-endereco" type="button" class="btn btn-danger" style="margin: 3px 0 0 0;">
                                <i class="fa fa-plus-square"></i>
                            </button>

                            <div class="col-sm-4">
                                <select name="endereco" id="endereco" class="form-control">
                                    <option value=""></option>
                                </select>
                                <?php echo form_error('endereco'); ?>
                            </div>
                        </div>
                       

                        <div class="form-group">
                            <label for="tipo_ensino" class="col-sm-2 control-label">* Tipo de Ensino</label>

                            <div class="col-sm-3">
                                <select name="tipo_ensino" id="tipo_ensino" class="form-control cursor-pointer">
                                    <option value="">Selecione</option>
                                    <option value="Ensino Fundamental" <?php echo set_select('tipo_ensino', "Ensino Fundamental") ?> >Ensino Fundamental</option>
                                    <option value="Ensino Médio" <?= set_select('tipo_ensino', 'Ensino Médio') ?> >Ensino Médio</option>
                                    <option value="Ensino Técnico" <?= set_select('tipo_ensino', 'Ensino Técnico') ?> >Ensino Técnico</option>
                                    <option value="Ensino Superior" <?= set_select('tipo_ensino', 'Ensino Superior') ?> >Ensino Superior</option>
                                </select>
                                <?php echo form_error('tipo_ensino'); ?>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="telefone" class="col-sm-2 control-label">* Telefone</label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="telefone" id="telefone" placeholder="(00) 00000-0000" value="<?php echo set_value('telefone') ?>">
                                <?php echo form_error('telefone'); ?>
                            </div>
                        </div>

                      
                        <div class="form-group">
                            <div class="col-ws-12 col-sm-9 col-lg-9">
                                &nbsp;
                            </div>
                            <div class="col-ws-12 col-sm-12 col-lg-3">
                                <button type="submit" class="btn btn-danger" style="width: 100%;">Cadastrar Instituto</button>
                            </div>
                        </div>
                        
                    </form> 

                    <?php if (isset($sucesso)) { ?>

                        <?php if ($sucesso) { ?> 
                            <div class="alert alert-success text-center alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Cadastrado com sucesso!
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-danger text-center alert-dismissible"> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Erro ao cadastrar!
                            </div> 
                        <?php } ?>
                       

                    <?php } ?>

                    
                </div>
                <!-- ./box-body -->  

            </div>
            <!-- /.box box-warning -->
 
        </div>
        <!-- /.col-md-6 --> 

        </div>  
        <!-- /.row -->
    </section>
    <!-- /.content -->


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
                    <button type="button" class="btn btn-primary" id="btnSave" >Salvar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- / #myModal -->

</div>
<!-- /.content-wrapper -->


<script src="<?= base_url('assets/js/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/js/main/instituto.js') ?>"></script>