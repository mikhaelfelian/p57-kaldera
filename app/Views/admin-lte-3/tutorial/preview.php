<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between align-items-center rounded-0">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-<?= $tutorial->type === 'pdf' ? 'file-pdf text-danger' : 'video text-primary' ?>"></i>
                        <?= esc($tutorial->title) ?>
                    </h5>
                </div>
                <div>
                    <a href="<?= base_url('tutorial/' . $tutorial->type) ?>" class="btn btn-secondary btn-sm rounded-0">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="<?= base_url('tutorial/download/' . $tutorial->id) ?>" class="btn btn-success btn-sm rounded-0">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if ($tutorial->type === 'pdf'): ?>
                    <iframe src="<?= base_url('tutorial/download/' . $tutorial->id) ?>#toolbar=0&navpanes=0&scrollbar=1" 
                            style="width: 100%; height: 600px; border: 0;" 
                            class="rounded-0"></iframe>
                <?php else: ?>
                    <?php if (!empty($tutorial->link_url)): ?>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="<?= esc($tutorial->link_url) ?>" allowfullscreen style="width: 100%; height: 600px; border: 0;"></iframe>
                        </div>
                    <?php else: ?>
                        <video controls style="width: 100%; height: auto; max-height: 600px;" class="rounded-0">
                            <source src="<?= base_url('tutorial/download/' . $tutorial->id) ?>" type="video/mp4">
                            <source src="<?= base_url('tutorial/download/' . $tutorial->id) ?>" type="video/avi">
                            <source src="<?= base_url('tutorial/download/' . $tutorial->id) ?>" type="video/mov">
                            <source src="<?= base_url('tutorial/download/' . $tutorial->id) ?>" type="video/wmv">
                            Browser Anda tidak mendukung pemutaran video.
                        </video>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($tutorial->description)): ?>
                <div class="card-footer">
                    <h6>Deskripsi:</h6>
                    <p class="mb-0"><?= esc($tutorial->description) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
