<div class="container text-center register-form">
    <div class="row">
        <h2 class="page-title text-center">Members List</h2>
        <br><br>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success text-center" style="margin-top: 20px; margin: 0 auto; max-width: 800px;">
                <?= $this->session->flashdata('success') ?>
            </div>
        <br><br>
        <?php endif; ?>
        <table class="table table-bordered table-striped" style="width:100%; margin: 0 auto; max-width: 800px;">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th style="width: 250px;">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->name) ?></td>
                        <td><?= htmlspecialchars($user->email) ?></td>
                        <td><?= htmlspecialchars($user->phone) ?></td>
                        <td style="width: 150px;">
                            <a href="/members/edit/<?= $user->id ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/members/delete/<?= $user->id ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            <a href="<?= site_url('/members/reset-password/' . $user->id) ?>" class="btn btn-sm btn-warning">Reset Password</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">No users found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        <br><br>
    </div>
</div>
