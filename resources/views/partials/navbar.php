<nav class="navbar">
    <div class="navbar row">
        <div class=" col row">
            <div class="item"><stron class="brand"><?php echo Core\Config::get('app.appname'); ?></stron></div>
            <div class="item"><a href="<?php echo BASE_URL . "/Shop"; ?>" class="navlink col">Shop</a></div>
        </div>
        <div class="col-5 space"></div>
    <div class="col row">
        <div class=" item"><a class="navlink basket" href="<?php echo BASE_URL . "/basket"; ?>"><i class="ri-shopping-cart-fill basket"><div class="basket-count js_basket-count"><?php echo App\Models\Basket::count(); ?></div></i></a></div>
<?php
/**
 * Überprüfung ob user eigelogt ist
 * Wenn ja, zeige Logout und unterschiedliche Menüpunkte (Abhäging von is_admin)
 */
if (App\Models\User::isLoggedIn()): ?>
    <?php if (App\Models\User::getLoggedIn()->is_admin): ?>
			<div class="item"><a class="navlink" href="<?php echo BASE_URL . "/admin/dashboard"; ?>"><i class="ri-admin-line"></i></a></div>
	<?php else: ?>
            <div class="item"><a class="navlink" href="<?php echo BASE_URL . "/profile/dashboard"; ?>"><i class="ri-user-settings-line"></i></a></div>
    <?php endif;?>
            <div class="item"><a class="navlink" href="<?php echo BASE_URL . "/logout"; ?>"><i class="ri-logout-box-line"></i></i></a></div>
<?php else: ?>
            <div class="item"><a class="navlink" href="<?php echo BASE_URL . "/login"; ?>"><i class="ri-user-line"></i></a></div>
<?php endif;?>
        </div>
    </div>
</nav>
