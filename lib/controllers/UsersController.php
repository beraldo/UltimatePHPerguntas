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
 * Controller para gerenciar ações do usuário
 */
class UsersController
{
    /**
     * Formulário de registro de usuário
     */
    public static function create()
    {
        \View::make( 'user.create' );
    }


    /**
     * Painel de Controle do usuário
     */
    public static function controlPanel()
    {
        // restringe acesso a não logados
        \Auth::denyNotLoggedInUsers();

        $user = \Auth::user();

        \View::make( 'user.control-panel', compact( 'user' ) );
    }


    /**
     * Alteração de senha
     */
    public static function changePassword()
    {
        \Auth::denyNotLoggedInUsers();
        \CSRF::Check();

        $currentPassword = isset( $_POST['current_password'] ) ? $_POST['current_password'] : null;
        $newPassword1 = isset( $_POST['new_password1'] ) ? $_POST['new_password1'] : null;
        $newPassword2 = isset( $_POST['new_password2'] ) ? $_POST['new_password2'] : null;

        $user = \Auth::user();

        $hashedCurrentPassword = \Hash::password( $currentPassword );

        $errors = [];
        if ( $hashedCurrentPassword != $user->getPassword() )
        {
            $errors[] = 'Senha atual incorreta';
        }

        if ( $newPassword1 != $newPassword2 )
        {
            $errors[] = 'A confirmação da nova senha não coincide com a nova senha';
        }

        if ( count( $errors ) > 0 )
        {
            return \View::make( 'user.control-panel', compact( 'user', 'errors' ) );
        }

        $hasChangedPassword = $user->changePassword( $newPassword1 );

        if ( $hasChangedPassword )
        {
            $flashSuccessMessage = 'Senha alterada com sucesso';
            return \View::make( 'user.control-panel', compact( 'user', 'flashSuccessMessage' ) );
        }
        else
        {
            $flashErrorMessage = 'Erro ao alterar senha';
            return \View::make( 'user.control-panel', compact( 'user', 'flashErrorMessage' ) );
        }
    }


    /**
     * Registra o usuário
     */
    public static function store()
    {
        \CSRF::Check();

        $nickname = isset( $_POST['nickname'] ) ? $_POST['nickname'] : null;
        $email = isset( $_POST['email'] ) ? $_POST['email'] : null;
        $password = isset( $_POST['password'] ) ? $_POST['password'] : null;
        $passwordConfirmation = isset( $_POST['password_confirmation'] ) ? $_POST['password_confirmation'] : null;
        $hashedPassword = \Hash::password( $password );

        $hasErrors = false;
        $errorMessages = [];
        if ( $nickname == null )
        {
            $errorMessages[] = "Informe seu apelido";
            $hasErrors = true;
        }

        if ( $email == null )
        {
            $errorMessages[] = "Informe seu email";
            $hasErrors = true;
        }

        if ( $password == null )
        {
            $errorMessages[] = "Informe uma senha";
            $hasErrors = true;
        }

        if ( $passwordConfirmation == null )
        {
            $errorMessages[] = "Confirme sua senha";
            $hasErrors = true;
        }

        if ( $password != $passwordConfirmation )
        {
            $errorMessages[] = "Senhas não coincidem";
            $hasErrors = true;
        }

        if ( $hasErrors )
        {
            return \View::make( 'user.create', compact( 'errorMessages' ) );
        }


        $sql = "INSERT INTO users(name, nickname, email, password, status, admin, created_at, updated_at) VALUES(:name, :nickname, :email, :password, :status, :admin, :created_at, :updated_at)";

        $DB = new \DB;
        $stmt = $DB->prepare( $sql );

        $date = date( 'Y-m-d H:i:s' );
        $stmt->bindParam( ':name', $name );
        $stmt->bindParam( ':nickname', $nickname );
        $stmt->bindParam( ':email', $email );
        $stmt->bindParam( ':password', $hashedPassword );
        $stmt->bindValue( ':status', \Models\User::STATUS_ACTIVE, \PDO::PARAM_INT );
        $stmt->bindValue( ':admin', '0' );
        $stmt->bindParam( ':created_at', $date );
        $stmt->bindParam( ':updated_at', $date );

        if ( $stmt->execute() )
        {
            // em vez de apenas exibir uma mensagem de sucesso, faremos um redirecionamento.
            // isso é melhor pois evita que o usuário atualize a página e crie uma nova conta
            redirect( getBaseURL() . '/cadastro_finalizado' );
        }
        else
        {
            list( $error, $sgbdErrorCode, $sgbdErrorMessage ) = $stmt->errorInfo();
            
            if ( $sgbdErrorCode == 1062 )
            {
                // erro 1062 é o código do MySQL de violação de chave única
                // veja mais em: http://dev.mysql.com/doc/refman/5.5/en/error-messages-server.html
                
                if ( preg_match( "/for key .?nickname/iu", $sgbdErrorMessage ) )
                {
                    // nickname já em uso
                    $errorMessages[] = "Apelido já está em uso";
                }
                else
                {
                    // email já em uso
                    $errorMessages[] = "Email já está em uso";
                }
            }

            return \View::make( 'user.create', compact( 'errorMessages' ) );
        }
        
    }
}
