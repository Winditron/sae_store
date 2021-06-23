<div class="form-list">
    <h2>Bitte wählen Sie ein oder mehere Bilder aus!</h2>
    <form action="<?php echo $confirmUrl; ?>" method="POST" class="form-list-formular">

        <div class="list form-list-picture-selection">
            <?php foreach ($pictures as $picture): ?>
                <div class="picture">
                            <figure>
                                <?php echo $picture->getImgTag(); ?>
                            </figure>
                            <strong><?php echo $picture->name; ?></strong>
                            <div class="actions">
                                <label class="mark-picture" for="marked-pictures[<?php echo $picture->id; ?>]">
                                    <input type="checkbox" name="marked-pictures[<?php echo $picture->id; ?>]" id="marked-pictures[<?php echo $picture->id; ?>]">
                                    <div class="marker"></div>
                                </label>
                            </div>
                </div>
            <?php endforeach;?>
        </div>
        <div class="actions">
            <a href="<?php echo $abortUrl; ?>" class="btn danger fill">Abbrechen</a>
            <button type="submit" class="fill">Speichern</button>
        </div>
    </form>
</div>