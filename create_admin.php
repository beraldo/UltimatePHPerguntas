<?php
/*
 * Script para criar a conta do administrador.
 *
 * Se utilizar esse sistema em produção, execute este script e depois o remova, para que não seja acessível para outros usuários
 */

require_once "init.php";

$name = 'Administrador Geral do Ultimate PHPerguntas';
$nickname = 'Ultimate Admin';
$email = 'admin@ultimatephperguntas.com.br';
$password = 'admin';
$passwordHash = Hash::password( $password );
$status = \Models\User::STATUS_ACTIVE;
$admin = 1;
$date = date( 'Y-m-d H:i:s' );

$sql = "INSERT INTO users(name, nickname, email, password, status, admin, created_at, updated_at) VALUES(:name, :nickname, :email, :password, :status, :admin, :created_at, :updated_at)";

$DB = new DB;
$stmt = $DB->prepare( $sql );

$stmt->bindParam( ':name', $name );
$stmt->bindParam( ':nickname', $nickname );
$stmt->bindParam( ':email', $email );
$stmt->bindParam( ':password', $passwordHash );
$stmt->bindParam( ':status', $status, PDO::PARAM_INT );
$stmt->bindParam( ':admin', $admin );
$stmt->bindParam( ':created_at', $date );
$stmt->bindParam( ':updated_at', $date );

if ( $stmt->execute() )
{
    echo "Usuário admin criado com sucesso";
}
else
{
    echo "Erro ao criar usuário admin";
    echo "<br><br>";
    $error = $stmt->errorInfo();
    echo $error[2];
}