<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $statusList = [
        'Aktif' => 'Aktif',
        'Tidak Aktif' => 'Tidak Aktif'
    ];
?>
<div class="row">
    <!-- Right Panel - Main Content -->
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">MASTER UNIT KERJA PEMERINTAH (UKP)</h3>
                <div class="d-flex align-items-center">
                    <span class="text-success font-weight-bold mr-3">Master Data</span>
                    <button type="button" class="btn btn-primary btn-sm rounded-0" data-toggle="modal" data-target="#addModal">
                        <i class="fas fa-plus"></i> Tambah Data
                    </button>
                </div>
            </div>
            <div class="card-body rounded-0">
                <!-- Search Form -->
                <form method="get" id="searchForm" class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control rounded-0" placeholder="Cari berdasarkan Kode, Nama UKP, atau Kepala UKP..." value="<?= $search ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary rounded-0">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="text-muted">Total: <?= $totalRecords ?> data</span>
                        </div>
                    </div>
                </form>

                <!-- Data Table -->
                <div class="table-responsive rounded-0">
                    <table class="table table-bordered table-striped rounded-0">
                        <thead style="background-color: #3b6ea8; color: white;">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Kode UKP</th>
                                <th>Nama UKP</th>
                                <th>Kepala UKP</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($ukpList)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($ukpList as $index => $ukp): ?>
                            <tr>
                                <td class="text-center"><?= $offset + $index + 1 ?></td>
                                <td class="font-weight-bold"><?= $ukp->kode_unit_kerja ?></td>
                                <td><?= $ukp->nama_unit_kerja ?></td>
                                <td><?= $ukp->kepala_unit_kerja ?: '-' ?></td>
                                <td><?= $ukp->telepon ?: '-' ?></td>
                                <td>
                                    <span class="badge badge-<?= $ukp->status === 'Aktif' ? 'success' : 'danger' ?>">
                                        <?= $ukp->status ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm rounded-0" onclick="viewData(<?= $ukp->id ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm rounded-0" onclick="editData(<?= $ukp->id ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm rounded-0" onclick="deleteData(<?= $ukp->id ?>, '<?= $ukp->nama_ukp ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>&search=<?= $search ?>">Previous</a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= $search ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>&search=<?= $search ?>">Next</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data UKP</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="addForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kode Unit Kerja <span class="text-danger">*</span></label>
                                <input type="text" name="kode_unit_kerja" class="form-control rounded-0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control rounded-0" required>
                                    <option value="">Pilih Status</option>
                                    <?php foreach ($statusList as $key => $label): ?>
                                    <option value="<?= $key ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <input type="text" name="nama_unit_kerja" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Alamat</label>
                        <textarea name="alamat" class="form-control rounded-0" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Telepon</label>
                                <input type="text" name="telepon" class="form-control rounded-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Email</label>
                                <input type="email" name="email" class="form-control rounded-0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Website</label>
                                <input type="url" name="website" class="form-control rounded-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kepala Unit Kerja</label>
                                <input type="text" name="kepala_unit_kerja" class="form-control rounded-0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">NIP Kepala</label>
                        <input type="text" name="nip_kepala" class="form-control rounded-0">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <textarea name="keterangan" class="form-control rounded-0" rows="3"></textarea>
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
                <h5 class="modal-title">Edit Data UKP</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="editForm">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kode Unit Kerja <span class="text-danger">*</span></label>
                                <input type="text" name="kode_unit_kerja" id="edit_kode_unit_kerja" class="form-control rounded-0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-control rounded-0" required>
                                    <option value="">Pilih Status</option>
                                    <?php foreach ($statusList as $key => $label): ?>
                                    <option value="<?= $key ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Unit Kerja <span class="text-danger">*</span></label>
                        <input type="text" name="nama_unit_kerja" id="edit_nama_unit_kerja" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Alamat</label>
                        <textarea name="alamat" id="edit_alamat" class="form-control rounded-0" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Telepon</label>
                                <input type="text" name="telepon" id="edit_telepon" class="form-control rounded-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control rounded-0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Website</label>
                                <input type="url" name="website" id="edit_website" class="form-control rounded-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kepala Unit Kerja</label>
                                <input type="text" name="kepala_unit_kerja" id="edit_kepala_unit_kerja" class="form-control rounded-0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">NIP Kepala</label>
                        <input type="text" name="nip_kepala" id="edit_nip_kepala" class="form-control rounded-0">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="form-control rounded-0" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-0">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data UKP</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="viewContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
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
            url: '<?= base_url('pt/master/ukp/store') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                if(response.csrf_hash){ csrfHash = response.csrf_hash; }
                if(response.ok){
                    if(window.toastr){ toastr.success(response.message); }
                    $('#addModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(response.message); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan data'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menyimpan data'); }
                }
            }
        });
    });
    
    // Edit form submission
    $('#editForm').on('submit', function(e){
        e.preventDefault();
        
        var id = $('#edit_id').val();
        var formData = new FormData(this);
        formData.append(csrfToken, csrfHash);
        
        $.ajax({
            url: '<?= base_url('pt/master/ukp/update') ?>/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response){
                if(response.csrf_hash){ csrfHash = response.csrf_hash; }
                if(response.ok){
                    if(window.toastr){ toastr.success(response.message); }
                    $('#editModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(response.message); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupdate data'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupdate data'); }
                }
            }
        });
    });
    
    // View data
    window.viewData = function(id){
        $.get('<?= base_url('pt/master/ukp/get') ?>/' + id, function(response){
            if(response.csrf_hash){ csrfHash = response.csrf_hash; }
            if(response.ok && response.data){
                var data = response.data;
                var content = `
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><td class="font-weight-bold">Kode Unit Kerja:</td><td>${data.kode_unit_kerja || '-'}</td></tr>
                                <tr><td class="font-weight-bold">Nama Unit Kerja:</td><td>${data.nama_unit_kerja || '-'}</td></tr>
                                <tr><td class="font-weight-bold">Kepala Unit Kerja:</td><td>${data.kepala_unit_kerja || '-'}</td></tr>
                                <tr><td class="font-weight-bold">NIP Kepala:</td><td>${data.nip_kepala || '-'}</td></tr>
                                <tr><td class="font-weight-bold">Status:</td><td><span class="badge badge-${data.status === 'Aktif' ? 'success' : 'danger'}">${data.status}</span></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><td class="font-weight-bold">Telepon:</td><td>${data.telepon || '-'}</td></tr>
                                <tr><td class="font-weight-bold">Email:</td><td>${data.email || '-'}</td></tr>
                                <tr><td class="font-weight-bold">Website:</td><td>${data.website ? '<a href="' + data.website + '" target="_blank">' + data.website + '</a>' : '-'}</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless">
                                <tr><td class="font-weight-bold">Alamat:</td><td>${data.alamat || '-'}</td></tr>
                                <tr><td class="font-weight-bold">Keterangan:</td><td>${data.keterangan || '-'}</td></tr>
                            </table>
                        </div>
                    </div>
                `;
                $('#viewContent').html(content);
                $('#viewModal').modal('show');
            } else {
                if(window.toastr){ toastr.error('Data tidak ditemukan'); }
            }
        }, 'json');
    };
    
    // Edit data
    window.editData = function(id){
        $.get('<?= base_url('pt/master/ukp/get') ?>/' + id, function(response){
            if(response.csrf_hash){ csrfHash = response.csrf_hash; }
            if(response.ok && response.data){
                var data = response.data;
                $('#edit_id').val(data.id);
                $('#edit_kode_unit_kerja').val(data.kode_unit_kerja);
                $('#edit_nama_unit_kerja').val(data.nama_unit_kerja);
                $('#edit_alamat').val(data.alamat);
                $('#edit_telepon').val(data.telepon);
                $('#edit_email').val(data.email);
                $('#edit_website').val(data.website);
                $('#edit_kepala_unit_kerja').val(data.kepala_unit_kerja);
                $('#edit_nip_kepala').val(data.nip_kepala);
                $('#edit_status').val(data.status);
                $('#edit_keterangan').val(data.keterangan);
                $('#editModal').modal('show');
            } else {
                if(window.toastr){ toastr.error('Data tidak ditemukan'); }
            }
        }, 'json');
    };
    
    // Delete data
    window.deleteData = function(id, name){
        if(confirm('Apakah Anda yakin ingin menghapus data "' + name + '"?')){
            $.post('<?= base_url('pt/master/ukp/delete') ?>/' + id, {
                [csrfToken]: csrfHash
            }, function(response){
                if(response.csrf_hash){ csrfHash = response.csrf_hash; }
                if(response.ok){
                    if(window.toastr){ toastr.success(response.message); }
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(response.message); }
                }
            }, 'json').fail(function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal menghapus data'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menghapus data'); }
                }
            });
        }
    };
})();
</script>
<?= $this->endSection() ?>