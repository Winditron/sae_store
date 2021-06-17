<form action="<?php echo $confirmUrl; ?>" method="POST">
    <div class="list picture-list">
        <?php foreach ($pictures as $picture): ?>
            <div class="picture">
                        <figure>
                            <?php echo $picture->getImgTag(); ?>
                        </figure>
                        <strong><?php echo $picture->name; ?></strong>
                        <div class="actions">
                            <input type="checkbox" name="marked-pictures[<?php echo $picture->id; ?>]" id="marked-pictures[<?php echo $picture->id; ?>]">
                        </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="actions">
        <a href="<?php echo $abortUrl; ?>" class="btn">Abbrechen</a>
        <button type="submit">Speichern</button>
    </div>
</form>