<div class="container text-center register-form">
    <div class="row">
        <h1 class="text-center">User Registration</h1>

        <?= validation_errors(); ?>

        <form action="<?= site_url('register/submit'); ?>" method="POST" class="col-xs-60 col-sm-35 center-block">
            <div class="row">
                <input type="text" name="name" placeholder="Name*" value="<?= set_value('name'); ?>" required><br><br>
            </div>

            <div class="row">
                <input type="email" name="email" placeholder="Email*" value="<?= set_value('email'); ?>" required><br><br>
            </div>

            <div class="row">
                <input type="text" name="phone" placeholder="Phone" value="<?= set_value('phone'); ?>"><br><br>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</div>

