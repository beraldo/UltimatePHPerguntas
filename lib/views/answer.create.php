
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