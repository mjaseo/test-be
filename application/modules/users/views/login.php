<div class="container text-center register-form">
    <div class="row">
        <h2 class="page-title">User Login</h2>
        <?php if ($this->session->flashdata('success')): ?>
            <br><br>
            <div class="alert alert-success text-center" style="margin-top: 20px; margin: 0 auto; max-width: 670px;">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <br>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

        <form action="<?= site_url('log-in/authenticate'); ?>" method="POST" class="col-xs-60 col-sm-35 center-block">
            <div class="row">
                <input type="email" name="email" placeholder="Email*" required />
            </div>
            <div class="row">
                <input type="password" name="password" placeholder="Password*" required />
            </div>
            <div class="row">
                <button class="button">Login</button>
            </div>
        </form>
    </div>
</div>
