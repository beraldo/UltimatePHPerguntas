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
    <h1>Login</h1>
</div>

<?php if ( isset( $errors ) && count( $errors ) > 0 ): ?>
<div class="row">
    <div class="alert alert-danger">
        <ul>
        <?php foreach ( $errors as $error ): ?>
            <li>
                <?php echo $error ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <form method="post" action="<?php echo getCurrentURL() ?>" class="form-horizontal">
        <div class="form-group">
            <div class="col-md-3">
                <label for="email">Email: </label>
            </div>
            <div class="col-md-9">
                <input type="email" name="email" id="email" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-3">
                <label for="password">Senha: </label>
            </div>
            <div class="col-md-9">
                <input type="password" name="password" id="password" class="form-control">
            </div>
        </div>

        <?php echo CSRF::GenerateHiddenFormInput() ?>

        <div class="form-group">
            <div class="col-md-3">

            </div>
            <div class="col-md-9">
                <input type="submit" value="Acessar" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>
