var url_atual = window.location.href;
url_atual = url_atual.substring(0,22);
var tableInstituto;

$(function(){

    //buscaPaises(); // Consulta a API

    //buscarEnderecos(); // Consulta os endereços do banco de dados

    $('#telefone').mask('(00) 00000-0000'); // Mask phone utilizando jquery mask
    $('#cnpj').mask("99.999.999/9999-99"); // Mask cnpj utilizando jquery mask


    $('#enable-cnpj').on('click', function(){
        enabledCNPJ();
    });

    $('#disabled-cnpj').on('click', function(){
        disabledCNPJ();
    });

    // Select2 Utilizado com o select Endereço
    $('#endereco').select2({
        placeholder: 'Selecione',
        ajax: {
            url: url_atual+'endereco/consultarEndereco',
            type: 'post',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                console.log(response);
                var res = [];
                for(var i  = 0 ; i < response.length; i++) {
                    res.push({id:response[i].id_endereco, text:response[i].rua+' ('+response[i].id_endereco+')'});
                }

                return {
                    results: res
                }
               
            },
            cache: true,
           
        }
       
    });

    // Show modal de adicionar Endereço
    $('#btn-add-endereco').on('click', function(e){
        $('#myModal').modal('show');
        $('#myModal').find('.modal-title').text('Cadastrar Endereço');
       
        $('#myForm').attr('action', url_atual+'endereco/cadastrar');
        $('#myForm')[0].reset(); // Responsável por limpar os campos

        removeHasErrorAndSuccessEnd(); // Remove os has-error e has-success e hide span Text
        
    });

    // Save / Edit Instituto
    $('#myModal').on('click', '#btnSave', function(e){
        var form = $('#myForm');

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            dataType: 'json',
            data: form.serialize(),
            success: function(response) {
                console.log(response);
                
                if (response.sucesso) {
                    $('.mensagem').text(response.mensagem).addClass('alert-success').removeClass('alert-warning').fadeIn().delay(2000).fadeOut('slow');
                    $('#myModal').modal('hide');

                    tableInstituto.ajax.reload(null, false); // Faz o realod / Refresh na table
                } else {
                    if (response.messagesFormValidation) {
                        validErrosCodeIgniterEndereco(response.messagesFormValidation);
                    } else if (response.messagesFormValidationInsti) {
                        validErrosCodeIgniterInstituto(response.messagesFormValidationInsti);
                    } else if (response.mensagem) {
                        $('.mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut('slow');
                        $('#myModal').modal('hide');
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
                if (jqXHR.status === 500) {
                    alert('[ERROR] Problema interno, o prolema deve ser resolvido em breve, Aguarde!');
                } 
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

                            removeHasErrorAndSuccessEnd(); // Responsável pela remoção da classe has-error/hide e texto do span
                            

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

    // DataTables
    tableInstituto = $('#tableInstituto').DataTable({
        ajax: url_atual+'instituto/exibirTodos',
        order: [[0, "desc"]],
        columnDefs: [
            {
                "render": function(data, type, row) {
                    return '<a href="javascript:;" class="btn btn-primary editar-inst mr-2" data='+row[0]+'><i class="fa fa-pencil"></i></a>'+
                           '<a href="javascript:;" class="btn btn-danger  deletar-inst" data='+row[0]+'><i class="fa fa-trash"></i></a>'
                },
                "targets": 7
            }
        ],
        language: {
            "paginate": {
                "next": "&gt;",
                "previous": "&lt;",
            },

            "lengthMenu": "Mostrar _MENU_ registros por páginas",
            "zeroRecords": "Não foi encontrado nenhum registro na base de dados",
            "info": "Mostrando _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "infoFiltered": "(Filtrado de _MAX_ de registros total)",
            "search": "Buscar: _INPUT_"
        }
    });

    // Edit modal Show e FindByID instituto
    $('#tableInstituto').on('click', '.editar-inst', function(){
        let id_inst = $(this).attr('data');
        
        
        $('#myModal').modal('show');
        $('#myForm').attr('action', url_atual+'instituto/alterar');

        removeHasErrorAndSuccessInsti(); // Responsável por remover os vestígios de erros e sucesso

        disabledCNPJ(); // Responsável por startar o modal edit com o campo  CNPJ como disabled
       
        

        $.ajax({
            url: url_atual+'instituto/consultarPorId',
            method: 'POST',
            dataType: 'JSON',
            data: {id_inst: id_inst},
            success: function(response) {
                console.log(response);

                if (response.sucesso) {


                    $('#id_inst').val(response.instituto[0].id_instituto);
                    $('#cnpj').val(response.instituto[0].cnpj);
                    $('#instituto').val(response.instituto[0].nome_instituto);
                    $('#tipo_ensino').val(response.instituto[0].tipo_ensino);
                    $('#telefone').val(response.instituto[0].telefone);

                    // Traz o valor do select do banco de dados para select2
                    var $option = $("<option selected></option>").val(response.instituto[0].id_endereco).text(response.instituto[0].rua+' ('+response.instituto[0].id_endereco+')');
                    $('#endereco').append($option).trigger('change');

                } else {
                    alert('[ERROR] não existe esse dado na base de dados.');
                }
            },
            error: function(error) {
                console.log(error.responseText);
                alert('[ERROR] Erro interno, aguarde que em breve o problema vai ser solucionado.');
            }
        })
    });

    // Delet modal show e Delete Instituto
    $('#tableInstituto').on('click', '.deletar-inst', function(){
       
        var id_inst = $(this).attr('data');
        var row = $(this.closest('tr'));
        

        $('#modalDelete').modal('show');
        $('.help-block').hide();


        $('#btnDelete').off().on('click', function(e){

            $.ajax({
                url: url_atual+'instituto/deletar',
                method: 'POST',
                dataType: 'JSON',
                data: {id_inst: id_inst},
                success: function(response) {
                    console.log(response);

                    if (response.sucesso) {
                        $(row).remove();
                        
                        if (response.mensagem) {
                            $('.mensagem').text(response.mensagem).addClass('alert-success').removeClass('alert-warning').fadeIn().delay(2000).fadeOut('slow');
                        }

                        tableInstituto.ajax.reload(null, false); // Faz o realod / Refresh na table
                        
                    } else {
                        if (response.messagesFormValidation) {
                            if (response.messagesFormValidation.id_inst) {
                                alert('[ERROR] Identificador não existe na base de dados.')
                            }

                        } else if (response.mensagem) {
                            $('.mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut('slow');
                            
                        }
                        
                    }
                    $('#modalDelete').modal('hide');
                },
                error: function(error) {
                    console.log(error.responseText);
                    alert('[ERROR] Erro interno, aguarde que em breve o problema vai ser solucionado.');
                }
            })
            
            
        })
        
    });


});

// Modifica o attr disabled do CNPJ para TRUE e DESATIVA o disabled dos outros campos
function disabledCNPJ() {
    
    $('#cnpj').attr('disabled', true);
    let campos = [$('#instituto'), $('#endereco'), $('#tipo_ensino'), $('#telefone')];

    for (campo of campos) {
        $(campo).attr('disabled', false);
    }
}

// Modifica o attr disabled do CNPJ para FALSE e ATIVA o disabled dos outros campos
function enabledCNPJ() {
    $('#cnpj').attr('disabled', false);
    let campos = [$('#instituto'), $('#endereco'), $('#tipo_ensino'), $('#telefone')];

    for (campo of campos) {
        $(campo).attr('disabled', true);
    }
}

/**
 * Erros do codeIgniter do formulário de cadastro de Endereço
 * @param {object} response 
 */
function validErrosCodeIgniterEndereco(response) {  

    let cep = $('#cep');
    let rua = $('#rua');
    let bairro = $('#bairro');
    let cidade = $('#cidade');
    let estado = $('#estado');
    let pais   = $('#pais');
    

    if (response.cep) {
        $(cep).parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-cep').show('fast').text(response.cep);
    } else {
        $(cep).parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-cep').hide('fast').text('');
    }

    if (response.rua) {
        $(rua).parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-rua').show('fast').text(response.rua);
    } else {
        $(rua).parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-rua').hide('fast').text('');
    }

    if (response.bairro) {
        $(bairro).parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-bairro').show('fast').text(response.bairro);
    } else {
        $(bairro).parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-bairro').hide('fast').text('');
    }

    if (response.cidade) {
        $(cidade).parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-cidade').show('fast').text(response.cidade);
    } else {
        $(cidade).parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-cidade').hide('fast').text('');
    }

    if (response.estado) {
        $(estado).parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-estado').show('fast').text(response.estado);
    } else {
        $(estado).parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-estado').hide('fast').text('');
    }

    if (response.pais) {
        $(pais).parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-pais').show('fast').text(response.pais);
    } else {
        $(pais).parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-pais').hide('fast').text('');
    }
}

/**
 * Erros do codeIgniter do formulário de update de Instituto
 * @param {object} response 
 */
function validErrosCodeIgniterInstituto(response) {
    // let campos = [$('#id_inst'), $('#cnpj'), $('#instituto'), $('#endereco'), $('#tipo_ensino'), $('#telefone')];

    if (response.cnpj) {
        $('.msg-cnpj').parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-cnpj').show('fast').text(response.cnpj);
    } else {
        $('.msg-cnpj').parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-cnpj').hide('fast').text('');
    }

    if (response.instituto) {
        $('.msg-instituto').parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-instituto').show('fast').text(response.instituto);
    } else {
        $('.msg-instituto').parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-instituto').hide('fast').text('');
    }

    if (response.endereco) {
        $('.msg-endereco').parent().parent().addClass('has-error').removeClass('has-success');
        $('.select2-selection').addClass('has-error').removeClass('has-success');
        $('.msg-endereco').show('fast').text(response.endereco);
    } else {
        $('.msg-endereco').parent().parent().addClass('has-success').removeClass('has-error');
        $('.select2-selection').addClass('has-success').removeClass('has-error');
        $('.msg-endereco').hide('fast').text('');
    }    

    
    if (response.tipo_ensino) {
        $('.msg-tipo_ensino').parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-tipo_ensino').show('fast').text(response.tipo_ensino);
    } else {
        $('.msg-tipo_ensino').parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-tipo_ensino').hide('fast').text('');
    }

    if (response.telefone) {
        $('.msg-telefone').parent().parent().addClass('has-error').removeClass('has-success');
        $('.msg-telefone').show('fast').text(response.telefone);
    } else {
        $('.msg-telefone').parent().parent().addClass('has-success').removeClass('has-error');
        $('.msg-telefone').hide('fast').text('');
    }  
}

// Responsável pela remoção da classe has-error e hide do span
function removeHasErrorAndSuccessEnd()  {
    let fields = [ $('#cep'), $('#rua'), $('#bairro'), $('#cidade'), $('#estado'), $('#pais')];

    for(field of fields) {
        $(field).parent().parent().removeClass('has-error has-success');
    }

    $('.help-block').hide();
}

// Responsável pela remoção da classe has-error e hide do span
function removeHasErrorAndSuccessInsti() {
    let fields = [$('#id_inst'), $('#cnpj'), $('#instituto'), $('#endereco'), $('#tipo_ensino'), $('#telefone')];

    for(field of fields) {
        $(field).parent().parent().removeClass('has-error has-success');
    }

    $('.help-block').hide();
} 


// Limpa os values do formulário CEP
function limpa_formulário_cep() {
    $("#rua").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#estado").val("");
}







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



// Monta um select de países
/*
function montarSelectPaises(response) {
    var selectElement = $('#pais');
    
    for(pais of response) {
        selectElement.append('<option value='+pais.nativeName+'>'+pais.nativeName+'</option>');
    }
}
*/




// Consulta os endereços da base de dados
/*
function buscarEnderecos() {

    $.ajax({
        url: url_atual+'endereco/exibirTodos',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            montarSelectEnderecos(response); // Retorna o select preenchido

        },
        error: function(error) {
            console.log(error.responseText);
        }
    });
}
*/

// Preenche o select com os dados do endereço
/*
function montarSelectEnderecos(response) {
    for(end of response) {
        $('#endereco').append('<option value='+end.id_endereco+'>'+end.rua+' ('+end.bairro+')</option>');
    }
}
*/
