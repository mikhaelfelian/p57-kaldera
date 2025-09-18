<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php $months = ['jan'=>'Januari','feb'=>'Februari','mar'=>'Maret','apr'=>'April','mei'=>'Mei','jun'=>'Juni','jul'=>'Juli','ags'=>'Agustus','sep'=>'September','okt'=>'Oktober','nov'=>'November','des'=>'Desember']; ?>
<div class="card">
	<div class="card-header d-flex align-items-center justify-content-between">
		<h3 class="card-title">Target Fisik & Keuangan</h3>
		<form class="form-inline" method="get">
			<?php $current = (int)($year ?? date('Y')); $start=$current-5; $end=$current+5; ?>
			<label class="mr-2">Tahun</label>
			<select name="year" class="form-control form-control-sm" onchange="this.form.submit()">
				<?php for($y=$start;$y<=$end;$y++): ?>
				<option value="<?= $y ?>" <?= $y===$current?'selected':'' ?>><?= $y ?></option>
				<?php endfor; ?>
			</select>
		</form>
	</div>
	<div class="card-body">
		<?php if (!empty($items)): ?>
		<div class="table-responsive mt-2">
			<table class="table table-bordered mb-0" id="tfkTable" data-master-id="<?= (int)($masterId ?? 0) ?>" data-year="<?= (int)$current ?>">
				<thead>
					<tr>
						<th>Kumulatif</th>
						<?php foreach ($months as $label): ?>
							<th><?= $label ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php $map = $details ?? []; ?>
					<tr>
						<td><strong><?= esc($selectedMaster['nama'] ?? 'Target Fisik (%)') ?></strong></td>
						<?php foreach ($months as $k=>$label): $d = $map[$k] ?? ['id'=>null]; $val = isset($d['fisik']) ? (float)$d['fisik'] : 0; ?>
						<td><span class="editable" data-bulan="<?= $k ?>" data-field="fisik" data-id="<?= (int)($d['id'] ?? 0) ?>"><?= $val ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
						<?php endforeach; ?>
					</tr>
					<tr>
						<td><strong><?= esc($selectedMaster['tahapan'] ?? 'Target Keuangan (%)') ?></strong></td>
						<?php foreach ($months as $k=>$label): $d = $map[$k] ?? ['id'=>null]; $val = isset($d['keu']) ? (float)$d['keu'] : 0; ?>
						<td><span class="editable" data-bulan="<?= $k ?>" data-field="keu" data-id="<?= (int)($d['id'] ?? 0) ?>"><?= $val ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
						<?php endforeach; ?>
					</tr>
				</tbody>
			</table>
			<div class="text-right mt-3">
				<button type="button" class="btn btn-success" id="btnDummySave">Simpan</button>
			</div>
		</div>
		<?php else: ?>
		<div class="alert alert-info mb-0">Belum ada master. Buat melalui aksi terpisah.</div>
		<?php endif; ?>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
	function makeInput(span){
		var value = span.text().trim();
		var input = $('<input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm" />');
		input.val(value);
		span.hide();
		span.after(input);
		input.focus();
		function commit(){
			var newVal = parseFloat(input.val()||0);
			var payload = {
				<?= json_encode(csrf_token()) ?>: '<?= csrf_hash() ?>',
				id: span.data('id')||0,
				master_id: $('#tfkTable').data('master-id'),
				bulan: span.data('bulan'),
				year: $('#tfkTable').data('year'),
				field: span.data('field'),
				value: newVal
			};
			$.post('<?= base_url('tfk/update-cell') ?>', payload, function(res){
				if(res && res.ok){ span.data('id', res.id); span.text(newVal); }
				input.remove(); span.show();
			}, 'json').fail(function(){ input.remove(); span.show(); alert('Gagal menyimpan'); });
		}
		input.on('blur', commit);
		input.on('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); commit(); } });
	}
	$(document).on('click', '#tfkTable .editable', function(){ makeInput($(this)); });
	$(document).on('click', '#tfkTable .edit-icon', function(){ var span=$(this).siblings('span.editable').first(); if(span.length){ makeInput(span); } });
})();
</script>
<?= $this->endSection() ?>

