var url_atual = window.location.href;
url_atual = url_atual.substring(0,22);


$(function(){

    showRecord(1); // Show Records
    // buscaPaises(); // Consulta a api de países da América do SUL

    // Show Modal Add
    $('#btn-add-endereco').on('click', function(){

        $('#myModal').modal('show');
        $('#myModal').find('.modal-title').text('Adicionar Endereço');
        $('#myForm').attr('action', url_atual+'endereco/cadastrar'); 
        $('#myForm')[0].reset();

        removeHasError(); // Responsável por remover has-error
    });

    // Show Modal Update e Consultar o elemento e retornar nos input do modal
    $('#showData').on('click', '.btn-edit', function(e){
        console.log($(this).attr('data'));

        var id_endereco = $(this).attr('data');
        $('#myModal').modal('show');
        $('#myModal').find('.modal-title').text('Editar Endereço');
        $('#myForm').attr('action', url_atual+'endereco/alterar');

        removeHasError(); // Responsável por remover has-error

        $.ajax({
            url: url_atual+'endereco/buscarPorId',
            method: 'post',
            dataType: 'json',
            data: {id_endereco: id_endereco},
            success: function(response) {
                
                console.log(response.endereco[0]);

                $('#cep').val(response.endereco[0].cep);          
                $('#rua').val(response.endereco[0].rua);          
                $('#bairro').val(response.endereco[0].bairro);          
                $('#cidade').val(response.endereco[0].cidade);          
                $('#estado').val(response.endereco[0].estado);          
                $('#id_endereco').val(response.endereco[0].id_endereco);
             
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        })
    });

    // Show Modal Delete
    $('#showData').on('click', '.btn-delete', function(e){
        var id_endereco = $(this).attr('data');
        var row         = $(this).closest('tr');
       
        $('#modalDelete').modal('show');
        // off() -> Remove o handle dos eventos anteriores
        $('#btnDeleteEnd').off().on('click', function(e){
            $.ajax({
                url: url_atual+'endereco/deletar',
                method: 'post',
                dataType: 'json',
                data: {id_endereco: id_endereco},
                success: function(response) {
                    
                    if (response.sucesso) {
                        $(row).remove();
                        //$('#mensagem').html('Endereço deletado com sucesso!').fadeIn().delay(2000).fadeOut('slow');
                        $('.mensagem').text('Endereço Deletado com sucesso').addClass('alert-success').removeClass('alert-danger').fadeIn().delay(2000).fadeOut('slow', function(){
                            showRecord(1); // Carrega os dados
                        });
                        
                    } else {
                        $('#mensagem-internal').text('[ERROR] Existem dados utilizando esse endereço!').addClass('alert alert-warning text-center').fadeIn().delay(3000).fadeOut('slow');

                    }
                    $('#modalDelete').modal('hide');
                   
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('[ERROR] Existem dados utilizando esse endereço!');
                    $('#modalDelete').modal('hide');
                   // console.log(jqXHR.responseText);
                }
            });
        });
        
    });

    // Edita/Salva o Endereço
    $('#myModal').on('click', '#btnSaveEnd', function(){
        
        var data = $('#myForm').serialize();
        var URL = $('#myForm').attr('action');
        
        $.ajax({
            url: URL,
            method: 'post',
            dataType: 'json',
            data: data,
            success: function(response) {

                $('.mensagem').empty();

                if (response.sucesso) {
                    $('#myModal').modal('hide');
                    $('.mensagem').append('<div class="alert alert-success text-center">'+response.messages+'</div>').fadeIn().delay(2000).fadeOut('slow');

                    showRecord(1); // Show records
                } else {
                    if (response.messagesFormValidation) {
                        validErrosCodeIgniter(response.messagesFormValidation);

                    } else if (response.messages) {
                        $('#myModal').modal('hide');
                        $('.mensagem').append('<div class="alert alert-warning text-center">'+response.messages+'</div>').fadeIn().delay(2000).fadeOut('slow');
                    }
                }
                
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                //alert('Erro ao tentar Cadastrar');
                console.log(jqXHR.responseText);
            }
        });

    });

    // Consulta a api CEP
    $("#cep").blur(function() {

        var cepRegex = $(this).val().replace(/\D/g, '');
        

        //Verifica se campo cep possui valor informado.
        if (cepRegex != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cepRegex)) {


                $('.loading').show('fast',function(){
                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cepRegex +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            var cep = $('#cep');
                            var rua = $("#rua");
                            var bairro = $("#bairro");
                            var cidade = $("#cidade");
                            var estado = $("#estado");

                            $(cep).val(cepRegex);
                            $(rua).val(dados.logradouro);
                            $(bairro).val(dados.bairro);
                            $(cidade).val(dados.localidade);
                            $(estado).val(dados.uf);

                            removeHasError(); // Responsável pela remoção da classe has-error/hide e texto do span


                            

                        } else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });

                    $('.loading').fadeOut("slow");
                })

                
            } else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }

        } else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });

    // Responsável pelo clique da paginação
    $('#pagination').on('click', 'a', function(e) {
        var pagina = $(this).attr('data-ci-pagination-page');
        showRecord(pagina);
        e.preventDefault();
    });

    // Quando o input CEP receber focus, os campos serão apagados.
    $('#cep').on('focus', function(){
        $('#myForm')[0].reset();
    });
 
})

/**
 * Responsável pela exibição dos errors do codeIgniter
 * @param {object} response 
 */
function validErrosCodeIgniter(response) {

    if (response.cep){
        $('#cep').parent().parent().addClass('has-error');
        var spanElement = $('#cep')[0].nextElementSibling;
        $(spanElement).show('fast');
        $(spanElement).html(response.cep);
    } else {
        $('#cep').parent().parent().removeClass('has-error');
        var spanElement = $('#cep')[0].nextElementSibling;
        $(spanElement).hide('fast');
        $(spanElement).html('');
    }

    
    if (response.rua){
        $('#rua').parent().parent().addClass('has-error');
        var spanElement = $('#rua')[0].nextElementSibling;
        $(spanElement).show('fast');
        $(spanElement).html(response.rua);
    } else {
        $('#rua').parent().parent().removeClass('has-error');
        var spanElement = $('#rua')[0].nextElementSibling;
        $(spanElement).hide('fast');
        $(spanElement).html('');
    }


    if (response.bairro){
        $('#bairro').parent().parent().addClass('has-error');
        var spanElement = $('#bairro')[0].nextElementSibling;
        $(spanElement).show('fast');
        $(spanElement).html(response.bairro);
    } else {
        $('#bairro').parent().parent().removeClass('has-error');
        var spanElement = $('#bairro')[0].nextElementSibling;
        $(spanElement).hide('fast');
        $(spanElement).html('');
    }


    if (response.cidade){
        $('#cidade').parent().parent().addClass('has-error');
        var spanElement = $('#cidade')[0].nextElementSibling;
        $(spanElement).show('fast');
        $(spanElement).html(response.cidade);
    } else {
        $('#cidade').parent().parent().removeClass('has-error');
        var spanElement = $('#cidade')[0].nextElementSibling;
        $(spanElement).hide('fast');
        $(spanElement).html('');
    }



    if (response.estado){
        $('#estado').parent().parent().addClass('has-error');
        var spanElement = $('#estado')[0].nextElementSibling;
        $(spanElement).show('fast');
        $(spanElement).html(response.estado);
    } else {
        $('#estado').parent().parent().removeClass('has-error');
        var spanElement = $('#estado')[0].nextElementSibling;
        $(spanElement).hide('fast');
        $(spanElement).html('');
    }

}

// Responsável pela remoção da classe has-error e hide
function removeHasError() {
    var fields = [$('#cep'), $('#rua'), $('#bairro'), $('#cidade') , $('#estado')];

    for(let field of fields) {
        $(field).parent().parent().removeClass('has-error');
        var spanElement = $(field)[0].nextElementSibling;
        $(spanElement).hide('');
        $(spanElement).html('');
    }
}


// Limpa os values do formulário CEP
function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    $("#rua").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#estado").val("");
}

/**
 * Exibir os dados do banco de dados
 * @param {int} pagina 
 */
function showRecord(pagina) {
    var cep    = $('#cep_filter');
    var cidade = $('#cidade_filter');
    var per_page = $('#per_page').val();

    var cepRegex = $(cep).val().replace(/\D/g, ''); // Retira a máscara do input
    $(cep).val(cepRegex);

    if ($(cep).val() != '') {
        var cep_valor = $.trim($(cep).val());
    }
    
    if ($(cidade).val() != '') {
        var cidade_valor = $.trim($(cidade).val());
    }

    $.ajax({
        url: url_atual+'endereco/exibir/'+pagina,
        method: 'post',
        dataType: 'json',
        data: {cep: cep_valor, cidade: cidade_valor, per_page: per_page},
        success: function(response) {
            if (response.enderecos) {
                createTable(response.enderecos);
            }
           
            $('#pagination').html(response.pagination);
            
            // $('#mensagem-vazio').empty();
            if (response.mensagem) {
                // Mensagem de error (Está Vazio)
                //$('#mensagem-vazio').append('<div class="alert alert-danger text-center">'+response.mensagem+'</div>') 
                $('.mensagem').addClass(' alert-danger').removeClass('alert-success').text(response.mensagem).show();
            } else {
                $('.mensagem').hide();
            }

            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        }
    });
}

/**
 * Exibir os dados de acordo com o limite (per_page)
 * @param {int} pagina 
 */
function showing_per_page(pagina) {
    var cep    = $('#cep_filter');
    var cidade = $('#cidade_filter');
    var per_page = $('#per_page').val();

    var cepRegex = $(cep).val().replace(/\D/g, ''); // Retira a máscara do input
    $(cep).val(cepRegex);
    

    if ($(cep).val() != '') {
        var cep_valor = $.trim($(cep).val());
    }
    
    if ($(cidade).val() != '') {
        var cidade_valor = $.trim($(cidade).val());
    }


    $.ajax({
        url: url_atual+'endereco/exibir/'+pagina,
        method: 'post',
        dataType: 'json',
        data: {cep: cep_valor, cidade: cidade_valor, per_page: per_page},
        success: function(response) {


            if (response.enderecos) {
                createTable(response.enderecos);
            }

            $('#pagination').html(response.pagination);

            
            if (response.mensagem) {
                //$('#mensagem-vazio').removeClass('alert-success').addClass('alert-danger').text(response.mensagem).show();
                //$('#mensagem-vazio').append('<div class="alert alert-danger text-center">'+response.mensagem+'</div>') 
                $('.mensagem').addClass('alert-danger').remove('alert-success').text(response.mensagem).show();
            } else {
                $('.mensagem').hide();
            }
            
            
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
        }
    })
}

/**
 * Cria a tabela / Renderiza a tabela com os dados
 * @param {object} response 
 */
function createTable(response) {
    $('#showData').empty();
    
    for(let data of response) {
        $('#showData').append('<tr><td class="w-1">'+data.id_endereco+'</td><td>'+data.rua+'</td><td>'+data.bairro+'</td><td>'+data.cidade+'</td><td>'+data.estado+'</td><td style="width: 70px;">'+data.cep+'</td><td style="width:100px;"><a href="javascript:;" class="btn btn-primary btn-edit" data='+data.id_endereco+'><i class="fa fa-pencil"></i></a> <a href="javascript:;" class="btn btn-danger btn-delete" data='+data.id_endereco+'><i class="fa fa-trash"></i></a></td></tr>')
    }
}






// Monta um select de países
/*
function montarSelectPaises(response) {
    var selectElement = $('#pais');
    
    for(pais of response) {
        selectElement.append('<option value='+pais.nativeName+'>'+pais.nativeName+'</option>');
    }
}
*/

// Realiza a consulta na api
/*
function buscaPaises() {
    $.ajax({
        url: 'https://restcountries.eu/rest/v2/regionalbloc/USAN',
        method: 'get',
        dataType: 'json',
        success: function(response) {
            montarSelectPaises(response)
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}
*/





