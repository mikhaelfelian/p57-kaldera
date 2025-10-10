<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">Master Unit Kerja</h3>
        <div class="d-flex align-items-center">
            <?php if (count($unitKerjaList) < 9): ?>
            <button type="button" class="btn btn-primary btn-sm rounded-0" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Unit Kerja
            </button>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body rounded-0">
        <!-- Search and Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control rounded-0" id="searchInput" placeholder="Cari unit kerja...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary rounded-0" type="button" id="searchBtn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <select class="form-control rounded-0" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <!-- Simple 2-column table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped rounded-0" id="unitKerjaTable">
                <thead style="background-color: #3b6ea8; color: white;">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 95%;">Unit Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($unitKerjaList)): ?>
                        <?php foreach ($unitKerjaList as $index => $unit): ?>
                        <tr>
                            <td class="text-center">
                                <strong><?= $index + 1 ?></strong>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1"><strong><?= $unit['nama_unit_kerja'] ?></strong></h6>
                                        <p class="mb-1"><small class="text-muted">Kode: <?= $unit['kode_unit_kerja'] ?></small></p>
                                        <span class="badge badge-<?= $unit['status'] == 'Aktif' ? 'success' : 'danger' ?> badge-sm">
                                            <?= $unit['status'] ?>
                                        </span>
                                    </div>
                                    <div class="btn-group-vertical" role="group">
                                        <button type="button" class="btn btn-info btn-sm rounded-0 edit-btn" 
                                                data-id="<?= $unit['id'] ?>" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm rounded-0 delete-btn" 
                                                data-id="<?= $unit['id'] ?>" data-name="<?= $unit['nama_unit_kerja'] ?>" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada data unit kerja</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="addModalLabel">Tambah Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Unit Kerja <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" name="nama_unit_kerja" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #17a2b8; color: white;">
                <h5 class="modal-title" id="editModalLabel">Edit Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Unit Kerja <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" name="nama_unit_kerja" id="edit_nama_unit_kerja" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info rounded-0">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #dc3545; color: white;">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus unit kerja <strong id="deleteUnitName"></strong>?</p>
                <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger rounded-0" id="confirmDelete">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.table th {
    background-color: #3b6ea8 !important;
    color: white !important;
    border: none;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    margin-right: 2px;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.badge {
    font-size: 0.8em;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    var csrfTokenName = '<?= config('Security')->tokenName ?>';
    var currentDeleteId = null;
    
    // Add form submit
    $('#addForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = $(this).serialize();
        formData += '&' + csrfTokenName + '=' + csrfHash;
        
        $.post('<?= base_url('pt-minerba/unit-kerja/create') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Unit kerja berhasil ditambahkan'); }
                $('#addModal').modal('hide');
                location.reload();
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal menambahkan unit kerja'); }
                if(res.errors) {
                    Object.keys(res.errors).forEach(function(field) {
                        $('[name="' + field + '"]').addClass('is-invalid');
                        $('[name="' + field + '"]').after('<div class="invalid-feedback">' + res.errors[field] + '</div>');
                    });
                }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal menambahkan unit kerja'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menambahkan unit kerja'); }
            }
        });
    });
    
    // Edit button click
    $(document).on('click', '.edit-btn', function(){
        var id = $(this).data('id');
        
        $.get('<?= base_url('pt-minerba/unit-kerja/get') ?>/' + id, function(res){
            if(res && res.ok){
                $('#edit_id').val(res.data.id);
                $('#edit_nama_unit_kerja').val(res.data.nama_unit_kerja);
                
                $('#editModal').modal('show');
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memuat data'); }
            }
        }, 'json').fail(function(){
            if(window.toastr){ toastr.error('Gagal memuat data'); }
        });
    });
    
    // Edit form submit
    $('#editForm').on('submit', function(e){
        e.preventDefault();
        
        var id = $('#edit_id').val();
        var formData = $(this).serialize();
        formData += '&' + csrfTokenName + '=' + csrfHash;
        
        $.post('<?= base_url('pt-minerba/unit-kerja/update') ?>/' + id, formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Unit kerja berhasil diperbarui'); }
                $('#editModal').modal('hide');
                location.reload();
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memperbarui unit kerja'); }
                if(res.errors) {
                    Object.keys(res.errors).forEach(function(field) {
                        $('#edit_' + field).addClass('is-invalid');
                        $('#edit_' + field).after('<div class="invalid-feedback">' + res.errors[field] + '</div>');
                    });
                }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal memperbarui unit kerja'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal memperbarui unit kerja'); }
            }
        });
    });
    
    // Delete button click
    $(document).on('click', '.delete-btn', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        currentDeleteId = id;
        $('#deleteUnitName').text(name);
        $('#deleteModal').modal('show');
    });
    
    // Confirm delete
    $('#confirmDelete').on('click', function(){
        if(currentDeleteId){
            $.post('<?= base_url('pt-minerba/unit-kerja/delete') ?>/' + currentDeleteId, {
                [csrfTokenName]: csrfHash
            }, function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    if(window.toastr){ toastr.success(res.message || 'Unit kerja berhasil dihapus'); }
                    $('#deleteModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal menghapus unit kerja'); }
                }
            }, 'json').fail(function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal menghapus unit kerja'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menghapus unit kerja'); }
                }
            });
        }
    });
    
    // Search functionality
    $('#searchBtn').on('click', function(){
        var keyword = $('#searchInput').val();
        if(keyword.trim()){
            $.post('<?= base_url('pt-minerba/unit-kerja/search') ?>', {
                keyword: keyword,
                [csrfTokenName]: csrfHash
            }, function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    updateTable(res.data);
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal mencari data'); }
                }
            }, 'json').fail(function(){
                if(window.toastr){ toastr.error('Gagal mencari data'); }
            });
        } else {
            location.reload();
        }
    });
    
    // Enter key search
    $('#searchInput').on('keypress', function(e){
        if(e.which == 13){
            $('#searchBtn').click();
        }
    });
    
    // Status filter
    $('#statusFilter').on('change', function(){
        var status = $(this).val();
        filterTable(status);
    });
    
    function updateTable(data){
        var tbody = $('#unitKerjaTable tbody');
        tbody.empty();
        
        if(data.length > 0){
            data.forEach(function(item, index){
                var statusBadge = item.status == 'Aktif' ? 
                    '<span class="badge badge-success">Aktif</span>' : 
                    '<span class="badge badge-danger">Tidak Aktif</span>';
                
                var row = '<tr>' +
                    '<td class="text-center"><strong>' + (index + 1) + '</strong></td>' +
                    '<td>' +
                        '<div class="d-flex justify-content-between align-items-start">' +
                            '<div>' +
                                '<h6 class="mb-1"><strong>' + item.nama_unit_kerja + '</strong></h6>' +
                                '<p class="mb-1"><small class="text-muted">Kode: ' + item.kode_unit_kerja + '</small></p>' +
                                statusBadge +
                            '</div>' +
                            '<div class="btn-group-vertical" role="group">' +
                                '<button type="button" class="btn btn-info btn-sm rounded-0 edit-btn" data-id="' + item.id + '" title="Edit">' +
                                    '<i class="fas fa-edit"></i>' +
                                '</button>' +
                                '<button type="button" class="btn btn-danger btn-sm rounded-0 delete-btn" data-id="' + item.id + '" data-name="' + item.nama_unit_kerja + '" title="Hapus">' +
                                    '<i class="fas fa-trash"></i>' +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                    '</td>' +
                '</tr>';
                tbody.append(row);
            });
        } else {
            tbody.append('<tr><td colspan="2" class="text-center">Tidak ada data ditemukan</td></tr>');
        }
    }
    
    function filterTable(status){
        $('#unitKerjaTable tbody tr').each(function(){
            var row = $(this);
            var statusText = row.find('td:eq(5)').text().trim();
            
            if(status === '' || statusText === status){
                row.show();
            } else {
                row.hide();
            }
        });
    }
    
    // Remove validation classes on input
    $('input, select, textarea').on('input change', function(){
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });
    
    // Clear form on modal hide
    $('#addModal').on('hidden.bs.modal', function(){
        $('#addForm')[0].reset();
        $('#addForm .is-invalid').removeClass('is-invalid');
        $('#addForm .invalid-feedback').remove();
    });
    
    $('#editModal').on('hidden.bs.modal', function(){
        $('#editForm .is-invalid').removeClass('is-invalid');
        $('#editForm .invalid-feedback').remove();
    });
})();
</script>
<?= $this->endSection() ?>
