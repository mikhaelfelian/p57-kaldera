<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
?>
<div class="row">
    <!-- Right Panel - Main Content -->
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">MASTER UNIT KERJA (UKP)</h3>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body rounded-0">
                <div class="table-responsive rounded-0">
                    <table class="table table-bordered rounded-0" id="ukpTable">
                        <thead style="background-color: #3b6ea8; color: white;">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Kode UKP</th>
                                <th>Nama UKP</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ukpList)): ?>
                                <?php foreach ($ukpList as $index => $ukp): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= $ukp['kode_ukp'] ?></td>
                                    <td><?= $ukp['nama_ukp'] ?></td>
                                    <td><?= $ukp['deskripsi'] ?: '-' ?></td>
                                    <td>
                                        <span class="badge badge-<?= $ukp['status'] == 'aktif' ? 'success' : 'danger' ?>">
                                            <?= ucfirst($ukp['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning rounded-0" onclick="editUkp(<?= $ukp['id'] ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger rounded-0" onclick="deleteUkp(<?= $ukp['id'] ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Master UKP</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode UKP <span class="text-danger">*</span></label>
                        <input type="text" name="kode_ukp" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama UKP <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ukp" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control rounded-0" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control rounded-0" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Edit Master UKP</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Kode UKP <span class="text-danger">*</span></label>
                        <input type="text" name="kode_ukp" id="edit_kode_ukp" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama UKP <span class="text-danger">*</span></label>
                        <input type="text" name="nama_ukp" id="edit_nama_ukp" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" class="form-control rounded-0" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" id="edit_status" class="form-control rounded-0" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-0">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.table th {
    background-color: #3b6ea8 !important;
    color: white !important;
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
    
    // Add form submission
    $('#addForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append(csrfToken, csrfHash);
        
        $.ajax({
            url: '<?= base_url('pt/master/ukp/create') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                if(response.ok){
                    if(window.toastr){ toastr.success(response.message); }
                    $('#addModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(response.message); }
                }
                if(response.csrf_hash){ csrfHash = response.csrf_hash; }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan data'); }
                    if(data.csrf_hash){ csrfHash = data.csrf_hash; }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menyimpan data'); }
                }
            }
        });
    });
    
    // Edit function
    window.editUkp = function(id){
        $.get('<?= base_url('pt/master/ukp/get/') ?>' + id, function(response){
            if(response.ok){
                $('#edit_id').val(response.data.id);
                $('#edit_kode_ukp').val(response.data.kode_ukp);
                $('#edit_nama_ukp').val(response.data.nama_ukp);
                $('#edit_deskripsi').val(response.data.deskripsi);
                $('#edit_status').val(response.data.status);
                $('#editModal').modal('show');
            } else {
                if(window.toastr){ toastr.error(response.message); }
            }
            if(response.csrf_hash){ csrfHash = response.csrf_hash; }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(window.toastr){ toastr.error(data.message || 'Gagal mengambil data'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal mengambil data'); }
            }
        });
    };
    
    // Edit form submission
    $('#editForm').on('submit', function(e){
        e.preventDefault();
        
        var id = $('#edit_id').val();
        var formData = new FormData(this);
        formData.append(csrfToken, csrfHash);
        
        $.ajax({
            url: '<?= base_url('pt/master/ukp/update/') ?>' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                if(response.ok){
                    if(window.toastr){ toastr.success(response.message); }
                    $('#editModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(response.message); }
                }
                if(response.csrf_hash){ csrfHash = response.csrf_hash; }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupdate data'); }
                    if(data.csrf_hash){ csrfHash = data.csrf_hash; }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupdate data'); }
                }
            }
        });
    });
    
    // Delete function
    window.deleteUkp = function(id){
        if(confirm('Apakah Anda yakin ingin menghapus data ini?')){
            $.post('<?= base_url('pt/master/ukp/delete/') ?>' + id, {
                [csrfToken]: csrfHash
            }, function(response){
                if(response.ok){
                    if(window.toastr){ toastr.success(response.message); }
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(response.message); }
                }
                if(response.csrf_hash){ csrfHash = response.csrf_hash; }
            }, 'json').fail(function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(window.toastr){ toastr.error(data.message || 'Gagal menghapus data'); }
                    if(data.csrf_hash){ csrfHash = data.csrf_hash; }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menghapus data'); }
                }
            });
        }
    };
    
    // Reset forms when modals are closed
    $('#addModal').on('hidden.bs.modal', function(){
        $('#addForm')[0].reset();
    });
    
    $('#editModal').on('hidden.bs.modal', function(){
        $('#editForm')[0].reset();
    });
})();
</script>
<?= $this->endSection() ?>
