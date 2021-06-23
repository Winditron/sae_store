<div class="checkout-list">
    <h2>Mit einem Konto oder als Gast bestellen?</h2>
    <div class="row user-or-guest">
        <div class="col login-window">
            <form action="<?php echo BASE_URL . '/checkout/1/login'; ?>" method="POST" class="login-form">
                <?php require __DIR__ . "/../../partials/authentication/loginform.php";?>
            </form>
        </div>
        <div class="col checkout-guest">
            <h2>Weiter als Gast?</h2>
            <a href="<?php echo BASE_URL . '/checkout/2'; ?>" class="btn submit">Als Gast weiter</a>
        </div>
    </div>
</div>