<nav class="navbar">
    <div class="navbar row">
        <div class=" col">
            <div class="brand"><?php

echo Core\Config::get('app.appname'); ?></div>
            <a href="<?php echo BASE_URL . "/Shop"; ?>" class="navlink">Shop</a>
        </div>
    <div class="col">
    <a class="navlink basket" href="<?php echo BASE_URL . "/basket"; ?>"><i class="ri-shopping-cart-fill"></i><div class="basket-count js_basket-count"><?php echo App\Models\Basket::count(); ?></div></a>
<?php
/**
 * Überprüfung ob user eigelogt ist
 * Wenn ja, zeige Logout und unterschiedliche Menüpunkte (Abhäging von is_admin)
 */
if (App\Models\User::isLoggedIn()): ?>
    <?php if (App\Models\User::getLoggedIn()->is_admin): ?>
			<a class="navlink" href="<?php echo BASE_URL . "/admin/dashboard"; ?>"><i class="ri-admin-line"></i></a>
	<?php else: ?>
            <a class="navlink" href="<?php echo BASE_URL . "/profile/dashboard"; ?>"><i class="ri-user-settings-line"></i></a>
    <?php endif;?>
            <a class="navlink" href="<?php echo BASE_URL . "/logout"; ?>"><i class="ri-logout-box-line"></i></i></a>
<?php else: ?>
            <a class="navlink" href="<?php echo BASE_URL . "/login"; ?>"><i class="ri-user-line"></i></a>
<?php endif;?>
        </div>
    </div>
</nav>
