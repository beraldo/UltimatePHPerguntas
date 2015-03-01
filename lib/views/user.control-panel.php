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
?>


<div class="row">
    <h1>Painel de Controle</h1>
</div>

<div class="row">
    <h2>Meus Dados</h2>
</div>

<div class="row">
    <div class="col-md-2">
        <strong>Apelido:</strong>
    </div>
    <div class="col-md-10">
        <?php echo $user->getNickname() ?>
    </div>
</div>


<div class="row">
    <div class="col-md-2">
        <strong>Email:</strong>
    </div>
    <div class="col-md-10">
        <?php echo $user->getEmail() ?>
    </div>
</div>

<div class="row">
    <h2>Alterar Senha</h2>

<?php if ( isset( $errors ) && count( $errors ) > 0 ): ?>
    <div class="alert alert-danger">
        <ul>
        <?php foreach ( $errors as $error ): ?>
            <li>
                <?php echo $error; ?>
            </li>
        <?php endforeach;; ?>
        </ul>
    </div>
<?php endif; ?>

    <form action="<?php echo getBaseURL() ?>/alterar-senha" method="post" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-2">
                <label for="current_password">Senha atual:</label>
            </div>
            <div class="col-md-10">
                <input type="password" name="current_password" id="current_password" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-2">
                <label for="new_password1">Nova senha:</label>
            </div>
            <div class="col-md-10">
                <input type="password" name="new_password1" id="new_password1" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-2">
                <label for="new_password2">Confirme a nova senha:</label>
            </div>
            <div class="col-md-10">
                <input type="password" name="new_password2" id="new_password2" class="form-control">
            </div>
        </div>

        <?php echo CSRF::GenerateHiddenFormInput() ?>

        <div class="form-group">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">
                <input type="submit" value="Alterar Senha" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>
