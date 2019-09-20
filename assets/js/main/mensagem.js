var url_atual = window.location.href;
var view  = url_atual.substring(31);
url_atual = url_atual.substring(0,22);


$(function(){

    /**
     * Desativar a MENSAGEM  |   DELETAR a MENSAGEM
     */
    $('.deletar-mensagem').on('click', function(){

        var href = window.location.href;
        href = href.substring(31);

        var checados = [];

        $.each($("input[name='checkbox[]']:checked"),function(){
            checados.push($(this).val());
        });  
        

        var rows = $("input[name='checkbox[]']:checked").closest("tr");

        switch(href) {
            case 'view_caixaEntrada':
            case 'view_enviado':

                $('#modalDelete').modal('show');
                $('#modalDelete').find('.modal-body').text('Você tem certeza que deseja excluir esse Mensagem temporáriamente?');

                $('#btnDelete').off().on('click', function(){
                    $.ajax({
                        url: url_atual+'/mensagem/ativar_desativarMensagem',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            checados: checados,
                            status: 2,
                        },
                        success: function(response) {
                            console.log(response);
            
                            if (response.sucesso) {
                                
                                $('#mensagem').text(response.mensagem).addClass('alert-success').removeClass('alert-warning').fadeIn().delay(2000).fadeOut("slow", function(){
                                    rows.remove();
    
                                    if (href === 'view_caixaEntrada') {
                                        carregarMensagens(1);
                                    } else if (href === 'view_enviado') {
                                        carregarMensagensEnviadas(1);
                                    }

                                   
                                    var iElementAll = $('.selecionar-tudo')[0].children;
                                    // Responsável por alternar o icon do elemento <i> ao deletar uma mensagem
                                    $(iElementAll).removeClass('fa-minus-square').addClass('fa-square-o');
                                    // Responsável por esconder o grupo de funcionalidades ao deletar uma mensagem
                                    $('.group-funcionalidades').hide();
                                    // Responsável por exibir o botão de refresh ao deletar uma mensagem
                                    $('.btn-refresh').show();
                                    
                                })

                                

    
                            } else {
    
                                if (response.mensagemFormValidation) {
                                    $('#mensagem').text(response.mensagemFormValidation.checados).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                                } else {
                                    $('#mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                                }
                                
                            }

                            $('#modalDelete').modal('hide');
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        }
                    });
                })
                break;
            
            case 'view_lixeira':

                $('#modalDelete').modal('show');
                $('#modalDelete').find('.modal-body').text('Você tem certeza que deseja excluir esse Mensagem permanente?');
                	
                $('#btnDelete').off().on('click', function(){

                    
                    $.ajax({
                        url: url_atual+'/mensagem/deletarMensagem',
                        method: 'post',
                        dataType: 'json',
                        data: {checados: checados},
                        success: function(response) {
                            console.log(response);
            
                            if (response.sucesso) {
                                $('#modalDelete').modal('hide');
                                $('#mensagem').text(response.mensagem).addClass('alert-success').removeClass('alert-warning').fadeIn().delay(2000).fadeOut("slow", function(){
                                    rows.remove();
                                    carregarMensagensExcluidas(1);

                                    var iElementAll = $('.selecionar-tudo')[0].children;
                                    // Responsável por alternar o icon do elemento <i> ao deletar uma mensagem
                                    $(iElementAll).removeClass('fa-minus-square').addClass('fa-square-o');
                                    // Responsável por esconder o grupo de funcionalidades ao deletar uma mensagem
                                    $('.group-funcionalidades').hide();
                                    // Responsável por exibir o botão de refresh ao deletar uma mensagem
                                    $('.btn-refresh').show();
                                })
                            } else {
    
                                if (response.mensagemFormValidation) {
                                    $('#mensagem').text(response.mensagemFormValidation.checados).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                                } else {
                                    $('#mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                                }
                                
                            }
                            $('#modalDelete').modal('hide');
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        }
                    }); 
                });
                break;
        }
        
    });

    /**
     * Recuperar a MENSAGEM, alterando seu status
     */
    $('.recuperar-mensagem').on('click', function(){
        var checados = [];

        $.each($("input[name='checkbox[]']:checked"),function(){
            checados.push($(this).val());
        });  
        
        var rows = $("input[name='checkbox[]']:checked").closest("tr");

        $('#modalRecover').modal('show');
        $('#btnRecover').off().on('click', function(){
            $.ajax({
                url: url_atual+"/mensagem/ativar_desativarMensagem",
                method: "post",
                dataType: "json",
                data: {
                    checados: checados,
                    status: 1
                },
                success: function(response) {
                    
                    if (response.sucesso) {

                        $('#modalRecover').modal('hide');
                        $('#mensagem').text(response.mensagem).addClass('alert-success').removeClass('alert-warning').fadeIn().delay(2000).fadeOut("slow", function(){
                            rows.remove();
                            carregarMensagensExcluidas(1);

                            var iElementAll = $('.selecionar-tudo')[0].children;
                            // Responsável por alternar o icon do elemento <i> ao deletar uma mensagem
                            $(iElementAll).removeClass('fa-minus-square').addClass('fa-square-o');
                            // Responsável por esconder o grupo de funcionalidades ao deletar uma mensagem
                            $('.group-funcionalidades').hide();
                            // Responsável por exibir o botão de refresh ao deletar uma mensagem
                            $('.btn-refresh').show();
                        });

                    } else {
    
                        if (response.mensagemFormValidation) {
                            $('#mensagem').text(response.mensagemFormValidation.checados).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                        } else {
                            $('#mensagem').text(response.mensagem).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                        }
                        
                    }

                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        });

       
    });

    /**
     * Faz o refresh na pagina
     */
    $('#refresh-page').on('click', function(){
        setTimeout(function(){
            location.reload();
        }, 1000)
    });
   
    /**
     * Faz o clique da paginação das mensagens funcionar
     */
    $('.pagination').on('click', 'a', function(e){
        e.preventDefault();
        var pagina = $(this).attr('data-ci-pagination-page');

        var href = window.location.href;
        href = href.substring(31);

        var botaoSelecionar = $('.selecionar-tudo');
        var iElement = $(botaoSelecionar)[0].children;
        $(iElement).addClass('fa-square-o').removeClass('fa-minus-square'); // Altera o icon para o default

        $('.group-funcionalidades').hide(); // Esconde o group de funcionalidades, para o modo default
        $('.btn-refresh').show();  // Mostra o botão de refresh, que é o modo default

        

        switch(href) {
            case 'view_enviado':
                carregarMensagensEnviadas(pagina);
                break;
            
            case 'view_caixaEntrada':
                carregarMensagens(pagina);
                break;

            case 'view_lixeira':
                carregarMensagensExcluidas(pagina);    
                break;
        }
      
    });


    // Responsável por alternar a class text-yellow com text-black ao passar o ponteiro por cima do elemento
    $(document).on({
        mouseenter: function () {
            if ($(this).attr('data-verified') !== '2') {
                $(this).removeClass('text-black').addClass('text-yellow');
            }
        },
        mouseleave: function () {
            if ($(this).attr('data-verified') !== '2') {
                $(this).removeClass('text-yellow').addClass('text-black');
            }
        }
    }, ".favoritar-msg");
    

    // Responsável por favoritar ou desfavoritar uma mensagem
    $('#tbody').on('click','.favoritar-msg' ,function(e){


        let id_mensagem = this.id;
        let star = $(this);
        
        // Verifica se o data-verified é igual a 1, caso seja verdadeiro, altera o data-verified para 2, sendo assim
        // não é possível o hover funcionar.
        // Caso seja falso, altera o data-verified para 1, sendo assim o hover volta a funcionar sobre o elemento.
        if (star.attr('data-verified') === '1') {
            star.attr('data-verified', '2');
        } else {
            star.attr('data-verified', '1');
        }

        // Verifica se o data-verified é igual a 2, caso seja verdadeiro, envia um ajax com o favorite igual a 2
        // Sendo 2 o valor para favorito e 1 para valor não favorito.
        // Caso falso, ele envia um ajax com o valor do favorite igual a 1.
        if (star.attr('data-verified') === '2') {
            $.ajax({
                url: url_atual+"/mensagem/favoritar_naoFavoritar",
                method: "post",
                dataType: "json",
                data: {checados: id_mensagem, favorite: 2},
                success: function(response) {
                    if ( !response.sucesso ) {
                        
                        if (response.mensagemFormValidation) {
                            $('#mensagem').text(response.mensagemFormValidation.identificador).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");

                            star.attr('data-verified', '1'); // Altera o data-verified para que a star não fique amarela, pois houve um erro na hora de alterar
                        }
                    } 
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })
        } else {
            $.ajax({
                url: url_atual+"/mensagem/favoritar_naoFavoritar",
                method: "post",
                dataType: "json",
                data: {checados: id_mensagem, favorite: 1},
                success: function(response) {
                    if ( !response.sucesso ) {
                        
                        if (response.mensagemFormValidation) {
                            $('#mensagem').text(response.mensagemFormValidation.identificador).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");

                            star.attr('data-verified', '2'); // Altera o data-verified para que a star não fique preta, pois houve um erro na hora de alterar
                        }
                    }

                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })
        }
    
    });


    /**
     * Verifica o checked do checkbox ao clicar no checkbox
     */
    $('#tbody').on('click', "input[name='checkbox[]']", function(){
        verificarChecked($("input[name='checkbox[]']:checked"));
    })


    /**
     *  Seleciona todos os checkbox e altera a class do elemento <i>
     */
    $('.selecionar-tudo').on('click', function(){

        var checkbox = $("input[name='checkbox[]']");
        var botaoSelecionar = $('.selecionar-tudo');
        var iElementAll = $(botaoSelecionar)[0].children;
        var iElementRead = $('.lido-naoLido-mensagem')[0].children;
        var checkboxchecked = $("input[name='checkbox[]']:checked");
        var btn = $('.lido-naoLido-mensagem')[0];
       
        
        // Verifica a quantidade de checkbox checked, caso exista algum checkbox já checked, ele descheca esse checkbox e altera o icon
        if (checkboxchecked.length > 0) {
            // console.log('DESCHECAR');

            $(iElementAll).removeClass('fa-minus-square').addClass('fa-square-o');  // Altera a class icon
            $('.group-funcionalidades').hide();
            $('.btn-refresh').show();

            $.each(checkboxchecked, function(key, value){
            
                $(value).prop('checked', false);
            
            });

        } else {
            // console.log('FAZER AS CHECAGEM');

            $(iElementAll).removeClass('fa-square-o').addClass('fa-minus-square'); // Altera a class icon
            $('.group-funcionalidades').show();
            $('.btn-refresh').hide();

            $.each(checkbox, function(key, value){
              
                $(value).prop('checked', true);

                // Determina que ao selecionar tudo, se encontrar algum elemento com data-read = 1, terá alteração na class icon para que o mark read tenha prioridade sobre o  mark not read
                if ( $(value).attr('data-read') === "1" ) {
                    $(iElementRead).removeClass('fa-envelope').addClass('fa-envelope-open');
                    $(btn).attr('data-mark', 1); // Define o data-mark como 1, para que entre na condição na function lido-naoLido-mensagem
                }
            
            });
        }

    });


     /**
     * Altera a classe do elemento <i> de acordo com o checked do checkbox
     */
    function verificarChecked(checkbox) {
        
        var iElementRead = $('.lido-naoLido-mensagem')[0].children;
        var botaoRead    = $('.lido-naoLido-mensagem')[0];
        
        //console.log(botaoRead);

        $.each(checkbox, function(key, value){
            if ( $(value).attr('data-read') == "2" ) {
                $(iElementRead).addClass('fa-envelope').removeClass('fa-envelope-open');
                $(botaoRead).attr('data-mark', 2);
                return true; // Retorna TRUE, para que a iteração continue
            } else {
                $(iElementRead).addClass('fa-envelope-open').removeClass('fa-envelope');
                $(botaoRead).attr('data-mark', 1);
                return false; // Retorna FALSE, para que possa parar a iteração e sendo assim não haja alteração na class icon, serve como uma prioridade para quando ambas mensagens com tipos diferentes (Mark Read & Not Mark Read) estejam marcadas, a Mark read tenha prioridade sobre a  mark not read 
            }
        });


        // Relacionado ao checkbox em alterar a class icon do selecionar tudo
        var botaoSelecionar = $('.selecionar-tudo');
        var iElementAll = $(botaoSelecionar)[0].children;

        if ( $(checkbox).is(':checked') ) {
            $(iElementAll).removeClass('fa-square-o').addClass('fa-minus-square');
            $('.group-funcionalidades').show();
            $('.btn-refresh').hide();
        } else {
            $(iElementAll).removeClass('fa-minus-square').addClass('fa-square-o');
            $('.group-funcionalidades').hide();
            $('.btn-refresh').show();
        } 
    }


    /**
     * Marca uma mensagem como Lida ou Não Lida
     */
    $('.lido-naoLido-mensagem').on('click', function(e){

        var checados = [];
        var lido = 0;
        var btn = $('.lido-naoLido-mensagem')[0];



        if ($(btn).attr('data-mark') === "1") {

            $.each($("input[name='checkbox[]']:checked"),function(){
                if ($(this).attr('data-read') === "1") {
                    checados.push($(this).val());
                }
            });   

            $.ajax({
                url: url_atual+"/mensagem/lido_naoLido",
                method: "post",
                dataType: "json",
                data: {
                    checados: checados,
                    lido_naoLido: 2 // Marcar como lido
                },
                success: function(response) {
    
                    console.log(response);
                    
                    if (response.sucesso) {
                        
                       /* Verifica se o data-mark é igual a 1, ou seja,  mark read é prioridade em casos que tenham mais de uma mensagem de diferentes
                          tipos selecionados. Caso seja verdadeiro, faz uma iteração nos checkboxes checked e alterna as classes apenas nos checkboxes
                          que tenham o data-read igual a 1, que nesse caso significa que a mensagem não foi lida ainda.
                       */
                        if ($(btn).attr('data-mark') === "1") {
                            $.each($("input[name='checkbox[]']:checked"),function(){
                                let email = $(this).parent().parent().children()[2];
                                let desc  = $(this).parent().parent().children()[3].children[0];
                                
                                if ($(this).attr('data-read') === "1") {
                                    $(email).addClass('font-normal').removeClass('font-bold');
                                    $(desc).addClass('font-normal').removeClass('font-bold');
    
                                    $(this).attr('data-read', "2"); // Altera o data-read para que possa alternar o icon e a funcionalidade
                                    verificarChecked($(this)); // Chama a função de verificar, para que possa alterar o icon, logo apos o clique
                                }
    
                            });
    
    
                        /* Verifica se o data-mark é igual a 2, ou seja,  mark not read em casos que tenham apenas mensagens de um único tipo 
                           selecionados. Caso seja verdadeiro, faz uma iteração nos checkboxes checked e alterna as classes apenas nos checkboxes
                           que tenham o data-read igual a 2, que nesse caso significa que as mensagens já foram lidas.
                        */    
                        } else if ($(btn).attr('data-mark') === "2") {
                            $.each($("input[name='checkbox[]']:checked"),function(){
                                let email = $(this).parent().parent().children()[2];
                                let desc  = $(this).parent().parent().children()[3].children[0];
                                
                                if ($(this).attr('data-read') === "2") {
                                    $(email).addClass('font-bold').removeClass('font-normal');
                                    $(desc).addClass('font-bold').removeClass('font-normal');
    
                                    $(this).attr('data-read', "1"); // Altera o data-read para que possa alternar o icon e a funcionalidade
                                    verificarChecked($(this)); // Chama a função de verificar, para que possa alterar o icon, logo apos o clique
                                }
    
                            });
                        }
    
    
                    } else {
    
                        if (response.mensagemFormValidation) {
                            $('#mensagem').text(response.mensagemFormValidation.checados).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                        }
                        
                    }
    
    
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })

        } else if ($(btn).attr('data-mark') === "2") {

            $.each($("input[name='checkbox[]']:checked"),function(){
                if ($(this).attr('data-read') === "2") {
                    checados.push($(this).val());
                }
            });   
            
            $.ajax({
                url: url_atual+"/mensagem/lido_naoLido",
                method: "post",
                dataType: "json",
                data: {
                    checados: checados,
                    lido_naoLido: 1 // Marcar como não lido
                },
                success: function(response) {
    
                    console.log(response);
                    
                    if (response.sucesso) {
                        
                       /* Verifica se o data-mark é igual a 1, ou seja,  mark read é prioridade em casos que tenham mais de uma mensagem de diferentes
                          tipos selecionados. Caso seja verdadeiro, faz uma iteração nos checkboxes checked e alterna as classes apenas nos checkboxes
                          que tenham o data-read igual a 1, que nesse caso significa que a mensagem não foi lida ainda.
                       */
                        if ($(btn).attr('data-mark') === "1") {
                            $.each($("input[name='checkbox[]']:checked"),function(){
                                let email = $(this).parent().parent().children()[2];
                                let desc  = $(this).parent().parent().children()[3].children[0];
                                
                                if ($(this).attr('data-read') === "1") {
                                    $(email).addClass('font-normal').removeClass('font-bold');
                                    $(desc).addClass('font-normal').removeClass('font-bold');
    
                                    $(this).attr('data-read', "2"); // Altera o data-read para que possa alternar o icon e a funcionalidade
                                    verificarChecked($(this)); // Chama a função de verificar, para que possa alterar o icon, logo apos o clique
                                }
    
                            });
    
    
                        /* Verifica se o data-mark é igual a 2, ou seja,  mark not read em casos que tenham apenas mensagens de um único tipo 
                           selecionados. Caso seja verdadeiro, faz uma iteração nos checkboxes checked e alterna as classes apenas nos checkboxes
                           que tenham o data-read igual a 2, que nesse caso significa que as mensagens já foram lidas.
                        */    
                        } else if ($(btn).attr('data-mark') === "2") {
                            $.each($("input[name='checkbox[]']:checked"),function(){
                                let email = $(this).parent().parent().children()[2];
                                let desc  = $(this).parent().parent().children()[3].children[0];
                                
                                if ($(this).attr('data-read') === "2") {
                                    $(email).addClass('font-bold').removeClass('font-normal');
                                    $(desc).addClass('font-bold').removeClass('font-normal');
    
                                    $(this).attr('data-read', "1"); // Altera o data-read para que possa alternar o icon e a funcionalidade
                                    verificarChecked($(this)); // Chama a função de verificar, para que possa alterar o icon, logo apos o clique
                                }
    
                            });
                        }
    
    
                    } else {
    
                        if (response.mensagemFormValidation) {
                            $('#mensagem').text(response.mensagemFormValidation.checados).addClass('alert-warning').removeClass('alert-success').fadeIn().delay(2000).fadeOut("slow");
                        }
                        
                    }
    
    
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })
        }

    });


    /**
     * Exibi as mensagens favoritas e não favoritas
     */
    $('#select-favorito').on('change', function(e){
        let value = $(this).val();
        let search = $.trim($('#searchTitulo').val());

        $.ajax({
            url: url_atual+"/mensagem/exibirTodasMensagensFavoritas_naoFavoritas",
            method: "post",
            dataType: "json",
            data: {
                is_favorite: value,
                view: view,
                search: search
            },
            success: function(response){
                console.log(response);

                renderCaixaEntrada(response.emails);

                if (response.mensagem) {
                    $('#mensagem').text(response.mensagem).show('fast');
                } else {
                    $('#mensagem').hide('fast');
                }

                $('.pagination').html(response.pagination);
            },
            error: function(error) {
                console.log(error.responseText);
            }
        })
    });

});

/**
 * Responsável por renderizar as mensagens
 * @param {object} response 
 */
function renderCaixaEntrada(response) {

    var href = window.location.href;
    href = href.substring(31);
    $('#tbody').empty();
    
    /* Verifico a URL para que possa exibir corretamente as mensagens de acordo com a URL
    */
    switch(href) {
        case 'view_enviado':
            for (res of response) {

                console.log(res);
                
                diffData(res.DATA_ENVIO); // Corrigir
                
                // Declara uma variável para guardar o valor da classe de acordo com a condição
                let classStar = "";
                // Declara uma variável para guardar o valor do atributo data-verified de acordo com a condição
                let dataVerified = "";
                // Declara uma variável para guardar o valor da classe de acordo com a condição
                let classText = "";

                if (res.IS_FAVORITE === "2") {
                    classStar = "text-yellow"; // Define a classe como text-yellow, para que a star fique amarela
                    dataVerified = "2"; // Define como 2, para que o hover não funcione
                } else {
                    classStar = "text-black"; // Define a classe como text-black, para que a star fique preto
                    dataVerified = "1"; // Define como 1, para que o hover funcione
                }

                if (res.IS_READ === "1") { // 1 - Não Lido, Default()
                    classText = "font-bold";
                } else {
                    classText = "font-normal"; // 2 - Lido
                }

                $('#tbody').append('<tr><td><input type="checkbox" name="checkbox[]" class="checkbox_values" value="' + res.ID_MENSAGEM + '" data-read='+ res.IS_READ +' /></td><td class="mailbox-star"><i class="fa fa-star favoritar-msg '+ classStar +'" id="'+ res.ID_MENSAGEM +'" data-verified="'+ dataVerified +'"></i></td><td class="mailbox-name '+ classText +'"><a href="' + url_atual +'/mensagem/visualizarMensagemPorId?id=' + res.ID_MENSAGEM + '"> ' + res.USUARIO_DESTINO + ' </a></td><td class="mailbox-subject"><span class="' + classText + '">' + res.TITULO + '</span> - Trying to find a solution to this problem... </td><td class="mailbox-attachment"></td><td class="mailbox-date">'+ tempo +'</td></tr>')
            }
            break;

        case 'view_lixeira':
        case 'view_caixaEntrada':
            
            for (res of response) {

                diffData(res.DATA_ENVIO); // Corrigir

                
                // Declara uma variável para guardar o valor da classe de acordo com a condição
                let classStar = "";
                // Declara uma variável para guardar o valor do atributo data-verified de acordo com a condição
                let dataVerified = "";
                 // Declara uma variável para guardar o valor da classe de acordo com a condição
                 let classText = "";

                if (res.IS_FAVORITE === "2") {
                    classStar = "text-yellow"; // Define a classe como text-yellow, para que a star fique amarela
                    dataVerified = "2"; // Define como 2, para que o hover não funcione
                } else {
                    classStar = "text-black"; // Define a classe como text-black, para que a star fique preto
                    dataVerified = "1"; // Define como 1, para que o hover funcione
                }

                if (res.IS_READ === "1") { // 1 - Não Lido, Default()
                    classText = "font-bold";
                } else {
                    classText = "font-normal"; // 2 - Lido
                }


                $('#tbody').append('<tr><td><input type="checkbox" name="checkbox[]" class="checkbox_values" value="' + res.ID_MENSAGEM + '" data-read='+ res.IS_READ +' /></td><td class="mailbox-star"><i class="fa fa-star favoritar-msg '+ classStar +'" id="'+ res.ID_MENSAGEM +'" data-verified="'+ dataVerified +'"></i></td><td class="mailbox-name '+ classText +'"><a href="' + url_atual +'/mensagem/visualizarMensagemPorId?id=' + res.ID_MENSAGEM + '"> ' + res.USUARIO_ORIGEM + ' </a></td><td class="mailbox-subject"><span class="' + classText + '">' + res.TITULO + '</span> - Trying to find a solution to this problem... </td><td class="mailbox-attachment"></td><td class="mailbox-date">'+ tempo +'</td></tr>')
            }
            break;
    }
 
}

/**
 * Responsável por pegar a diferença entre os dias e formatar um variável de exibição para o tempo de envio da Mensagem
 * @param {string} dataDB 
 */
function diffData(dataDB) {
    let mes = ['Jan', 'Fev', 'Mar', 'Abr', 'Maio', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    let data1 = new Date(dataDB);
    let data2 = new Date();

    let diffTime = Math.abs(data2.getTime() - data1.getTime());
    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

    let minuto = data1.getMinutes();
    let hora   = data1.getHours();

    if (diffDays < 2) {

        if (minuto < 10) {
            minuto = '0'+minuto;
        }
        if (hora < 10) {
            hora = '0'+hora;
        }

        tempo = hora + ':' + minuto + ' de ' + data1.getDate() + ' ' +  mes[data1.getMonth()];
    } else {
        tempo = mes[data1.getMonth()]+' '+data1.getDate()
    }

    return tempo;
}



