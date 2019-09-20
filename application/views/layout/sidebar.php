<?php 
    defined('BASEPATH') OR exit('URL inválida.');

    $ativa = isset($ativa) ? $ativa : '';
    // $dadosPerfil = isset($profile) ? $profile : '';
    // $dadosPerfil = $profile ?? null;
    $profile = $profile ?? '';
?>

<aside class="main-sidebar">


<section class="sidebar">

  <div class="user-panel">
    <div class="pull-left image">
        <?php if (isset ($profile) && !is_null($profile->IMAGEM) ) { ?>
            <img src="<?= base_url('assets/upload/160px/'.$profile->IMAGEM) ?>" class="img-circle" alt="User Image">
        <?php } else { ?>
            <img src="<?= base_url('assets/images/default.png') ?>" class="img-circle" alt="User Image">
        <?php } ?>    
    </div>
    <div class="pull-left info">
      <p><?= $profile->NOME ?></p>
      <!-- Status -->
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>

  <!-- search form (Optional) -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
    </div>
  </form>
  <!-- /.search form -->

  <!-- Sidebar Menu -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">HEADER</li>
   
    <li class="treeview <?php if ($ativa === 'perfil') {echo ' active';}?>">
      <a href="#">
        <i class="fa fa-id-badge"></i>
        <span>Perfil</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?= site_url('perfil/listar') ?>"><i class="fa fa-circle-o"></i> Listar </a></li>
      </ul>
    </li>

    <li class="treeview <?php if ($ativa === 'endereco') {echo ' active';}?>">
      <a href="#">
        <i class="fa fa-map"></i>
        <span>Endereço</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?= site_url('endereco/listar') ?>"><i class="fa fa-circle-o"></i> Listar </a></li>
      </ul>
    </li>

    <li class="treeview <?php if ($ativa === 'instituto') {echo ' active';}?>">
      <a href="#">
        <i class="fa fa-bank"></i>
        <span>Instituto</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?= site_url('instituto/cadastrar') ?>"><i class="fa fa-circle-o"></i> Cadastrar </a></li>
        <li><a href="<?= site_url('instituto/listar') ?>"><i class="fa fa-circle-o"></i> Listar </a></li>
      </ul>
    </li>

    <li class="treeview <?php if ($ativa === 'usuario') {echo ' active';}?>">
      <a href="#">
        <i class="fa fa-user"></i>
        <span>Usuario</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?= site_url('usuario/listar') ?>"><i class="fa fa-circle-o"></i> Listar </a></li>
      </ul>
    </li>

    <li class="treeview <?php if ($ativa === 'mailbox') {echo ' active';}?>">
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span>Mailbox</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="<?= site_url('mensagem/view_caixaEntrada') ?>"><i class="fa fa-circle-o"></i> Caixa de Entrada </a></li>
        <!-- <li><a href="<?= site_url('mensagem/view_listarMensagens') ?>"><i class="fa fa-circle-o"></i> Caixa de Entrada </a></li> -->
        <li><a href="<?= site_url('mensagem/enviarMensagem') ?>"><i class="fa fa-circle-o"></i> Enviar </a></li>
      </ul>
    </li>


    <li class=""><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>
    <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
    <li class="treeview">
      <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="#">Link in level 2</a></li>
        <li><a href="#">Link in level 2</a></li>
      </ul>
    </li>
  </ul>
  <!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>