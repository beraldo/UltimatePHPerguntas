
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
