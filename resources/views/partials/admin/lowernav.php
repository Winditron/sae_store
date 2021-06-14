<?php
/**
 * Alle Admin Menüpunkte
 */
if (App\Models\User::isLoggedIn()): ?>
    <?php if (App\Models\User::getLoggedIn()->is_admin): ?>
        <div class="navbar-lower row">
            <a class="navlink" href="<?php echo BASE_URL . "/admin/products"; ?>">Produkte</a>
        </div>
    <?php endif;?>
<?php endif;?>
