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
    <h1>Crie a sua PHPerguntas</h1>
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



<form action="<?php getBaseURL() ?>/enviar-pergunta" method="post" class="form-horizontal">
    
    <div class="form-group">
        <div class="col-md-3">
            <label for="title">Título da Pergunta</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="title" id="title" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-3">
            <label for="description">Pergunta completa</label>
        </div>
        <div class="col-md-9">
            <textarea name="description" id="description" rows="10" class="form-control"></textarea>
        </div>
    </div>

    <?php echo \CSRF::GenerateHiddenFormInput() ?>

    <div class="form-group">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">
            <input type="submit" value="Enviar pergunta" class="btn btn-primary">
        </div>
    </div>

</form>
