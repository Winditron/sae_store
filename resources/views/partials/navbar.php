<nav class="navbar row">
    <div class=" col">
        <div class="brand"><?php echo Core\Config::get('app.appname'); ?></div>
        <a href="<?php echo BASE_URL . "/Shop"; ?>" class="navlink">Shop</a>
    </div>
    <div class="col">
        <?php if (App\Models\User::isLoggedIn()): ?>
            <a class="navlink" href="<?php echo BASE_URL . "/logout"; ?>"><i class="ri-logout-box-line"></i></i></a>
        <?php else: ?>
            <a class="navlink" href="<?php echo BASE_URL . "/login"; ?>"><i class="ri-user-line"></i></a>
        <?php endif;?>
    </div>
</nav>
