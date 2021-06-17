<nav class="navbar">
    <div class="navbar row">
        <div class=" col">
            <div class="brand"><?php echo Core\Config::get('app.appname'); ?></div>
            <a href="<?php echo BASE_URL . "/Shop"; ?>" class="navlink">Shop</a>
        </div>
    <div class="col">
<?php
/**
 * Überprüfung ob user eigelogt ist
 * Wenn ja, zeige Logout und unterschiedliche Menüpunkte (Abhäging von is_admin)
 */
if (App\Models\User::isLoggedIn()): ?>
    <?php if (App\Models\User::getLoggedIn()->is_admin): ?>
			<a class="navlink" href="<?php echo BASE_URL . "/admin/dashboard"; ?>"><i class="ri-admin-line"></i></a>
	<?php else: ?>
            <a class="navlink" href="<?php echo BASE_URL . "/"; ?>"><i class="ri-user-settings-line"></i></a>
    <?php endif;?>
            <a class="navlink" href="<?php echo BASE_URL . "/logout"; ?>"><i class="ri-logout-box-line"></i></i></a>
<?php else: ?>
            <a class="navlink" href="<?php echo BASE_URL . "/login"; ?>"><i class="ri-user-line"></i></a>
<?php endif;?>
        </div>
    </div>
</nav>
