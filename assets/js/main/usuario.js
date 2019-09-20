var url_atual = window.location.href;
url_atual = url_atual.substring(0,22);


$(function(){

    /*  Preview Image  */
    $('#upload').on('change', function(){ 
        const file = $(this)[0].files[0];

        console.log(file);

        var types = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

        
        if (typeof file != 'undefined') {
            if (types.indexOf(file.type) != -1 && file.size < 3000000) {
                const fileReader = new FileReader();
                fileReader.onloadend = function() {
                    $('#img-profile').attr('src', fileReader.result);
                };
                fileReader.readAsDataURL(file);
                
            } else {
                alert('Error');
            }
        }

        
    });

    // Responsável por alterar imagem do perfil
    $('#btn-alterar-imageProfile').click(function(e){
        var formData = new FormData();
        $.each($('#upload')[0].files, function(key, value){ 
            formData.append('imagem', value);
        });

        $.ajax({
            url: url_atual+'usuario/imagem',
            method: 'POST',
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: formData,
            cache: false,
            success: function(response) {
                console.log(response);

                $('.msg-imagem').text('').hide();
                $('#upload').parent().parent().removeClass('has-error');

                if (response.sucesso) {
                    location.reload();
                } else {
                    if (response.mensagem) {
                        $('#mensagem').text(response.mensagem).removeClass('alert-success').addClass('alert-danger').fadeIn().delay(2000).fadeOut('slow');
                    } else if (response.mensagemUploadErrors) {
                        if (response.mensagemUploadErrors) {
                            $('.msg-imagem').text(response.mensagemUploadErrors).show();
                            $('#upload').parent().parent().addClass('has-error');
                        } 
                    }
                }

            },
            error: function(error) {
                // console.log(error.responseText);
                alert('Selecione uma Imagem...');
            }
        });
        
    });

    // Responsável por formatar a exibição do select2 de países e nome
    function formatState (state) {
        if (!state.id) {
          return state.text;
        }
        
        var flag = "https://www.countryflags.io/";
        var code = state.text.slice(-3, -1); /* 1 - Inicio (-3), ou seja as 3 últimas strings do texto | 2 - fim (-1) (tamanhoString(3) - 1) */

        var $state = $(
          '<span><img /> <span></span></span>'
        );
      
        // Use .text() instead of HTML string concatenation to avoid script injection issues
        $state.find("span").text(state.text);
        $state.find("img").attr("src", flag + code + "/flat/16.png");
      
        return $state;
    };

    try {
        $("#perfil").select2('isOpen');
        'select2 v4.x';
    } catch(e) {
        'select2 v3.x';
    } 

    // Responsável pela exibição do select2 com países
    $('#nacionalidade').select2({
        placeholder: 'Selecione',
        templateResult: formatState,
        templateSelection: formatState
    });

    // Responsável pela exibição do select2 dos perfis
    $('#perfil').select2({
        placeholder: 'Selecione',
        ajax: {
            url: url_atual+'perfil/consultarTodos',
            method: 'post',
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
                    res.push({id:response[i].id_perfil, text:response[i].perfil });
                }

                return {
                    results: res
                }
               
            },
            cache: true,
        }
    });

    // Responsável pela exibição do select2 dos endereços
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

    // Responsável pela exibição do select2 dos intituitos
    $('#instituto').select2({
        placeholder: 'Selecione',
        ajax: {
            url: url_atual+'instituto/consultarTodos',
            method: 'post',
            dataType: 'json',
            delay:250,
            data: function(params) {
                return {
                    searchTerm: params.term
                };
            },
            processResults: function (response) {
                
                console.log(response);

                var res = [];
                for(var i  = 0 ; i < response.length; i++) {
                    res.push({id:response[i].id_instituto, text:response[i].nome_instituto});
                }

                return {
                    results: res
                }
               
            },
            cache: true,
        }
    });

    // Responsável pela exibição do select2 das habilidades
    $('.seletorSkills').select2({
    });

    // Responsável por editar o perfil do usuário
    $('.btn-edit-profile').on('click', function(){
        $.ajax({
            url: url_atual+'usuario/perfil',
            dataType: 'json',
            method: 'post',
            data: $('#myFormEditProfile').serialize(),
            success: function(response) {
                console.log(response);
                
                $('.msg-nome').text('').hide();
                $('#nome').parent().parent().removeClass('has-error');

                if (response.sucesso) {

                    if (response.mensagem) {
                        $('#mensagem').text(response.mensagem).removeClass('alert-danger').addClass('alert-success').fadeIn().delay(2000).fadeOut('slow', function(){
                            location.reload();
                        });
                    } 
                } else {
                    if (response.mensagem) {
                        $('#mensagem').text(response.mensagem).removeClass('alert-success').addClass('alert-danger').fadeIn().delay(2000).fadeOut('slow');
                   
                    } else if (response.mensagemFormValidation) {
                        if (response.mensagemFormValidation.nome) {
                            $('.msg-nome').text(response.mensagemFormValidation.nome).show();
                            $('#nome').parent().parent().addClass('has-error');
                        } 
                    }
                }
                
            },
            error: function(error) {
                console.log(error.resposeText);
            }
        });
    });

    // Responsável pelo clique da paginação
    $('#pagination').on('click', 'a', function(e){
        e.preventDefault();
        var pagina = $(this).attr('data-ci-pagination-page');
        carregarUsuario(pagina);
    });

    // Responsável por adicionar habilidades
    $('#btn-add-habilidade').on('click', function(e){
        e.preventDefault();

        $('#myModal').modal('show');
        $('#myForm')[0].reset(); // Reseta os input values do form
        $('.msg-habilidade').parent().parent().removeClass('has-success has-error'); // Remove a estilização do input
        $('.msg-habilidade').text('').hide(); // Esconde o span de mensagem

        $('#btnSaveHabilidade').off().on('click', function(){

            var habilidade = $.trim($('#habilidade').val());

            $.ajax({
                url: url_atual+'usuario/addHabilidade',
                method: 'POST',
                dataType: 'json',
                data: {habilidade: habilidade},
                success: function(response) {
                    console.log(response);

                    $('#mensagem').empty();

                    if (response.sucesso) {
                        $('#mensagem').text(response.mensagem).addClass('alert-success').removeClass('alert-warning').fadeIn().delay(2000).fadeOut();
                        

                        // Set the value, creating a new option if necessary
                        // Verify if the value is difference 0
                        if ($.trim(response.habilidade).length !== 0) {
                                        
                            if ($("#habilidades").find("option[value='" + response.habilidade + "']").length) {
                                $("#habilidades").val(response.habilidade).trigger("change");
                            } else { 
                                // Create the DOM option that is pre-selected by default
                                var habilidade = new Option(response.habilidade, response.habilidade, true, true);
                                // Append it to the select
                                $("#habilidades").append(habilidade).trigger('change');
                            } 
                        } 

                        $('#myModal').modal('hide');
                        

                    } else {
                        if (response.mensagemFormValidation) {
                            if (response.mensagemFormValidation.habilidade) {
                                $('.msg-habilidade').text(response.mensagemFormValidation.habilidade).show('fast');
                                $('.msg-habilidade').parent().parent().addClass('has-error').removeClass('has-success');
                            } 
                        } else {
                            $('#mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut();
                            $('#myModal').modal('hide');
                        }
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });


            
           
        });
       
       
    });

    // Responsável por editar a senha do usuário
    $('.btn-edit-senha').on('click', function(e){

        $('#modalSenha').modal('show');
        let form = $('#myFormSenha');

        $(form)[0].reset(); // Limpa os inputs
        removeHasErrorAndSuccessSenha(); // Remove as classes de estilização do span e aplica o hide

        $('#btnEditSenha').off().on('click', function(){

            $.ajax({
                url: url_atual+"/usuario/alterarSenha",
                method: 'post',
                dataType: 'json',
                data: form.serialize(),
                success: function(response) {
                    console.log(response);

                    if (response.sucesso) {

                        if (response.is_redirect && response.redirect.length !== 0) {
                            window.location.href = response.redirect;
                        }   

                    } else {
                        if (response.mensagemFormValidation) {

                            MessagevalidationCodeIgniterSenha(response.mensagemFormValidation);

                        } else if (response.mensagem) {
                            $('#modalSenha').modal('hide');
                            $('#mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut();

                        }
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });

        });
    });

    // Responsável por editar o email do usuário
    $('.btn-edit-email').on('click', function(e){
        $('#modalEmail').modal('show');
        let form = $('#myFormEmail');

        form[0].reset();
        removeHasErrorAndSuccessEmail(); 

        $('#btnEditEmail').off().on('click', function(){
            $.ajax({
                url: url_atual+"/usuario/alterarEmail",
                method: "post",
                dataType: "json",
                data: form.serialize(),
                success: function(response) {
                    console.log(response);

                    if (response.sucesso) {

                        if (response.is_redirect && response.redirect.length !== 0) {
                            window.location.href = response.redirect;
                        }

                    } else {
                        
                        if (response.mensagemFormValidation) {

                            MessagevalidationCodeIgniterEmail(response.mensagemFormValidation);

                        } else if (response.mensagem) {
                            $('#modalEmail').modal('hide');
                            $('#mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut();
                        }

                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        });
    });

    // Evita o envio do formulário do modal ao pressionar a key Enter
    $('#myModal').on('keypress', function(e){
        if( e.keyCode === 13 ) {
            e.preventDefault();
            // $( this ).trigger( 'submit' );
        }
    });

    // Evita o envio do formulário do modal ao pressionar a key Enter
    $('#modalEmail').on('keypress', function(e){
        if( e.keyCode === 13 ) {
            e.preventDefault();
            // $( this ).trigger( 'submit' );
        }
    });

    carregarDadosProfile(); // Carrega dados do perfil

    carregarUsuario(1); // Carrega a lista de usuário
});


// Responsável por remover as classes do span e aplicar o hide
function removeHasErrorAndSuccessSenha()  {
    let fields = [ $('#senhaAntiga'), $('#novaSenha'), $('#confsenha')];

    for(field of fields) {
        $(field).parent().parent().removeClass('has-error has-success');
    }

    $('.help-block').hide();
}

/**
 * Responsável por exibir os erros de validação do codeigniter
 * @param {object} response 
 */
function MessagevalidationCodeIgniterSenha(response)
{
  
    if (response.senhaAntiga) {
        $('.msg-antigasenha').text(response.senhaAntiga).show('fast');
        $('.msg-antigasenha').parent().parent().addClass('has-error').removeClass('has-success');
    } else {
        $('.msg-antigasenha').text('').hide('fast');
        $('.msg-antigasenha').parent().parent().addClass('has-success').removeClass('has-error');
    }

    if (response.novaSenha) {
        $('.msg-novasenha').text(response.novaSenha).show('fast');
        $('.msg-novasenha').parent().parent().addClass('has-error').removeClass('has-success');
    } else {
        $('.msg-novasenha').text('').hide('fast');
        $('.msg-novasenha').parent().parent().addClass('has-success').removeClass('has-error');
    }

    if (response.confsenha) {
        $('.msg-confsenha').text(response.confsenha).show('fast');
        $('.msg-confsenha').parent().parent().addClass('has-error').removeClass('has-success');
    } else {
        $('.msg-confsenha').text('').hide('fast');
        $('.msg-confsenha').parent().parent().addClass('has-success').removeClass('has-error');
    }
}

// Responsável por remover as classes do span e aplicar o hide
function removeHasErrorAndSuccessEmail()  {
    $('#novoEmail').parent().parent().removeClass('has-error has-success');
    $('.help-block').hide();
}

/**
 * Responsável por exibir os erros de validação do codeigniter
 * @param {object} response 
 */
function MessagevalidationCodeIgniterEmail(response)
{
    if (response.novoEmail) {
        $('.msg-novoemail').text(response.novoEmail).show('fast');
        $('.msg-novoemail').parent().parent().addClass('has-error').removeClass('has-success');
    } else {
        $('.msg-novoemail').text('').hide('fast');
        $('.msg-novoemail').parent().parent().addClass('has-success').removeClass('has-error');
    }
    
}

/*  Responsável por carregar os dados do usuário  (Perfil)  */
function carregarDadosProfile() {
    $.ajax({
        url: url_atual+'usuario/perfil',
        dataType: 'json',
        success: function(response) {
            //console.log(response);

            $('#nome').val(response.NOME);

            // if (response.IMAGEM != null){ 
            //     $('.profile-user-img').attr('src', 'http://localhost:3000/assets/upload/160px/'+response.IMAGEM);
            // }
           
            console.log(response.HABILIDADE);

            if (response.HABILIDADE != null) {
                var skills = response.HABILIDADE.split(',');
                $('.seletorSkills').val(skills).trigger("change");
            }

            var optInstituto = $("<option selected></option>").val(response.ID_INSTITUTO).text(response.NOME_INSTITUTO);
            $('#instituto').append(optInstituto).trigger('change');

            var optPerfil = $("<option selected></option>").val(response.ID_PERFIL).text(response.PERFIL);
            $('#perfil').append(optPerfil).trigger('change');

            var optEndereco = $("<option selected></option>").val(response.ID_ENDERECO).text(response.RUA+' ('+response.ID_ENDERECO+')');
            $('#endereco').append(optEndereco).trigger('change');

            var optNacionalidade =  $("<option selected></option>").val(response.NACIONALIDADE).text(response.NACIONALIDADE);
            $('#nacionalidade').append(optNacionalidade).trigger('change');
        },
        error: function (error) {
            console.log(error.responseText);
        }
    });
}

/**
 * Responsável por carregar a lista de usuário da base de dados 
 * @param {int} page 
 */
function carregarUsuario(page) {
    var nome_search = $.trim($('#nome_search').val());
    var per_page    = $('#per_page').val();

    $.ajax({
        url: url_atual+'usuario/listar/'+page,
        method: 'post',
        dataType: 'json',
        data: {nome_search: nome_search, limite: per_page},
        success: function(response) {

            //console.log(response);

            if (response.usuarios) {
                createList(response.usuarios);
            }
            
            $('#pagination').html(response.pagination);

            if (response.mensagem) {
                $('#mensagem').text(response.mensagem).show();
            } else {
                $('#mensagem').text(response.mensagem).hide();
            }
          
        },
        error: function(error) {
            console.log(error.resposeText);
        }
    });
}

/**
 * Responsável por carregar a lista utilizando o input Number como limite de registros por página
 * @param {int} page 
 */
function limiteRegPorPagina(page) {
    var limite = $('#per_page').val();
    var search = $.trim($('#nome_search').val());

    $.ajax({
        url: url_atual+'usuario/listar',
        method: 'post',
        dataType: 'json',
        data: {limite: limite, nome_search: search},
        success: function(response){
            if (response.usuarios) {
                createList(response.usuarios);
            }

            $('#pagination').html(response.pagination);

            if (response.mensagem) {
                $('#mensagem').text(response.mensagem).show();
            } else {
                $('#mensagem').text(response.mensagem).hide();
            }
          
        },
        error: function(error) {
            console.log(error);
        }
    });
}

/**
 * Responsável por renderizar o html da lista de usuários
 * @param {object} response 
 */
function createList(response) {
  
    $('#lista-usuario').empty();

    for(usuario of response) {
      
        var imagem = usuario.IMAGEM === null ?  'images/default.png' : 'upload/160px/'+usuario.IMAGEM;
      
        $('#lista-usuario').append('<div class="container-search"><div><img src="'+url_atual+'/assets/'+imagem+'" class="img-circle w-45 h-45" />'+usuario.NOME+'</div><form action="'+url_atual+'mensagem/view_enviarMensagemUsuarioEspecifico" method="post"><input type="hidden" name="id_usuario" value="'+usuario.ID_USUARIO+'" /><button class="btn btn-danger">Enviar Mensagem</button></form></div>');
    }
}










