<div class="container text-center register-form">
    <div class="row">
        <h2 class="page-title text-center">Edit User</h2>
        <form method="post" class="col-xs-60 col-sm-35 center-block">
            <div class="row">
                <label>Name</label>
                <input name="name" value="<?= htmlspecialchars($user->name) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="email" type="email" value="<?= htmlspecialchars($user->email) ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input name="phone" value="<?= htmlspecialchars($user->phone) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="/members" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
