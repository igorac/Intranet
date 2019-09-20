<?php 
    defined('BASEPATH') OR exit('URL inválida.');
    $habilidades = (!is_null($profile->HABILIDADE)) ? explode(",", $profile->HABILIDADE) : '';
?>

    <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-danger">
            <div class="box-body box-profile">

              <?php if (isset($profile) && !is_null($profile->IMAGEM)) { ?>
                <img src="<?= base_url('assets/upload/160px/'.$profile->IMAGEM) ?>" class="profile-user-img img-responsive img-circle img" alt="User Image">
              <?php } else { ?>
                <img src="<?= base_url('assets/images/default.png') ?>" class="profile-user-img img-responsive img-circle img" alt="User Image">
              <?php } ?>

              
             
              <h3 class="profile-username text-center"><?= $profile->NOME ?></h3>

              <p class="text-muted text-center"><?= $profile->PERFIL ?? ''; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn btn-danger btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Sobre min</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Educação</strong>

              <p class="text-muted">
                <?= $profile->NOME_INSTITUTO ?? '<p class="text-muted"> Não possui uma educação registrada.</p> ';  ?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Localização</strong>

              <?php if (isset($profile->CIDADE) && !empty($profile->CIDADE)) { ?>
                <p class="text-muted"><?= $profile->CIDADE ?? ''; ?>, <?= $profile->ESTADO ?? ''; ?></p>
              <?php } else { ?>  
                <p class="text-muted">Não possui uma localização registrada</p>
              <?php } ?>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Habilidades</strong>

              <p>
                <?php if (is_array($habilidades)) { ?>
                  <?php foreach($habilidades as $habilidade) { ?>
                    <span class="label label-danger"><?= $habilidade ?></span>
                  <?php } ?>
                <?php } else { ?>
                  <p class="text-muted">Não possui habilidade(s).</p>
                <?php } ?>
              </p>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">

              <div class="active tab-pane" id="settings">
                  <!-- imagem -->
                     <!-- Profile Image -->
                    <div class="box box-danger">
                        <div class="box-body box-profile text-center ">
                            <form enctype="multipart/form-data" id="formImagem" action="" method="POST">

                                <!-- Utilizando JS para alterar a imagem -->
                                <!-- <img class="profile-user-img img-responsive img-circle img"src="<?= base_url('assets/images/default.png') ?>" alt="User profile picture"> -->
                                
                                <?php if (isset($profile) && !is_null($profile->IMAGEM)) { ?>
                                  <img src="<?= base_url('assets/upload/160px/'.$profile->IMAGEM) ?>" class="profile-user-img img-responsive img-circle img" id="img-profile"  alt="User Image" >
                                <?php } else { ?>
                                  <img src="<?= base_url('assets/images/default.png') ?>" class="profile-user-img img-responsive img-circle img"  id="img-profile"  alt="User Image">
                                <?php } ?>

                                <div class="container-botoes-upload">
                                  <label for="upload" class="btn btn-danger file-btn">Upload</label>
                                  <input type="file" name="imagem" id="upload">
                                  <button type="button" class="btn btn-danger" id="btn-alterar-imageProfile">Alterar</button>
                                </div>
                                
                                <span class="help-block msg-imagem" style="display: none"></span>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                  <!-- /imagem -->

                <form class="form-horizontal" id="myFormEditProfile" action="" method="post">
                  <div class="form-group">
                    <label for="nome" class="col-sm-2 control-label">Nome</label>
                    
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="">
                      <span class="help-block msg-nome" style="display: none"></span>
                    </div>
      
                  </div>
                  
              
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Perfil</label>
                      <div class="col-sm-4">
                        <select name="id_perfil" id="perfil" class="form-control">
                            <option value="">Selecione</option>
                           
                        </select>
                      </div>
                    </div>
                  


                 
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Endereço</label>
                      <div class="col-sm-4">
                        <select name="id_endereco" id="endereco" class="form-control">
                            <option value="">Selecione</option>
                         
                        </select>
                      </div>
                    </div>
                  
 

                
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Instituto</label>
                      <div class="col-sm-4">
                        <select name="id_instituto" id="instituto" class="form-control">
                            <option value="">Selecione</option>
                        </select>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-sm-2 control-label">Habilidades</label>
                      <div class="col-sm-10">
                        <select class="seletorSkills" id="habilidades" name="habilidades[]" multiple="multiple" style="width: 50%">
                            <?php if (isset($skills)) { ?>
                                <?php foreach($skills as $skill) { ?>
                                    <option value="<?= $skill['id'] ?>"> <?= $skill['value']?></option>
                                <?php } ?>
                            <?php } ?> 
                        </select>
                        <button type="button" class="btn btn-danger" id="btn-add-habilidade"><i class="fa fa-plus-square"></i></button>
                      </div>
                    </div>

                 

                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nacionalidade</label>
                      <div class="col-sm-4">
                        <select name="nacionalidade" id="nacionalidade" class="form-control">
                            <option value="">Selecione</option>
                            <?php if (isset($nacionalidades)) { ?>
                                <?php foreach($nacionalidades as $nacionalidade) { ?>
                                    <option value="<?= $nacionalidade['nome'] ?><?= '('.$nacionalidade['code'].')' ?>"> <?= $nacionalidade['nome']?> <?= '('.$nacionalidade['code'].')' ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                      </div>
                    </div>
                  


                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="button" class="btn btn-danger btn-edit-profile">Atualizar Perfil</button>
                      <button type="button" class="btn btn-danger btn-edit-senha">Atualizar Senha</button>
                      <button type="button" class="btn btn-danger btn-edit-email">Atualizar Email</button>
                    </div>
                  </div>

                </form>

                

              </div>
              <!-- /.tab-pane -->
            </div>

            <div id="mensagem" class="alert alert-success text-center" style="display:none"></div>


            <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Adicionar Habilidade</h4>
                      
                      <span style="color: #f00">* Campo Obrigatório</span>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="myForm" action='' method="post">
                            <input type="hidden" name="id_inst" id="id_inst" value="0">
                            
                            <div class="form-group">
                                <label for="cnpj" class="col-sm-3 control-label">* Habilidade</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="habilidade" id="habilidade">
                                  <span class="help-block msg-habilidade" style="display:none;"></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                      <button type="button" class="btn btn-danger" id="btnSaveHabilidade" >Salvar</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="modalSenha" class="modal fade" tabindex="-1" role="dialog">
              
                <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Alterar Senha</h4>
                        
                        <span style="color: #f00">* Campo Obrigatório</span>
                      </div>

                      <div class="modal-body">
                          <form class="form-horizontal" id="myFormSenha" action='' method="post">
                              <div class="form-group">
                                  <label for="senhaAntiga" class="col-sm-3 control-label">* Senha</label>
                                  <div class="col-sm-8">
                                    <input type="password" class="form-control" name="senhaAntiga" id="senhaAntiga">
                                    <span class="help-block msg-antigasenha"></span>
                                  </div>
                              </div>
                             
                          
                              <div class="form-group">
                                  <label for="novaSenha" class="col-sm-3 control-label">* Nova Senha</label>
                                  <div class="col-sm-8">
                                    <input type="password" class="form-control" name="novaSenha" id="novaSenha">
                                    <span class="help-block msg-novasenha"></span>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="confsenha" class="col-sm-3 control-label">* Confirmar Senha</label>
                                  <div class="col-sm-8">
                                    <input type="password" class="form-control" name="confsenha" id="confsenha">
                                    <span class="help-block msg-confsenha"></span>
                                  </div>
                              </div>

                          </form> 
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-danger" id="btnEditSenha">Salvar</button>
                      </div>
                  </div>
                </div>
               
            </div>

            <div id="modalEmail" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Alterar Email</h4>
                      
                      <span style="color: #f00">* Campo Obrigatório</span>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="myFormEmail" action='' method="post">
                            
                            
                            <div class="form-group">
                                <label for="novoEmail" class="col-sm-3 control-label">* Novo Email</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="novoEmail" id="novoEmail">
                                  <span class="help-block msg-novoemail"></span>
                                </div>
                                
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                      <button type="button" class="btn btn-danger" id="btnEditEmail">Salvar</button>
                    </div>
                </div>
              </div>
            </div>


            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>


  <script src="<?= base_url('assets/js/main/usuario.js') ?>"></script>