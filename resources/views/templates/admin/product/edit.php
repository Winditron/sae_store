<div class="product-form">
    <form action="<?php echo BASE_URL; ?>/admin/product/<?php echo $product->id; ?>/edit/update" method="post">
        <h2 class="signup form-title">Bearbeitung des Produkts #<?php echo $product->id ?></h2>

            <div class="form-group ">
                <label for="name">Produktname:</label>
                <input type="text" id="name" name="name" value="<?php echo $product->name; ?>">
            </div>


            <div class="edit-gallery">
                <?php foreach ($product->pictures() as $picture): ?>
                    <div class="picture">
                        <figure>
                            <?php echo $picture->getImgTag(); ?>
                        </figure>
                        <div class="actions">
                            <button type="button" data-href="<?php echo BASE_URL . "/api/admin/product/{$product->id}/picture/{$picture->id}/unbind"; ?>" class="danger delete">&times;</button>
                        </div>
                    </div>
                <?php endforeach;?>
                    <div class="add"><a href="<?php echo BASE_URL . "/admin/product/{$product->id}/pictures/selection" ?>" class="btn">&plus;</a></div>
            </div>

            <div class="form-group ">
                <label for="slug">Slug:</label>
                <input type="text" id="slug" name="slug" value="<?php echo $product->slug; ?>">
            </div>

            <div class="form-group ">
                <label for="price">Preis:</label>
                <input type="text" id="price" name="price" value="<?php echo $product->formatPrice(); ?>">
            </div>

            <div class="form-group ">
                <label for="category">Kategorie:</label>
                <select name="category" id="category">
                    <option hidden>Bitte auswählen!</option>
                    <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" <?php echo ($product->category === $category->id) ? 'selected' : ''; ?>><?php echo $category->title; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group cl">
                <label for="watering">Wasserbedarf:</label>
                <select name="watering" id="watering">
                    <option hidden>Bitte auswählen!</option>
                    <?php foreach ($product->wateringValues() as $value): ?>
                            <option value="<?php echo $value; ?>" <?php echo ($product->watering === $value) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group ">
                <label for="sun_location">Standort:</label>
                <select name="sun_location" id="sun_location">
                    <option hidden>Bitte auswählen!</option>
                    <?php foreach ($product->sunlocationValues() as $value): ?>
                            <option value="<?php echo $value; ?>" <?php echo ($product->sun_location === $value) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group ">
                <label for="size">max. Größe: (cm)</label>
                <input type="text" id="size" name="size" value="<?php echo $product->size; ?>">
            </div>

            <div class="form-group ">
                <label for="stock">Lagerbestand:</label>
                <input type="text" id="stock" name="stock" value="<?php echo $product->stock; ?>">
            </div>

            <div class="form-group ">
                <label for="description">Beschreibung:</label>
                <textarea id="description" name="description"><?php echo $product->description; ?></textarea>
            </div>

        <button type="submit">Speichern</button>
    </form>
</div>
