<?php

/**
 * Classe para proteção contra CSRF
 */
class CSRF
{
    const HIDDEN_FORM_INPUT_NAME = "_token";
    const SESSION_KEY_NAME = "_csrf_token";

    public static function GenerateToken()
    {
        $token = md5( uniqid( microtime( true ) ) );

        if ( isset( $_SESSION ) )
        {
            $_SESSION[self::SESSION_KEY_NAME] = $token;
        }

        return $token;
    }


    public static function GenerateHiddenFormInput()
    {
        $token = self::GenerateToken();

        $input = '<input type="hidden" name="' . self::HIDDEN_FORM_INPUT_NAME . '" value="' . $token . '">';

        return $input;
    }


    public static function Check()
    {
        $postedToken = isset( $_POST[self::HIDDEN_FORM_INPUT_NAME] ) ? $_POST[self::HIDDEN_FORM_INPUT_NAME] : null;
        $sessionToken = $_SESSION[self::SESSION_KEY_NAME];

        // remove o token da sessão
        $_SESSION[self::SESSION_KEY_NAME] = null;

        if ( $postedToken != $sessionToken )
        {
            echo "Tentativa de ataque por CSRF";
            exit;
        }
    }
}