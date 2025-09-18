<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
	<div class="col-md-5">
		<div class="card">
			<div class="card-header"><h3 class="card-title">Tambah Master</h3></div>
			<div class="card-body">
				<form action="<?= base_url('tfk/master/store') ?>" method="post">
					<?= csrf_field() ?>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="nama" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Tahapan</label>
						<input type="text" name="tahapan" class="form-control" />
					</div>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="card">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h3 class="card-title">Daftar Master</h3>
			</div>
			<div class="card-body p-0">
				<table class="table table-striped mb-0">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama</th>
							<th>Tahapan</th>
							<th style="width:120px">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach (($items ?? []) as $i => $row): ?>
						<tr>
							<td><?= $i+1 ?></td>
							<td><?= esc($row['nama']) ?></td>
							<td><?= esc($row['tahapan']) ?></td>
							<td>
								<form action="<?= base_url('tfk/master/delete/' . (int)$row['id']) ?>" method="post" onsubmit="return confirm('Hapus data ini?')" class="d-inline">
									<?= csrf_field() ?>
									<button class="btn btn-xs btn-danger">Hapus</button>
								</form>
							</td>
						</tr>
						<?php endforeach; ?>
						<?php if (empty($items)): ?>
						<tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection() ?>
