[X] - Concluído
[*] - Pendente/Desnecessário

[ ] Sistema Intranet
    [X] Usuarios
        [X] Login
            [X] Redirect dando conflito ao redirecionar
        [X] Logout
    [X] Usuarios / Profile
        [X] Completar Cadastro / Alterar Perfil
            [X] Imagem de perfil e perfil do usuario
                [X] Resize Image
                [*] Cropping Image
            [X] Cadastrar array de skills no banco de dados
            [X] Utilizar um botão customizado para upload file
            [X] Dá uma olhada na classe image manipulation class codeigniter
            [X] Alterar Imagem de Perfil
            [X] Colocar o input de habilidades como opção para inserir uma habilidade que não existe no select
                [X] Erro ao colocar um valor já existente, ele apaga os demais que estão no input.
                [X] Problema ao apertar o enter, ele redireciona para página que está sendo feito a requisição
        [X] Procurar por usuarios cadastros e retornar com limite
            [X] Paginação
            [X] Não aparecer na lista o usuário que está na sessão ativa / Logado
            [X] Utilizar o input number como per page do lista/usuario
        [X] Alterar Senha
        [X] Alterar Email
    [X] Perfil
        [X] CRUD AJAX com PHP e JQUERY
            [X] Adicionar
                [X] Problema ao apertar o enter, ele redireciona para página que está sendo feito a requisição
            [X] Deletar
            [X] Exibir
            [X] Alterar
            [X] Paginação
    [X] Endereço
        [X] CRUD AJAX com PHP e JQUERY
            [X] Adicionar
            [X] Deletar
            [X] Exibir
            [X] Alterar
            [X] Paginação
    [X] Instituição  
        [X] CRUD AJAX DataTables
            [X] Adicionar
            [X] Deletar
            [X] Exibir
            [X] Alterar
            [X] Paginação     
    [ ] Mensagem
        [X] Model Mensagem
        [X] Enviar Mensagem de um usuario para outro
            [X] Enviar Icons
            [*] Problema no input textBox que utiliza inpuToken, ao clicar no usuario para enviar mensagem, não popula o input
            [X] Ao enviar a mensagem com sucesso, os campos destinatário e titulo devem ser limpos
            [X] Deixar o input de email como autocomplete ou trazer uma lista de emails para um select
            [X] Segunda opçào, utilizar o input de email para selecionar vários emails
            [X] Terceira Opção, utilizar o input de email com imagem na caixa de sugestões de email
            [X] Enviar mensagem para multiplos usuários
                [*] Aumentar a caixa de sugestões de usuários do tokenInput na view enviarMensagem
        [X] Exibir todas as mensagens recebida na caixa de email
            [X] Paginação
            [X] Criar uma lógica para exibir há quanto tempo que a mensagem foi enviada
        [X] Exibir todas mensagens excluidas
        [X] Criar uma caixa de entrada de apenas mensagens enviadas
            [X] Exibir todas mensagens Enviadas
        [X] Deletar Mensagens para a lixeira
        [X] Deletar Mensangens da lixeira
        [*] Colocar o anexo na linha
        [X] Favoritas as mensagens
            [X] Exibir as mensagens Favoritadas
        [X] Marcar a mensagem como Lida e Não Lida
            [X] Alterar algum icon ou algo do tipo para definir como Lida ou Não Lida
        [ ] Deixa com que cada usuário tenha uma cópia de uma mensagem
        [ ] Responder a Mensagem recebida
            [ ] Pode colocar uma ckEditor dinâmico embaixo para responder
        [ ] Encaminhar as Mensagens recebida
        [X] Alterar o CKeditor para envio de vídeo
    [ ] Dashboard
        [ ] Quantidade de mensagens na caixa de entrada
        [ ] Quantidade de mensagens recebidas
            - SELECT COUNT(*) FROM MENSAGEM WHERE USUARIO_DESTINO = "mgk@teste.com" AND STATUS = 1
        [ ] Quantidade de mensagens enviadas pelo usuario
            - SELECT COUNT(*) FROM MENSAGEM WHERE USUARIO_ORIGEM = "mgk@teste.com" AND STATUS = 1
        [ ] Quantidade de mensagens deletadas
            - SELECT COUNT(*) FROM MENSAGEM WHERE STATUS = 2 AND (USUARIO_ORIGEM = "mgk@teste.com" OR USUARIO_DESTINO="mgk@teste.com");
        [ ] Quantidade de mensagens Favoritas e Não Favoritas
        [ ] Quantidade de mensagens Lidas e Não Lidas
        [ ] Histórico para quem você enviou mais mensagens e de quem você recebeu mais mensagens        
    [ ] Timeline
        [ ] Desenvolver uma timeline com fotos, mensagens e emotions   
    [ ] Definir nivel de acesso em algumas partes do sistema de acordo com o Perfil
    [ ] Pace page Loading example