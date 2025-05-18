<div class="container text-center register-form">
    <div class="row">
        <h2>Reset Password for <?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?></h2>
        <?php if ($this->session->flashdata('error')): ?>
            <br><br>
            <div class="alert alert-danger" style="margin-top: 20px; margin: 0 auto; max-width: 670px;"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>
        <form action="<?= site_url('members/process-reset-password/' . $user->id) ?>" method="post" class="col-xs-60 col-sm-35 center-block">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" required />
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirm" required />
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
            <a href="/members" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
