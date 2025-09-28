<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php helper('angka'); ?>
<?php 
$months = ['jan' => 'Januari', 'feb' => 'Februari', 'mar' => 'Maret', 'apr' => 'April', 'mei' => 'Mei', 'jun' => 'Juni', 'jul' => 'Juli', 'ags' => 'Agustus', 'sep' => 'September', 'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember'];
$tahapan = $tahapan ?? '';
$year = $year ?? date('Y');
?>

<div class="card">
	<div class="card-header d-flex align-items-center justify-content-between">
		<h3 class="card-title">Target Fisik & Keuangan</h3>
		<?= form_open('', ['method' => 'get', 'class' => 'form-inline']) ?>

		<?php
		$current = (int) ($year ?? date('Y'));
		$start = $current - 5;
		$end = $current + 5;
		$tahapanList = [
					'penetapan'   => 'Penetapan APBD',
					'pergeseran'  => 'Pergeseran',
					'perubahan'   => 'Perubahan APBD',
		];
		$currentTahapan = $tahapan ?? '';
		?>
		<label class="mr-2">Tahun</label>
				<select name="year" class="form-control form-control-sm mr-3" disabled readonly>
			<?php for ($y = $start; $y <= $end; $y++): ?>
				<option value="<?= $y ?>" <?= $y === $current ? 'selected' : '' ?>><?= $y ?></option>
			<?php endfor; ?>
		</select>
			<input type="hidden" name="year" value="<?= $current ?>">
				<label class="mr-2">Tahapan</label>
				<select name="tahapan" class="form-control form-control-sm">
			<?php foreach ($tahapanList as $key => $label): ?>
				<option value="<?= $key ?>" <?= $key === $currentTahapan ? 'selected' : '' ?>><?= $label ?></option>
			<?php endforeach; ?>
		</select>
		<?= form_close() ?>
	</div>
	<div class="card-body">
			<div class="table-responsive mt-2">
				<table class="table table-bordered mb-0 rounded-0" id="tfkTable"
						data-year="<?= (int) ($year ?? $current) ?>" data-tahapan="<?= esc($currentTahapan) ?>">
					<thead>
							<tr style="background-color: #3b6ea8; color: white;">
							<th>Kumulatif</th>
							<?php foreach ($months as $label): ?>
									<th class="text-center"><?= $label ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><strong>Target Fisik (%)</strong></td>
						<?php
								$defaultValues = [5, 10, 15, 20, 30, 40, 50, 60, 70, 80, 90, 100];
								foreach ($months as $k => $label):
									$val = $defaultValues[array_search($k, array_keys($months))] ?? 0;
								?>
									<td class="text-center">
										<span class="editable" data-bulan="<?= $k ?>" data-field="fisik"
											data-id="0" data-value="<?= $val ?>"><?= format_angka($val) ?></span> 
										<i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
									</td>
							<?php endforeach; ?>
						</tr>
							<tr>
								<td><strong>Target Keuangan (%)</strong></td>
								<?php 
								foreach ($months as $k => $label):
									$val = $defaultValues[array_search($k, array_keys($months))] ?? 0;
								?>
									<td class="text-center">
										<span class="editable" data-bulan="<?= $k ?>" data-field="keu"
											data-id="0" data-value="<?= $val ?>"><?= format_angka($val) ?></span> 
										<i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
									</td>
							<?php endforeach; ?>
						</tr>
					</tbody>
				</table>
				<div class="text-right mt-3">
					<button type="button" class="btn btn-success rounded-0" id="btnDummySave">Simpan</button>
				</div>
			</div>
	</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
#tfkTable th {
    background-color: #3b6ea8 !important;
    color: white !important;
    text-align: center;
}
#tfkTable td {
    text-align: center;
    vertical-align: middle;
}
.editable {
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 3px;
    transition: background-color 0.2s ease;
}
.editable.has-changes {
    background-color: #fff3cd !important;
    border: 1px solid #ffeaa7;
}
.editable:hover {
    background-color: #f8f9fa;
}
.edit-icon {
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s ease;
}
.edit-icon:hover {
    opacity: 1;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	(function () {
		// CSRF token management
		var csrfToken = '<?= csrf_token() ?>';
		var csrfHash = '<?= csrf_hash() ?>';

		// Format number similar to format_angka() helper
		function formatAngka(num) {
			if (num === null || num === undefined || isNaN(num)) return '0';
			return new Intl.NumberFormat('id-ID').format(parseFloat(num));
		}

		// Load existing data function (following master.php pattern)
		function loadExisting() {
			var tahun = $('#tfkTable').data('year');
			var tahapan = $('select[name="tahapan"]').val();
			
			console.log('Loading data for tahun:', tahun, 'tahapan:', tahapan);
			
			// Update table data attribute
			$('#tfkTable').data('tahapan', tahapan);
			
			// Load data from database based on tahun and tahapan
			$.get('<?= base_url('tfk/get-data') ?>', {
				tahun: tahun,
				tahapan: tahapan
			}, function(res) {
				console.log('Received response:', res);
				if (res && res.ok && res.data && Object.keys(res.data).length > 0) {
					// Update table with loaded data
					updateTableWithData(res.data);
					if (res.csrf_hash) { csrfHash = res.csrf_hash; }
					console.log('Data loaded successfully');
				} else {
					console.log('No data found for tahun:', tahun, 'tahapan:', tahapan);
					console.log('Response data:', res.data);
					// Reset all cells to 0 if no data found
					$('#tfkTable .editable').each(function(){
						$(this).data('value', 0).removeData('staged').removeClass('has-changes').text('0');
					});
				}
			}, 'json').fail(function(xhr) {
				console.error('Failed to load data:', xhr.responseText);
				toastr.error('Gagal memuat data dari database');
				// Reset all cells to 0 on error
				$('#tfkTable .editable').each(function(){
					$(this).data('value', 0).removeData('staged').removeClass('has-changes').text('0');
				});
			});
		}

		// Update table with loaded data
        function updateTableWithData(data) {
			console.log('Updating table with data:', data);
			
			// Update Target Fisik row (first row)
			$('#tfkTable tbody tr:first-child .editable').each(function() {
				var bulan = $(this).data('bulan');
				var value = data[bulan] ? data[bulan].target_fisik || 0 : 0;
                $(this).data('value', value).text(formatAngka(value));
                $(this).removeClass('has-changes').removeData('staged');
				console.log('Updated fisik for bulan:', bulan, 'value:', value, 'formatted:', formatAngka(value));
			});

			// Update Target Keuangan row (second row)
			$('#tfkTable tbody tr:last-child .editable').each(function() {
				var bulan = $(this).data('bulan');
				var value = data[bulan] ? data[bulan].target_keuangan || 0 : 0;
                $(this).data('value', value).text(formatAngka(value));
                $(this).removeClass('has-changes').removeData('staged');
				console.log('Updated keuangan for bulan:', bulan, 'value:', value, 'formatted:', formatAngka(value));
			});
		}

		function makeInput(span) {
			var value = (span.data('value') !== undefined) ? span.data('value') : span.text().trim();
			var input = $('<input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm rounded-0" />');
			input.val(value);
			span.hide();
			span.after(input);
			input.focus();
			function commit() {
				var newVal = parseFloat(input.val() || 0);
                // Stage locally and update displayed text to show the input value
                span.data('staged', newVal);
                span.addClass('has-changes');
                span.text(formatAngka(newVal)); // Show the formatted input value in the yellow cell
					input.remove();
					span.show();
			}
			input.on('blur', commit);
			input.on('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); commit(); } });
		}
		$(document).on('click', '#tfkTable .editable', function () { makeInput($(this)); });
		$(document).on('click', '#tfkTable .edit-icon', function () { var span = $(this).siblings('span.editable').first(); if (span.length) { makeInput(span); } });

		// Bind dropdown change events (following master.php pattern)
		loadExisting();
		$('select[name="tahapan"]').on('change', function(){
			console.log('Tahapan dropdown changed to:', $(this).val());
			loadExisting();
		});

        // Save button functionality - save only staged changes to database organized by year and tahapan
		$('#btnDummySave').on('click', function () {
			var $btn = $(this);
			var originalText = $btn.text();
			var tahun = $('#tfkTable').data('year');
			var tahapan = $('#tfkTable').data('tahapan');
			
            // Collect only staged changes
            var allData = {};
            var stagedCount = 0;
			$('#tfkTable .editable').each(function () {
				var $span = $(this);
                var staged = $span.data('staged');
                if(staged !== undefined){
                    var bulan = $span.data('bulan');
                    var field = $span.data('field');
                    if (!allData[bulan]) {
                        allData[bulan] = {};
                    }
                    allData[bulan][field] = parseFloat(staged)||0;
                    stagedCount++;
                }
            });
            if(stagedCount===0){ toastr.info('Tidak ada perubahan'); return; }
			
			// Save all data to database
				var payload = {
				tahun: tahun,
				tahapan: tahapan,
				data: allData
			};
			payload[csrfToken] = csrfHash;
			
			$btn.prop('disabled', true).text('Menyimpan...');
			
			$.post('<?= base_url('tfk/save-all') ?>', payload, function (res) {
				$btn.prop('disabled', false).text(originalText);
				if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
				
				if (res && res.ok) {
                    toastr.success('Semua data berhasil disimpan ke database!');
                    // Apply staged values to UI and clear staging
                    $('#tfkTable .editable').each(function(){
                        var $span = $(this);
                        var staged = $span.data('staged');
                        if(staged !== undefined){
                            $span.data('value', parseFloat(staged)||0).text(formatAngka(staged));
                            $span.removeData('staged');
                        }
                        $span.removeClass('has-changes');
                    });
				} else {
					toastr.error('Gagal menyimpan: ' + (res.message || 'Unknown error'));
				}
			}, 'json').fail(function (xhr) {
				$btn.prop('disabled', false).text(originalText);
				console.error('Save all error:', xhr.responseText);
				toastr.error('Gagal menyimpan data ke database!');
			});
		});
	})();
</script>
<?= $this->endSection() ?>