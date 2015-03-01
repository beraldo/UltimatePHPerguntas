<?php
/*
 * Este script faz parte do Projeto Prático do curso Ultimate PHP.
 *
 * Autor: Roberto Beraldo Chaiben
 *
 * Conheça o curso Ultimate PHP acessando http://www.ultimatephp.com.br
 */

require_once 'init.php';

$app = new \Slim\Slim();

// página inicial
$app->get('/', function ()
{
    \Controllers\PagesController::home();
});

// login
// GET: exibe formulário de login
// POST: processa o formulário de login
$app->map('/login', function()
{
    \Controllers\SessionsController::login();
})->via( 'GET', 'POST' );


// logout (sair)
$app->get( '/logout', function()
{
    \Controllers\SessionsController::logout();
});

// página de erro ao tentar acessar uma rota restrita a usuários logados
$app->get( '/erro-login-necessario', function()
{
    \View::make( 'erro-login-necessario' );
});


// página de erro ao tentar acessar uma rota restrita a administradores
$app->get( '/erro-nivel-admin-necessario', function()
{
    \View::make( 'erro-nivel-admin-necessario' );
});

// formulário de cadastro
$app->get( '/cadastro', function()
{
	\Controllers\UsersController::create();
});

// processa o formulário de cadastro
$app->post( '/cadastro_salvar', function()
{
    \Controllers\UsersController::store();
});

// página de cadastro finalizado
$app->get( '/cadastro_finalizado', function()
{
    \View::make( 'user.created' );
});

// painel do usuário
$app->get( '/painel-de-controle', function()
{
    \Controllers\UsersController::controlPanel();
});

// alteração de senha
$app->post( '/alterar-senha', function()
{
    \Controllers\UsersController::changePassword();
});


// formulário para cadastrar pergunta
$app->get( '/fazer-pergunta', function()
{
    \Controllers\QuestionsController::create();
});


// processa o envio da pergunta
$app->post( '/enviar-pergunta', function()
{
    \Controllers\QuestionsController::store();
});


// exibe a pergunta
$app->get( '/pergunta/:id', function ( $id )
{
    \Controllers\QuestionsController::show( $id );
});

// exibe o formulário de resposta
$app->get( '/responder/:question_id', function ( $question_id )
{
    \Controllers\AnswersController::create( $question_id );
});

$app->post( '/enviar-resposta', function()
{
    \Controllers\AnswersController::store();
});


// remover pergunta
$app->get( '/remover-pergunta/:question_id', function ( $question_id )
{
    \Controllers\QuestionsController::delete( $question_id );
});

// remover resposta
$app->get( '/remover-resposta/:answer_id/:question_id', function ( $answer_id, $question_id )
{
    \Controllers\AnswersController::delete( $answer_id, $question_id );
});


$app->run();

