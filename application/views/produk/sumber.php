<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Sumber</a>
</div>
<!-- END: Modal Toggle -->
 <!-- BEGIN: Datatable -->
 <div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <!-- DataTables Table -->
                <table id="example1" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-center border-b-2 whitespace-no-wrap">NO</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">SUMBER PENJUALAN</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($sumber as $row) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-left border-b"><?= $row['sumber']; ?></td>
                        <td class="border-b">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3 text-blue-500 edit-btn" href="javascript:;"
                                    data-tw-toggle="modal" 
                                    data-tw-target="#edit-modal"
                                    onclick="edit('<?= $row['id_sumber'] ?>', '<?= $row['sumber'] ?>')">
                                    <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                </a>
                                <a class="flex items-center text-danger delete-btn" href="javascript:;" onclick="hapusSumber(<?= $row['id_sumber']; ?>)">
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: Modal Edit Sumber -->
<div id="edit-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">EDIT SUMBER PENJUALAN</h2>
            </div>
            <form action="<?= base_url('admin/sumber/update') ?>" method="post">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input type="hidden" name="id_sumber" id="edit-id">
                    <div class="col-span-12">
                        <label class="form-label">Sumber Penjualan</label>
                        <input name="sumber" id="edit-sumber" type="text" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                    <button type="submit" class="btn btn-primary w-20">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- BEGIN: Modal Tambah Sumber -->
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">TAMBAH SUMBER PENJUALAN</h2>
            </div>
            <form action="<?= base_url('admin/sumber/simpan') ?>" method="post">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <label class="form-label">Sumber Penjualan</label>
                        <input name="sumber" type="text" class="form-control" placeholder="Sumber penjualan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                    <button type="submit" class="btn btn-primary w-20">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function edit(id_sumber, sumber) {
        document.getElementById('edit-id').value = id_sumber;
        document.getElementById('edit-sumber').value = sumber;
    }
    function hapusSumber(id) {
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data ini akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/sumber/hapus/') ?>" + id;
            }
        });
    }
</script>