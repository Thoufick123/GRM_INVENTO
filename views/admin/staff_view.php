<div class="page-header d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
    <div>
        <h2 class="mb-1"><i class="bi bi-person-vcard me-2 text-primary"></i>Staff Details</h2>
        <span class="text-muted">Read-only profile and access assignment</span>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= url('admin/staff') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Staff
        </a>
        <?php if (hasPermission('staff', 'edit')): ?>
            <a href="<?= url('admin/staff/edit/' . $staff['id']) ?>" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="card border shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold"><?= e($staff['full_name']) ?></h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Employee ID</div>
                <div><?= e($staff['emp_id'] ?? '—') ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Username</div>
                <div><?= e($staff['username'] ?? '—') ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Email</div>
                <div><?= e($staff['email'] ?? '—') ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Phone</div>
                <div><?= e($staff['phone'] ?? '—') ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Role</div>
                <div><?= e($staff['role_name'] ?? '—') ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Department</div>
                <div><?= e($staff['department'] ?? '—') ?></div>
            </div>
            <?php foreach ($assignments as $label => $value): ?>
                <div class="col-md-6 col-xl-4">
                    <div class="text-muted small fw-semibold"><?= e($label) ?></div>
                    <div><?= e($value) ?></div>
                </div>
            <?php endforeach; ?>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Reports Access</div>
                <div><?= !empty($staff['reports_access']) ? 'Enabled' : 'Disabled' ?></div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Status</div>
                <span class="badge <?= !empty($staff['is_active']) ? 'bg-success' : 'bg-secondary' ?>">
                    <?= !empty($staff['is_active']) ? 'Active' : 'Inactive' ?>
                </span>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="text-muted small fw-semibold">Created</div>
                <div><?= e($staff['created_at'] ?? '—') ?></div>
            </div>
        </div>
    </div>
</div>
