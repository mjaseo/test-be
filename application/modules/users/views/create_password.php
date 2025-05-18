<div class="container text-center register-form">
    <div class="row">
        <h1 class="text-center">Create Password</h1>

        <?= validation_errors(); ?>

        <form method="POST" class="col-xs-60 col-sm-35 center-block">
            <div class="row">
                <input type="password" name="password" placeholder="Password*" required><br><br>
            </div>
            <button type="submit">Save Password</button>
        </form>
    </div>
</div>
