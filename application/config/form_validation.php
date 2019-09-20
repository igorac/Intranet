<?php

$config = array(
    'usuario/cadastro' => array(
        array(
            'field' => 'nome',
            'label' => 'Nome Completo',
            'rules' => 'required|trim|regex_match[/(\w.+\s).+/i]',
            'errors' => array(
                'required' => '* %s é obrigatório!',
                'regex_match' => '* %s necessita de duas ou mais palavras.'
            )
        ),
        array(
            'field' => 'login',
            'label' => 'Login',
            'rules' => 'required|trim|is_unique[usuario.login]',
            'errors' => array(
                'required'  => '* %s é obrigatório!',
                'is_unique' => '* %s já existe na base de dados.'
            )
        ),
        array(
            'field' => 'email',
            'label' => 'E-mail',
            'rules' => 'required|trim|valid_email|is_unique[usuario.email]',
            'errors' => array(
                'required' => '* %s é obrigatório!',
                'is_unique' => '* %s já existe na base de dados.'
            )
        ),
        array(
            'field' => 'senha',
            'label' => 'Senha',
            'rules' => 'required|trim|min_length[3]',
            'errors' => array(
                'required' => '* %s é obrigatório!',
                'min_length' => '* %s deve ser maior do que 2 caracteres'
            )
        ),
        array(
            'field' => 'confirmar-senha',
            'label' => 'Confirmar Senha',
            'rules' => 'required|matches[senha]',
            'errors' => array(
                'required' => '* %s é obrigatório!',
                'matches'  => '* %s deve corresponder com a senha'
            )
        )

    ),
    'usuario/login' => array(
        array(
            'field' => 'login',
            'label' => 'Login',
            'rules' => 'required|trim|callback_validar_login',
            'errors' => array(
                'required'      => '* %s é obrigatório!',
                'validar_login' => '* %s incorreto.'
            )
        ),
        array(
            'field' => 'senha',
            'label' => 'Senha',
            'rules' => 'required|trim|callback_validar_senha',
            'errors' => array(
                'required'      => '* %s é obrigatório!',
                'validar_senha' => '* %s incorreta.'
            )
        ),
    ),
    'perfil/cadastro' => array(
        array(
            'field' => 'perfil',
            'label' => 'Perfil',
            'rules' => 'required|trim|is_unique[perfil.perfil]',
            'errors' => array(
                'required'      => '* %s é obrigatório!',
                'is_unique' => '* %s já existe na base de dados.'
            )
        )
    ),
    'perfil/altera' => array(
        array(
            'field' => 'perfil',
            'label' => 'Perfil',
            'rules' => 'required|trim|is_unique[perfil.perfil]',
            'errors' => array(
                'required'      => '* %s é obrigatório!',
                'is_unique' => '* %s já existe na base de dados.'
            )
        ),
        array(
            'field' => 'id_perfil',
            'label' => 'Identificador do Perfil',
            'rules' => 'required|trim|is_natural_no_zero|callback_validar_idperfil',
            'errors'=> array(
                'required' => '* O %s é obrigatório!',
                'is_natural_no_zero' => '* O %s deve ser um valor natural diferente de zero.',
                'validar_idperfil' => '* O %s não existe na base de dados.'
            )
        )
    ),
    'perfil/deletar' => array(
        array(
            'field' => 'id_perfil',
            'label' => 'Identificador',
            'rules' => 'required|trim|is_natural_no_zero|callback_validar_idperfil',
            'errors'=> array(
                'required' => '* O Identificador é obrigatório.',
                'is_natural_no_zero' => '* O Identificador deve ser um valor natural diferente de zero.',
                'validar_idperfil'  => '* O Identificador não existe na base de dados.'
            )
        )
    ),
    'endereco/cadastro' => array(
        array(
            'field' => 'cep',
            'label' => 'Cep',
            'rules' => 'required|trim|callback_validaCep|integer',
            'errors' => array(
                'required' => '* O CEP é obrigatório.',
                'validaCep' => '* O CEP já existe na base de dados.',
                'integer' => '* O CEP precisa ser do tipo Inteiro.'
                
            )
        ),
        array(
            'field' => 'rua',
            'label' => 'Rua',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => '* O campo Rua é obrigatório.',
            )
        ),
        array(
            'field' => 'bairro',
            'label' => 'Bairro',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => '* O campo Bairro é obrigatório.'
            )
        ),
        array(
            'field' => 'cidade',
            'label' => 'Cidade',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => '* O campo Cidade é obrigatório.'
            )
        ),
        array(
            'field' => 'estado',
            'label' => 'Estado',
            'rules' => 'required|trim|exact_length[2]|regex_match[/^[A-Z]+$/]',
            'errors' => array(
                'required' => '* O campo estado é obrigatório.',
                'exact_length' => '* O campo estado precisa ser de 2 caracteres.',
                'regex_match'  => '* O campo estado precisa ser em caixa alta.'
            )
        )
    ),
    'endereco/alterar' => array(
        array(
            'field' => 'id_endereco',
            'label' => 'Identificador',
            'rules' => 'required|trim|is_natural_no_zero|callback_valida_IdEndereco',
            'errors' => array(
                'required' => '* O Identificador é obrigatório.',
                'is_natural_no_zero' => '* O Identificador deve ser um valor natural diferente de zero.',
                'valida_IdEndereco' => '* O Identificador não existe na base de dados.',
                
            )
        ),
        array(
            'field' => 'cep',
            'label' => 'Cep',
            'rules' => 'required|trim|integer|is_unique[endereco.cep]',
            'errors' => array(
                'required' => '* O CEP é obrigatório.',
                'integer' => '* O CEP precisa ser do tipo Inteiro.',
                'is_unique' => '* O CEP já existe na base de dados.'
            )
        ),
        array(
            'field' => 'rua',
            'label' => 'Rua',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => '* O campo Rua é obrigatório.',
            )
        ),
        array(
            'field' => 'bairro',
            'label' => 'Bairro',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => '* O campo Bairro é obrigatório.'
            )
        ),
        array(
            'field' => 'cidade',
            'label' => 'Cidade',
            'rules' => 'required|trim',
            'errors' => array(
                'required' => '* O campo Cidade é obrigatório.'
            )
        ),
        array(
            'field' => 'estado',
            'label' => 'Estado',
            'rules' => 'required|trim|exact_length[2]|regex_match[/^[A-Z]+$/]',
            'errors' => array(
                'required' => '* O campo estado é obrigatório.',
                'exact_length' => '* O campo estado precisa ser de 2 caracteres.',
                'regex_match'  => '* O campo estado precisa ser em caixa alta.'
            )
        ),
    ),
    'endereco/deletar' => array(
        array(
            'field' => 'id_endereco',
            'label' => 'Identificador',
            'rules' => 'required|trim|is_natural_no_zero|callback_valida_IdEndereco',
            'errors'=> array(
                'required' => '* O Identificador é obrigatório.',
                'is_natural_no_zero' => '* O Identificador deve ser um valor natural diferente de zero.',
                'valida_IdEndereco'  => '* O Identificador não existe na base de dados.'
            )
        )
    ),
    'instituto/cadastrar' => array(
        array(
            'field' => 'cnpj',
            'label' => 'CNPJ',
            'rules' => 'required|trim|is_unique[instituto.cnpj]',
            'errors'=> array(
                'required' => '* A instituto é obrigatório.',
                'is_unique'=> '* O CNPJ já existe na base de dados.'
            )
        ),
        array(
            'field' => 'instituto',
            'label' => 'Instituto',
            'rules' => 'required|trim',
            'errors'=> array(
                'required' => '* A instituto é obrigatório.'
            )
        ),
        array(
            'field' => 'endereco',
            'label' => 'Endereço',
            'rules' => 'required|trim|is_natural_no_zero|callback_valida_IdEndereco',
            'errors'=> array(
                'required' => '* O Endereço é obrigatório.',
                'is_natural_no_zero' => '* O Valor deve ser um número natural',
                'valida_IdEndereco' => '* O Endereço não existe na base de dados.'
            )
        ),
        array(
            'field' => 'tipo_ensino',
            'label' => 'Tipo de Ensino',
            'rules' => 'required|trim',
            'errors'=> array(
                'required' => '* O tipo de ensino é obrigatório.'
            )
        ),
        array(
            'field' => 'telefone',
            'label' => 'Telefone',
            'rules' => 'required|trim',
            'errors'=> array(
                'required' => '* O telefone é obrigatório.'
            )
        )

    ),
    'instituto/consultar' => array(
        array(
            'field' => 'id_inst',
            'label' => 'Identificador',
            'rules' => 'required|is_natural_no_zero|callback_validarIdInstituto',
            'errors'=> array(
                'required' => '* O Identificador é obrigatório',
                'is_natural_no_zero' => '* O Identificador deve ser um número natural [0 - 9]',
                'validarIdInstituto' => '* O Identificador não existe na base de dados.'
            )
        )
    ),
    'instituto/alterar' => array(
     
        array(
            'field' => 'id_inst',
            'label' => 'Identificador',
            'rules' => 'required|callback_validarIdInstituto|is_natural_no_zero',
            'errors'=> array(
                'required' => '* O Identificador é obrigatório',
                'is_natural_no_zero' => '* O Identificador deve ser um número natural [0 - 9]',
                'validarIdInstituto' => '* O Identificador não existe na base de dados.'
            )
        ),
        array(
            'field' => 'instituto',
            'label' => 'Instituto',
            'rules' => 'required|trim',
            'errors'=> array(
                'required' => '* O instituto é obrigatório.'
            )
        ),
        array(
            'field' => 'endereco',
            'label' => 'Endereço',
            'rules' => 'required|trim|is_natural_no_zero|callback_valida_IdEndereco',
            'errors'=> array(
                'required' => '* O Endereço é obrigatório.',
                'is_natural_no_zero' => '* O Valor deve ser um número natural',
                'valida_IdEndereco' => '* O Endereço não existe na base de dados.'
            )
        ),
        array(
            'field' => 'tipo_ensino',
            'label' => 'Tipo de Ensino',
            'rules' => 'required|trim',
            'errors'=> array(
                'required' => '* O tipo de ensino é obrigatório.'
            )
        ),
        array(
            'field' => 'telefone',
            'label' => 'Telefone',
            'rules' => 'required|trim',
            'errors'=> array(
                'required' => '* O telefone é obrigatório.'
            )
        )
    ),
    'instituto/cnpj' => array(
        array(
            'field' => 'cnpj',
            'label' => 'CNPJ',
            'rules' => 'required|trim|is_unique[instituto.cnpj]',
            'errors'=> array(
                'required' => '* O CNPJ é obrigatório.',
                'is_unique'=> '* O CNPJ já existe na base de dados.'
            )
        )
    ),
    'usuario/profile' => array(
        array(
            'field' => 'nome',
            'label' => 'Nome Completo',
            'rules' => 'required|trim|regex_match[/(\w.+\s).+/i]',
            'errors' => array(
                'required' => '* %s é obrigatório!',
                'regex_match' => '* %s necessita de duas ou mais palavras.'
            )
        ),
    ),
    'mensagem/enviar' => array(
        array(
            'field' => 'usuario_destino[]',
            'label' => 'Destinatário',
            'rules' => 'required|trim|callback_validarEmail',
            'errors' => array(
                'required'    => '* %s é obrigatório!',
                'validarEmail'   => '* %s não existe na base de dados.' 
            )
        ),
        array(
            'field' => 'titulo',
            'label' => 'Título',
            'rules' => 'required|trim',
            'errors' => array(
                'required'    => '* %s é obrigatório!',
            )
        ),
        array(
            'field' => 'editor1',
            'label' => 'Descrição',
            'rules' => 'required|trim',
            'errors' => array(
                'required'    => '* %s é obrigatório!',
            )
        ),
    ),
    'mensagem/enviar_especifico' => array(
        array(
            'field' => 'usuario_destino',
            'label' => 'Destinatário',
            'rules' => 'required|trim|callback_validarEmail',
            'errors' => array(
                'required'    => '* %s é obrigatório!',
                'validarEmail'   => '* %s não existe na base de dados.' 
            )
        ),
        array(
            'field' => 'titulo',
            'label' => 'Título',
            'rules' => 'required|trim',
            'errors' => array(
                'required'    => '* %s é obrigatório!',
            )
        ),
        array(
            'field' => 'editor1',
            'label' => 'Descrição',
            'rules' => 'required|trim',
            'errors' => array(
                'required'    => '* %s é obrigatório!',
            )
        ),
    ),
    'habilidade/cadastrar' => array(
        array(
            'field' => 'habilidade',
            'label' => 'Habilidade',
            'rules' => 'required|is_unique[HABILIDADE.HABILIDADE]|trim',
            'errors'=> array(
                'is_unique' => '* Já existe essa habilidade na base de dados.',
                'required' =>  '* O Campo habilidade é obrigatório.'
            )
        ),
    ),
    'mensagem/checkbox' => array(
        array(
            'field' => 'checados[]',
            'label' => 'Mensagem',
            'rules' => 'required|trim|is_natural_no_zero|callback_validarIdMensagem',
            'errors'=> array(
                'required' => 'É obrigatório que pelo menos 1 mensagem seja selecionada.',
                'is_natural_no_zero' => '* O Identificador deve ser um número natural [1-9].',
                'validarIdMensagem' => 'Uma ou mais Mensagem selecionada(s) não existe(m) na base de dados.'
            )
        )
    ),
    'usuario/alterarSenha' => array(
        array(
            'field' => 'senhaAntiga',
            'label' => 'Senha',
            'rules' => 'required|trim|min_length[3]|callback_validarSenha',
            'errors'=> array(
                'required' => '* A %s é obrigatório.',
                'min_length' => '* A %s deve ser maior do que 2 caracteres',
                'validarSenha' => '* A %s está incorreto.'
            )
        ),
        array(
            'field' => 'novaSenha',
            'label' => 'Nova Senha',
            'rules' => 'required|trim|min_length[3]',
            'errors'=> array(
                'required' => '* A %s é obrigatório.',
                'min_length' => '* A %s deve ser maior do que 2 caracteres',
            )
        ),
        array(
            'field' => 'confsenha',
            'label' => 'Confirmar Senha',
            'rules' => 'required|trim|min_length[3]|matches[novaSenha]',
            'errors'=> array(
                'required' => '* A %s é obrigatório.',
                'min_length' => '* A %s deve ser maior do que 2 caracteres',
                'matches'  => '* %s deve corresponder com a nova senha'
            )
        )
    ),
    'usuario/alterarEmail' => array(
        array(
            'field' => 'novoEmail',
            'label' => 'Email',
            'rules' => 'required|trim|valid_email|is_unique[USUARIO.EMAIL]',
            'errors'=> array(
                'required' => '* O %s é obrigatório.',
                'valid_email' => '* O %s deve ser um tipo válido.',
                'is_unique' => '* O %s já existe na base de dados.'
            )
        )
    ),
    'mensagem/favoritar_naoFavoritar' => array(
        array(
            'field' => 'checados',
            'label' => 'Identificador',
            'rules' => 'required|trim|is_natural_no_zero|callback_validarIdMensagem',
            'errors'=> array(
                'required' => '* O %s é obrigatório.',
                'is_natural_no_zero' => '* O %s deve ser um número natural [1-9].',
                'validarIdMensagem' => '* O %s não existe na base de dados.'
            )
        )
    ),
);