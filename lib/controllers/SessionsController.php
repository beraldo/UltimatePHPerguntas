<?php

namespace Controllers;

class SessionsController
{
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


    public static function logout()
    {
        self::destroySessionCookie();

        redirect( getBaseURL() );
    }


    public static function extractCookieInfo()
    {
        if ( ! isset( $_COOKIE[AUTH_USER_COOKIE_NAME] ) )
        {
            return null;
        }

        $data = unserialize( $_COOKIE[AUTH_USER_COOKIE_NAME] );

        return $data;
    }




    protected static function showLoginForm()
    {
        \View::make( 'login' );
    }

    protected static function processLoginForm()
    {
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
                $objUser = new \Models\User;
                $objUser->find( $user->id );

                $token = $objUser->generateToken();

                self::saveSessionCookieForUser( $objUser );

                redirect( getBaseURL() );
            }
        }

        
        if ( count( $errors ) > 0 )
        {
            return \View::make( 'login', compact( 'errors' ) );
        }
    }





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
