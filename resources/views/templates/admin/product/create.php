<div class="form-list">
    <h2 class="signup form-title">Anlegen eines Products?></h2>
    <form action="<?php echo BASE_URL; ?>/admin/product/create" method="post" class="form-list-formular">

            <div class="form-group ">
                <label for="name">Produktname:</label>
                <input type="text" id="name" name="name">
            </div>

            <div class="form-group ">
                <label for="slug">Slug:</label>
                <input type="text" id="slug" name="slug">
            </div>

            <div class="form-group ">
                <label for="price">Preis: €</label>
                <input type="text" id="price" name="price">
            </div>

            <div class="form-group ">
                <label for="category">Kategorie:</label>
                <select name="category" id="category">
                    <option hidden>Bitte auswählen!</option>
                    <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group cl">
                <label for="watering">Wasserbedarf:</label>
                <select name="watering" id="watering">
                    <option hidden>Bitte auswählen!</option>
                    <?php foreach (App\Models\Product::wateringValues() as $value): ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group ">
                <label for="sun_location">Standort:</label>
                <select name="sun_location" id="sun_location">
                    <option hidden>Bitte auswählen!</option>
                    <?php foreach (App\Models\Product::sunlocationValues() as $value): ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group ">
                <label for="size">max. Größe: (cm)</label>
                <input type="text" id="size" name="size" >
            </div>

            <div class="form-group ">
                <label for="stock">Lagerbestand:</label>
                <input type="text" id="stock" name="stock">
            </div>

            <div class="form-group ">
                <label for="description">Beschreibung:</label>
                <textarea id="description" name="description"></textarea>
            </div>

        <button type="submit">Speichern</button>
    </form>
</div>
