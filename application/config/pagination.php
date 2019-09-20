<?php


$config = [
    'num_links' => 2,
    'use_page_numbers' => TRUE,
    'reuse_query_string' => TRUE,
    'full_tag_open'   => "<ul class='pagination'>", //Tag open global
    'full_tag_close'  => "</ul'>", //tag close global
    'first_link'      => 'Primeiro', // Definindo que não haverá o link que trás os primeiros elementos da lista
    'last_link'       => 'Último', // Definindo que não haverá o link que trás os últimos elementos da lista
    'first_tag_open'  => '<li>', // tag open do link que trás os primeiro elementos da lista
    'first_tag_close' => '</li>', // tag close do link que trás os primeiro elementos da lista
    'last_tag_open'   => '<li>', // tag open do link que trás os últimos elementos da lista
    'last_tag_close'  => '</li>', // tag close do link que trás os últimos elementos da lista
    'prev_link'       => false, // Conteudo a ser exibido para o link de paginação que vai levar para página anterior
    'prev_tag_open'   => "<li class='prev'>", // tag open link anterior
    'prev_tag_close'  => "</li>", // tag close link anterior
    'next_link'       => false, // Conteudo a ser exibido para o link de paginação que vai levar para próxima página
    'next_tag_open'   => "<li class='prev'>", // tag open próxima página
    'next_tag_close'  => "</li>", // tag close próxima página
    'cur_tag_open'    => "<li class='active'><a style='pointer-events: none;'>", // tag open para a página da navegação ativa
    'cur_tag_close'   => "</a></li>", // tag close para a página da navegação ativa
    'num_tag_open'    => "<li>" , // tag open para os num digitos numéricos
    'num_tag_close'   => "</li>" , // tag close para os num digitos numéricos
];
                

