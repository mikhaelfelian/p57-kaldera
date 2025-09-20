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
			<table class="table table-bordered mb-0 rounded-0" id="tfkTable" data-year="<?= (int)($year ?? $current) ?>">
				<thead>
					<tr>
						<th>Kumulatif</th>
						<?php foreach ($months as $label): ?>
							<th><?= $label ?></th>
						<?php endforeach; ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($mastersWithData as $masterData): 
						$master = $masterData['master'];
						$map = $masterData['details'];
					?>
					<tr data-master-id="<?= (int)$master['id'] ?>">
						<td><strong><?= esc($master['nama']) ?></strong></td>
						<?php foreach ($months as $k=>$label): $d = $map[$k] ?? ['id'=>null]; $val = isset($d['target_fisik']) ? (float)$d['target_fisik'] : 0; ?>
						<td><span class="editable" data-bulan="<?= $k ?>" data-field="fisik" data-id="<?= (int)($d['id'] ?? 0) ?>"><?= $val ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
						<?php endforeach; ?>
					</tr>
					<tr data-master-id="<?= (int)$master['id'] ?>">
						<td><strong><?= esc($master['tahapan']) ?></strong></td>
						<?php foreach ($months as $k=>$label): $d = $map[$k] ?? ['id'=>null]; $val = isset($d['target_keuangan']) ? (float)$d['target_keuangan'] : 0; ?>
						<td><span class="editable" data-bulan="<?= $k ?>" data-field="keu" data-id="<?= (int)($d['id'] ?? 0) ?>"><?= $val ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
						<?php endforeach; ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="text-right mt-3">
				<button type="button" class="btn btn-success rounded-0" id="btnDummySave">Simpan</button>
			</div>
		</div>
		<?php elseif (empty($items)): ?>
		<div class="alert alert-info mb-0">Belum ada master. Buat melalui aksi terpisah.</div>
		<?php else: ?>
		<div class="alert alert-warning mb-0">Pilih master dari dropdown di atas untuk mengedit data.</div>
		<?php endif; ?>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
(function(){
	// CSRF token management
	var csrfToken = '<?= csrf_token() ?>';
	var csrfHash = '<?= csrf_hash() ?>';
	
	// Test if we can make a simple AJAX call
	console.log('Page loaded, testing AJAX capability');
	
	// Test AJAX call to see if it works
	$.post('<?= base_url('tfk/update-cell') ?>', {
		id: 0,
		master_id: 1,
		bulan: 'feb',
		field: 'fisik',
		value: 123.45,
		year: 2025
	}, function(response) {
		console.log('Test AJAX successful:', response);
	}, 'json').fail(function(xhr, status, error) {
		console.error('Test AJAX failed:', xhr.responseText, status, error);
	});
	function makeInput(span){
		var value = span.text().trim();
		var input = $('<input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm rounded-0" />');
		input.val(value);
		span.hide();
		span.after(input);
		input.focus();
		function commit(){
			var newVal = parseFloat(input.val()||0);
			var masterId = span.closest('tr').data('master-id');
			
			// Check if master is selected
			if (!masterId || masterId <= 0) {
				toastr.error('Master ID tidak ditemukan!');
				input.remove(); 
				span.show();
				return;
			}
			
			var payload = {
				id: span.data('id')||0,
				master_id: masterId,
				bulan: span.data('bulan'),
				year: $('#tfkTable').data('year'),
				field: span.data('field'),
				value: newVal
			};
			console.log('Sending AJAX request to:', '<?= base_url('tfk/update-cell') ?>');
			console.log('Payload:', payload);
			$.post('<?= base_url('tfk/update-cell') ?>', payload, function(res){
				console.log('Response received:', res);
				if(res && res.ok){ 
					span.data('id', res.id); 
					span.text(newVal); 
					toastr.success('Data berhasil disimpan!');
				} else {
					console.error('Save failed:', res);
					toastr.error('Gagal menyimpan: ' + (res.message || 'Unknown error'));
				}
				input.remove(); span.show();
			}, 'json').fail(function(xhr, status, error){ 
				input.remove(); 
				span.show(); 
				console.error('AJAX Error:', xhr.responseText);
				console.error('Status:', status, 'Error:', error);
				if(xhr.status === 403 || xhr.responseText.includes('Forbidden')) {
					toastr.error('Session expired. Please refresh the page.');
					setTimeout(function() { location.reload(); }, 2000);
				} else {
					toastr.error('Gagal menyimpan: ' + error);
				}
			});
		}
		input.on('blur', commit);
		input.on('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); commit(); } });
	}
	$(document).on('click', '#tfkTable .editable', function(){ makeInput($(this)); });
	$(document).on('click', '#tfkTable .edit-icon', function(){ var span=$(this).siblings('span.editable').first(); if(span.length){ makeInput(span); } });
	
	// Save button functionality
	$('#btnDummySave').on('click', function(){
		var $btn = $(this);
		var originalText = $btn.text();
		
		console.log('Save button clicked');
		
		$btn.prop('disabled', true).text('Menyimpan...');
		
		// Collect all editable values
		var updates = [];
		$('#tfkTable .editable').each(function(){
			var $span = $(this);
			var $row = $span.closest('tr');
			var masterId = $row.data('master-id');
			var value = parseFloat($span.text().trim()) || 0;
			
		console.log('Processing cell:', {
			masterId: masterId,
			bulan: $span.data('bulan'),
			field: $span.data('field'),
			value: value,
			textValue: $span.text().trim()
		});
			
			if (masterId && masterId > 0) {
				updates.push({
					id: $span.data('id') || 0,
					master_id: masterId,
					bulan: $span.data('bulan'),
					year: $('#tfkTable').data('year'),
					field: $span.data('field'),
					value: value
				});
			}
		});
		
		console.log('Total updates to process:', updates.length);
		
		// Save all updates
		var promises = updates.map(function(update){
			var payload = {
				id: update.id,
				master_id: update.master_id,
				bulan: update.bulan,
				year: update.year,
				field: update.field,
				value: update.value
			};
			
			console.log('Bulk save - Sending to:', '<?= base_url('tfk/update-cell') ?>', 'Payload:', payload);
			return $.post('<?= base_url('tfk/update-cell') ?>', payload, null, 'json');
		});
		
		Promise.all(promises).then(function(results){
			console.log('Bulk save results:', results);
			$btn.prop('disabled', false).text(originalText);
			toastr.success('Semua data berhasil disimpan!');
		}).catch(function(error){
			$btn.prop('disabled', false).text(originalText);
			console.error('Bulk Save Error:', error);
			toastr.error('Gagal menyimpan data!');
		});
	});
})();
</script>
<?= $this->endSection() ?>

