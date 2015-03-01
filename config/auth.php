<?php
/**
 * Ultimate PHPerguntas
 * 
 * Este script faz parte do Projeto Prático do curso Ultimate PHP.
 * O Ultimate PHP é um curso voltado para iniciantes e intermediários em PHP.
 * Conheça o curso Ultimate PHP acessando http://www.ultimatephp.com.br
 *
 * O projeto completo está disponível no Github: https://github.com/beraldo/UltimatePHPerguntas
 *
 * @author: Roberto Beraldo Chaiben
 * @package Ultimate PHPerguntas
 * @link http://www.ultimatephp.com.br
 */


/*
 * Configurações para autenticação de usuários
 */


// string aleatória que será concatenada às senhas, para gerar hashes mais seguros
// você pode alterar essa string como quiser, mas, depois do primeiro usuário criado, ela deve permanecer a mesma sempre
// 
// Para mais detalhes, veja http://en.wikipedia.org/wiki/Salt_(cryptography)
define( 'PASSWORD_SALT', '787Ultim4t3PHPergunta0925seA083dF0131' );


// nome do cookie que salvará os dados do usuário
define( 'AUTH_USER_COOKIE_NAME', 'auth_user' );
