
<div class="row">
    <div class="text-center">
        <h1>Projeto Ultimate PHPerguntas</h1>
    </div>
</div>

<?php if ( isset( $user ) && $user != null ): ?>
<div class="row">
    <a href="<?php echo getBaseURL() ?>/fazer-pergunta" class="btn btn-primary">Criar Uma Nova Pergunta</a>
</div>
<?php endif; ?>

<div class="row">
    <h2>Últimas PHPerguntas</h2>
</div>

<div class="row">
<?php if ( isset( $questions ) && count( $questions ) > 0 ): ?>

    <table class="table table-striped">
        <thead>
            <th>Título</th>
            <th>Autor</th>
            <th>Data</th>
        </thead>
        <tbody>
        <?php foreach ( $questions as $question ): ?>
            <tr>
                <td>
                    <a href="<?php getBaseURL() ?>/pergunta/<?php echo $question->id ?>">
                        <?php echo \XSS::filter( $question->title ) ?>
                    </a>
                </td>
                <td>
                    <?php echo \XSS::filter( $question->user->getNickname() ) ?>
                </td>
                <td>
                    <?php echo date( 'd/m/Y H:i', strtotime( $question->created_at ) ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
<div class="alert alert-warning">
    Não há perguntas
</div>
<?php endif; ?>
</div>