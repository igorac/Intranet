var url_atual = window.location.href;
url_atual = url_atual.substring(0,22);


$(document).ready(()=>{

    
    carregarPerfil(1); // Show the address

    // Clique da paginação
    $('#pagination').on('click', 'a', function(e){
        e.preventDefault();
        var pagina = $(this).attr('data-ci-pagination-page');
        carregarPerfil(pagina);
    });
    
    // Show modal Delete Perfil
    $('#showData').on('click', '.btn-deletar', function() {
        var id =  $(this).attr('data');
        var row = $(this).parent().parent();

        
        $('#modalDelete').find('.modal-title').text('Deletar Perfil');
        $('#modalDelete').modal('show');

         // off() -> Remove o handle dos eventos anteriores
        $('#btnDelete').off().on('click', function(){
            $.ajax({
                url: url_atual+'perfil/deletar',
                method: 'post',
                dataType: 'json',
                data: {id_perfil: id},
                success: function(response) {

                    console.log(response);
                    $('#modalDelete').modal('hide'); // Esconde o modal

                    if (response.sucesso) {
                        $('#mensagem').html('Perfil deletado com sucesso!').fadeIn().delay(2000).fadeOut('slow');
                        $(row).remove();
                        carregarPerfil(1); // Recarrega a tabela da primeira pagina
                    }
                    
                },
                error: function(error) {
                    console.log(error.responseText);
                    alert('Erro ao deletar');
                }
            });
        });
        
    });

    // Show modal Add Perfil
    $('#btn-add').on('click', function(e){
        $('#myModal').modal('show');
        $('#myModal').find('.modal-title').text('Adicionar Perfil');
        $('#myForm').attr('action', url_atual+'perfil/cadastrar');

        $('#perfil').val(''); // Evitar que o formulário venha com dados 
        $('#id_perfil').val(''); // Evitar que o formulário venha com dados 

        removeHasError(); // Remove a class has-error e dá um hide no span
    });

    // Show Modal Update e Consultar o elemento e retornar nos input do modal
    $('#showData').on('click', '.btn-edit', function(e){

        var id = $(this).attr('data');

        $('#myModal').modal('show');
        $('#myModal').find('.modal-title').text('Editar Perfil');
        $('#myForm').attr('action', url_atual+'perfil/alterar');

        removeHasError(); // Remove a class has-error e dá um hide no span

        // Responsável pela consulta dos dados
        $.ajax({
            url: url_atual+'perfil/buscarPorId',
            method: 'post',
            dataType: 'json',
            data: {id: id},
            success: function(response) {
                console.log(response);
                $('input[name=perfil]').val(response[0].perfil);
                $('input[name=id_perfil]').val(response[0].id_perfil);
            },
            error: function(error) {
                console.log(error.responseText);
                alert('Erro ao tentar editar o perfil');
            }
        });
    });

    // Evitar o envio do formulário de apenas 1 campo, ao pressionar a tecla Enter
    $('#myModal').on('keypress', function(e){
        if (e.keyCode === 13) {
            e.preventDefault();
            $(this).trigger('submit');
        }
    });

    // Edita/Salva o Perfil
    $('#btnSave').on('click', function(){
        var url = $('#myForm').attr('action');
        var data = $('#myForm').serialize();

     
        $.ajax({
            url: url,
            method: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {
                $('#mensagem').empty();

                if (response.sucesso) {
                    $('#myModal').modal('hide');
                    

                    if (response.tipo == 'update') {
                        var tipo = 'alterado';
                    } else if (response.tipo == 'adicionar') {
                        var tipo = 'adicionado';
                    }

                    $('#mensagem').html('Perfil '+tipo+' com sucesso!').fadeIn().delay(2000).fadeOut('slow');

                    carregarPerfil(1);
                } else {

                    if (response.errors) {
                        
                        validErrosCodeIgniter(response.errors);
    
                        if (response.errors.id_perfil) {
                            alert('[ERROR] Não existe esse Identificador na base de dados.');
                        }
                    }

                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Erro Interno! O problema deve ser resolvido em Breve');
            }
        });
        
    });

});

// Responsável pela remoção da classe has-error e hide
function removeHasError() {
    var fields = [$('#perfil')];

    for(let field of fields) {
        $(field).parent().parent().removeClass('has-error');
        var spanElement = $(field)[0].nextElementSibling;
        $(spanElement).hide('');
        $(spanElement).html('');
    }
}

/**
 * Responsável pela validação de erros do codeigniter
 * @param {object} response 
 */
function validErrosCodeIgniter(response) {

    var perfil = $('#perfil');
    
    if (response.perfil) {
        $(perfil).parent().parent().addClass('has-error');
        $('.msg-perfil').html(response.perfil);
        $('.msg-perfil').show('');
    } else {
        $(perfil).parent().parent().removeClass('has-error');
        $('.msg-perfil').html('');
        $('.msg-perfil').hide('');
    }
    
    
}

/**
 * Responsável por criar a tabela
 * @param {object} result 
 */
function create_table(result) {
    $('#showData').empty();

    for(i in result) {
        $('#showData').append("<tr><td class='w-1'>"+result[i].id_perfil+"</td><td>"+result[i].perfil+"</td><td>"+result[i].data_cadastro+"</td><td class='w-n'><a href='javascript:;' class='btn btn-primary btn-edit' style='margin: 0 4px 0 5px;' data="+result[i].id_perfil+"><i class='fa fa-pencil'></i></a><a href='javascript:;' class='btn btn-danger btn-deletar' data="+result[i].id_perfil+"><i class='fa fa-trash'></i></a></td></tr>")
    }
}


/**
 * Responsável por realizar a consulta dinâmica via input com onchange
 * @param {int} pag 
 */
function carregarPerfil(pag) {

    var search = $.trim($('#search').val());
    var per_page = $('#per_page').val();

    $.ajax({
        url: url_atual+'perfil/listar/'+pag,
        type: 'POST',
        dataType: 'json',
        data: {
            'search': search, 
            'per_page': per_page
        },
        success: (response)=> {
            create_table(response.perfils);
            $('#pagination').html(response.pagination);

            if (response.mensagem) {
               $('#mensagem').removeClass('alert-success').addClass('alert-danger').text(response.mensagem).show();
            }
        },
        error: (error)=> {
            console.log(error.responseText);
        }
    });
}

 
/**
 * Responsável por alterar o per_page(limit) dinamicamente
 * @param {int} page 
 */
function showing_per_page(page) {
    var limite = $('#per_page').val();
    var search = $.trim($('#search').val());
   
    $.ajax({
        url: url_atual+'perfil/listar/'+page,
        method: 'post',
        dataType: 'json',
        data: {'per_page': limite, 'search': search},
        success: function(response) {

            create_table(response.perfils);
            $('#pagination').html(response.pagination);
        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}
