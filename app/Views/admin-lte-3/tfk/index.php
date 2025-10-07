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
				<select name="year" class="form-control form-control-sm mr-3 rounded-0">
			<?php for ($y = $start; $y <= $end; $y++): ?>
				<option value="<?= $y ?>" <?= $y === $current ? 'selected' : '' ?>><?= $y ?></option>
			<?php endfor; ?>
		</select>
			<input type="hidden" name="year" value="<?= $current ?>">
				<label class="mr-2">Tahapan</label>
				<select name="tahapan" class="form-control form-control-sm rounded-0">
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
								foreach ($months as $k => $label):
									$val = 0; // Always start with 0, no hardcoded values
								?>
									<td class="text-center">
										<span class="editable" data-bulan="<?= $k ?>" data-field="fisik"
											data-id="0" data-value="<?= $val ?>"><?= format_angka($val, 2) ?></span> 
										<i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
									</td>
							<?php endforeach; ?>
						</tr>
							<tr>
								<td><strong>Target Keuangan (%)</strong></td>
								<?php 
								foreach ($months as $k => $label):
									$val = 0; // Always start with 0, no hardcoded values
								?>
									<td class="text-center">
										<span class="editable" data-bulan="<?= $k ?>" data-field="keu"
											data-id="0" data-value="<?= $val ?>"><?= format_angka($val, 2) ?></span> 
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

		// Format number similar to format_angka() helper with 2 decimal places
		function formatAngka(num) {
			if (num === null || num === undefined || isNaN(num)) return '0,00';
			return new Intl.NumberFormat('id-ID', {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			}).format(parseFloat(num));
		}

		// Store tahapan selection locally (don't save immediately)
		function storeTahapanSelection(tahapan) {
			var tahun = $('#tfkTable').data('year');
			
			// Update table data attribute for later use
			$('#tfkTable').data('tahapan', tahapan);
			
			console.log('Tahapan selection stored locally:', tahapan, 'for year:', tahun);
		}

		// Load existing data function - preserves staged changes
		function loadExisting() {
			var tahun = $('select[name="year"]').val();
			var tahapan = $('select[name="tahapan"]').val();
			
			console.log('Loading data for tahun:', tahun, 'tahapan:', tahapan);
			
			// Store tahapan selection locally
			storeTahapanSelection(tahapan);
			
			// Load data from database based on tahun and tahapan
			$.get('<?= base_url('tfk/get-data') ?>', {
				tahun: tahun,
				tahapan: tahapan
			}, function(res) {
				console.log('Received response:', res);
				if (res && res.ok) {
					if (res.data && Object.keys(res.data).length > 0) {
						// Update table with loaded data, but preserve staged changes
						updateTableWithDataPreserveStaged(res.data);
						console.log('Data loaded successfully for tahapan:', tahapan);
					} else {
						// No data found for this tahapan - reset non-staged cells to 0
						console.log('No data found for tahapan:', tahapan, '- resetting non-staged cells to 0');
						resetNonStagedCellsToZero();
					}
					if (res.csrf_hash) { csrfHash = res.csrf_hash; }
				} else {
					console.error('Server error:', res.message);
					toastr.error('Error: ' + (res.message || 'Unknown error'));
				}
			}, 'json').fail(function(xhr) {
				console.error('Failed to load data:', xhr.responseText);
				toastr.error('Gagal memuat data dari database');
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

		// Update table with loaded data but preserve staged changes
        function updateTableWithDataPreserveStaged(data) {
			console.log('Updating table with data (preserving staged):', data);
			
			// Update Target Fisik row (first row) - only if not staged
			$('#tfkTable tbody tr:first-child .editable').each(function() {
				var $cell = $(this);
				var bulan = $cell.data('bulan');
				
				// Only update if no staged changes
				if ($cell.data('staged') === undefined) {
					var value = data[bulan] ? data[bulan].target_fisik || 0 : 0;
					$cell.data('value', value).text(formatAngka(value));
					console.log('Updated fisik for bulan:', bulan, 'value:', value);
				} else {
					console.log('Preserved staged fisik for bulan:', bulan, 'staged:', $cell.data('staged'));
				}
			});

			// Update Target Keuangan row (second row) - only if not staged
			$('#tfkTable tbody tr:last-child .editable').each(function() {
				var $cell = $(this);
				var bulan = $cell.data('bulan');
				
				// Only update if no staged changes
				if ($cell.data('staged') === undefined) {
					var value = data[bulan] ? data[bulan].target_keuangan || 0 : 0;
					$cell.data('value', value).text(formatAngka(value));
					console.log('Updated keuangan for bulan:', bulan, 'value:', value);
				} else {
					console.log('Preserved staged keuangan for bulan:', bulan, 'staged:', $cell.data('staged'));
				}
			});
		}

		// Reset non-staged cells to 0 when no data found for tahapan
		function resetNonStagedCellsToZero() {
			console.log('Resetting non-staged cells to 0');
			
			// Reset Target Fisik row (first row) - only if not staged
			$('#tfkTable tbody tr:first-child .editable').each(function() {
				var $cell = $(this);
				var bulan = $cell.data('bulan');
				
				// Only reset if no staged changes
				if ($cell.data('staged') === undefined) {
					$cell.data('value', 0).text(formatAngka(0));
					console.log('Reset fisik for bulan:', bulan, 'to 0');
				} else {
					console.log('Preserved staged fisik for bulan:', bulan, 'staged:', $cell.data('staged'));
				}
			});

			// Reset Target Keuangan row (second row) - only if not staged
			$('#tfkTable tbody tr:last-child .editable').each(function() {
				var $cell = $(this);
				var bulan = $cell.data('bulan');
				
				// Only reset if no staged changes
				if ($cell.data('staged') === undefined) {
					$cell.data('value', 0).text(formatAngka(0));
					console.log('Reset keuangan for bulan:', bulan, 'to 0');
				} else {
					console.log('Preserved staged keuangan for bulan:', bulan, 'staged:', $cell.data('staged'));
				}
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

		// Bind dropdown change events - store tahapan locally, preserve values
		loadExisting();
		$('select[name="tahapan"]').on('change', function(){
			var tahapan = $(this).val();
			console.log('Tahapan dropdown changed to:', tahapan);
			
			// Store tahapan selection locally (don't save immediately)
			storeTahapanSelection(tahapan);
			
			// Load existing data for the new tahapan (preserving staged changes)
			loadExisting();
		});
		
		// Year dropdown change handler
		$('select[name="year"]').on('change', function(){
			var year = $(this).val();
			console.log('Year dropdown changed to:', year);
			
			// Update the table data attribute
			$('#tfkTable').data('year', year);
			
			// Load existing data for the new year (preserving staged changes)
			loadExisting();
		});

        // Save button functionality - save everything (tahapan + monthly changes + Target Nominal)
		$('#btnDummySave').on('click', function () {
			var $btn = $(this);
			var originalText = $btn.text();
			var tahun = $('select[name="year"]').val();
			var tahapan = $('select[name="tahapan"]').val();
			
            // Collect ONLY staged changes to avoid overwriting existing data with zeros
            var allData = {};
            var hasChanges = false;
            
            $('#tfkTable .editable').each(function () {
                var $span = $(this);
                var bulan = $span.data('bulan');
                var field = $span.data('field');
                var staged = $span.data('staged');
                
                if (staged !== undefined) {
                    var value = parseFloat(staged) || 0;
                    if (!allData[bulan]) { allData[bulan] = {}; }
                    allData[bulan][field] = value;
                    hasChanges = true;
                }
            });
            
            // Always allow save (even without changes) to persist tahapan selection
            console.log('Saving all data:', { tahun, tahapan, allData, hasChanges });
            console.log('Year from dropdown:', $('select[name="year"]').val());
            console.log('Tahapan from dropdown:', $('select[name="tahapan"]').val());
			
			// Save everything to database
			var payload = {
				tahun: tahun,
				tahapan: tahapan,
				data: allData,
				save_tahapan: true // Flag to indicate we want to save tahapan too
			};
			payload[csrfToken] = csrfHash;
			
			$btn.prop('disabled', true).text('Menyimpan...');
			
			$.post('<?= base_url('tfk/save-all') ?>', payload, function (res) {
				$btn.prop('disabled', false).text(originalText);
				if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
				
				if (res && res.ok) {
                    toastr.success('Semua data berhasil disimpan ke database!');
                    // Apply all values to UI and clear staging
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