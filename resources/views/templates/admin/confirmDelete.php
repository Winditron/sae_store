<div class="confirm">
        <h2><?php echo $type; ?> wirklich löschen?<h2></h2>

    <div class="confirm-body">
        <h5 class="confirm-title">Wollen Sie dieses Element wirklich löschen?</h5>
        <p class="confirm-text">
            <?php echo "{$type}: {$title}"; ?>
        </p>
        <a href="<?php echo $confirmUrl; ?>" class="btn danger">Löschen!</a>
        <a href="<?php echo $abortUrl; ?>" class="btn">Nein, lieber doch nicht.</a>
    </div>
</div>