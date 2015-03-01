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
    <h1>Respondendo à PHPergunta <em><?php echo \XSS::filter( $question->getTitle() ) ?></em></h1>
</div>

<br><br>

<div class="row">
    <form action="<?php echo getBaseURL() ?>/enviar-resposta" method="post" class="form-horizontal">
        
        <div class="form-group">
            <div class="col-md-3">
                <label for="description">Sua resposta</label>
            </div>
            <div class="col-md-9">
                <textarea name="description" id="description" rows="15" class="form-control"></textarea>
            </div>
        </div>

        <?php echo \CSRF::GenerateHiddenFormInput() ?>
        <input type="hidden" name="question_id" value="<?php echo $question->getId(); ?>">

        <div class="form-group">
            <div class="col-md-3">

            </div>
            <div class="col-md-9">
                <input type="submit" value="Enviar resposta" class="btn btn-primary">
            </div>
        </div>

    </form>
</div>