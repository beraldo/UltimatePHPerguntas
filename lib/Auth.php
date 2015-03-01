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


/**
 * Class para verificação de usuário logado e restrições de acesso
 */
class Auth
{
    /**
     * Retorna o usuário logado ou null se não estiver logado
     * @return mixed Objeto \Models\User do usuário logado ou null se não estiver logado
     */
    public static function user()
    {
        if ( ( $data = \Controllers\SessionsController::extractCookieInfo() ) != null )
        {
            $user = new \Models\User;
            $user->find( $data[ 'id' ] );

            return $user;
        }

        return null;
    }


    /**
     * Se o usuário não estiver logado, redireciona para a página de erro
     */
    public static function denyNotLoggedInUsers()
    {
        if ( ( $user = self::user() ) == null )
        {
            redirect( getBaseURL() . '/erro-login-necessario' );
        }
    }


    /**
     * Se o usuário não for administrador, redireciona para a página de erro
     */
    public static function denyNonAdminUser()
    {
        $user = self::user();
        
        if ( ! $user instanceof \Models\User || ! $user->isAdmin() )
        {
            redirect( getBaseURL() . '/erro-nivel-admin-necessario' );
        }
    }


    /**
     * Caso exista o cookie de autenticação, verifica se o token é válido
     */
    public static function checkUser()
    {
        $user = self::user();

        if ( $user == null )
        {
            \Log::warning( 'Usuário do cookie inválido. Removendo cookie' );
            
            // remove o cookie
            \Controllers\SessionsController::destroySessionCookie();
        }
        else
        {
            $data = \Controllers\SessionsController::extractCookieInfo();

            $cookieToken = isset( $data['token'] ) ? $data['token'] : null;
            $dbToken = $user->getToken();

            if ( $data == null || $cookieToken != $dbToken )
            {
                \Log::warning( 'Token do cookie inválido. Removendo cookie' );
                
                // remove o cookie
                \Controllers\SessionsController::destroySessionCookie();
                
                redirect( getBaseURL() );
            }
        }

    }
}