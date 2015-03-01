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


namespace Controllers;

/**
 * Controller para gerenciar o login dos usuários
 */
class SessionsController
{
    /**
     * Exibe e processa o formulário de login
     */
    public static function login()
    {
        if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
        {
            // processar formulário de login
            self::processLoginForm();
        }
        else
        {
            // exibir formulário de login
            self::showLoginForm();
        }
    }


    /**
     * Faz logout do usuário
     * @return [type] [description]
     */
    public static function logout()
    {
        // remove o cookie de autenticação
        self::destroySessionCookie();

        // redireciona para a página inicial
        redirect( getBaseURL() );
    }


    /**
     * Busca as informações presentes no cookie de autenticação
     * @return array Array com os dados do cookie
     */
    public static function extractCookieInfo()
    {
        if ( ! isset( $_COOKIE[AUTH_USER_COOKIE_NAME] ) )
        {
            return null;
        }

        $data = unserialize( $_COOKIE[AUTH_USER_COOKIE_NAME] );

        return $data;
    }



    /**
     * Exibe o formulário de login
     */
    protected static function showLoginForm()
    {
        \View::make( 'login' );
    }


    /**
     * Processa o formulário de login
     */
    protected static function processLoginForm()
    {
        // proteção contra CSRF
        \CSRF::Check();

        $email = isset( $_POST['email'] ) ? $_POST['email'] : null;
        $password = isset( $_POST['password'] ) ? $_POST['password'] : null;
        $hashedPassword = \Hash::password( $password );

        $errors = [];
        if ( empty( $email ) )
        {
            $errors[] = 'Informe seu email';
        }

        if ( empty( $password ) )
        {
            $errors[] = 'Informe sua senha';
        }

        if ( count( $errors ) > 0 )
        {
            return \View::make( 'login', compact( 'errors' ) );
        }

        $DB = new \DB;
        $sql = "SELECT id, password, status FROM users WHERE email = :email";
        $stmt = $DB->prepare( $sql );
        $stmt->bindParam( ':email', $email );

        $stmt->execute();

        $rows = $stmt->fetchAll( \PDO::FETCH_OBJ );

        if ( count( $rows ) <= 0 )
        {
            $errors[] = 'Usuário não encontrado';
        }
        else
        {
            $user = $rows[0];

            if ( $hashedPassword != $user->password )
            {
                $errors[] = 'Senha incorreta';
            }
            elseif ( $user->status != \Models\User::STATUS_ACTIVE )
            {
                $errors[] = 'Ative sua conta antes de fazer login';
            }
            else
            {
                // busca os dados do usuário para criar os dados no cookie
                $objUser = new \Models\User;
                $objUser->find( $user->id );

                // gera um token de acesso
                $token = $objUser->generateToken();

                // salva o cookie com os dados do usuário
                self::saveSessionCookieForUser( $objUser );

                // redireciona para a página inicial
                redirect( getBaseURL() );
            }
        }

        
        if ( count( $errors ) > 0 )
        {
            return \View::make( 'login', compact( 'errors' ) );
        }
    }



    /**
     * Salva o cookie de autenticação
     * @param  \Models\User $user Objeto \Models\User do usuário logado
     */
    public static function saveSessionCookieForUser( \Models\User $user )
    {
        $cookieData = [
            'id' => $user->getId(),
            'token' => $user->getToken(),
        ];

        // 2592000 = 60 * 60 * 24 * 30, ou seja, 30 dias em segundos
        setcookie( AUTH_USER_COOKIE_NAME, serialize( $cookieData ), time() + 2592000 );
    }



    public static function destroySessionCookie()
    {
        setcookie( AUTH_USER_COOKIE_NAME, '', 1 );
    }


}
