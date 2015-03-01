
<div class="row">
    <h1><?php echo \XSS::filter( $question->getTitle() ) ?></h1>

    <?php if ( $user instanceof \Models\User && $user->isAdmin() ): ?>
        <a href="<?php getBaseURL() ?>/remover-pergunta/<?php echo $question->getId() ?>" class="btn btn-danger btn-sm">Remover Pergunta</a>
    <?php endif; ?>
</div>

<div class="row">
    <br><br>
    <p><em>Pergunta feita por <?php echo nl2br( \XSS::filter( $question->user->getNickname() ) ) ?>, em <?php echo $question->getCreatedAt()->format( 'd/m/Y' ) ?></em></p>
</div>

<div class="row">
    <br><br>
    <?php echo \XSS::filter( $question->getDescription() ) ?>
</div>



<h2>Respostas</h2>

<?php if ( isset( $answers ) && count( $answers ) > 0 ): ?>

<p><strong><?php echo count( $answers ) ?></strong> resposta(s) à esta pergunta</p>

<?php foreach ( $answers as $answer ): ?>

<div class="row answer-row">
    <div class="col-md-3">
        <?php echo \XSS::filter( $answer->user->getNickname() ) ?>

        <br><br>

        <em>em <?php echo date( 'd/m/Y H:i', strtotime( $answer->created_at ) ) ?></em>

        <?php if ( $user instanceof \Models\User && $user->isAdmin() ): ?>
            <br><br>
            <a href="<?php echo getBaseURL() ?>/remover-resposta/<?php echo $answer->id ?>/<?php echo $question->getId() ?>" class="btn btn-danger btn-xs">Remover Resposta</a>
        <?php endif; ?>
    </div>

    <div class="col-md-9">
        <?php echo nl2br( \XSS::filter( $answer->description ) ) ?>
    </div>
</div>



<?php endforeach;; ?>

<?php else: ?>
<div class="alert alert-warning">
    Não há respostas para esta pergunta
</div>
<?php endif; ?>


<br>


<?php if ( $user instanceof \Models\User ): ?>
<div class="row">
    <br><br>
    <a href="<?php echo getBaseURL() ?>/responder/<?php echo $question->getId() ?>" class="btn btn-primary">Responder</a>

    <a href="<?php echo getBaseURL() ?>/fazer-pergunta" class="btn btn-default">Criar Uma Nova Pergunta</a>
</div>
<?php endif; ?>

