<!-- BEGIN: Modal Edit Supplier -->
<div id="edit-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">EDIT PELANGGAN</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form action="<?= base_url('admin/pelanggan/update') ?>" method="post">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input type="hidden" name="id_pelanggan" id="edit-id"> <!-- Hidden ID -->
                    <div class="col-span-12">
                        <label class="form-label">Nama </label>
                        <input name="nama" id="edit-nama" type="text" class="form-control" required>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Alamat</label>
                        <input name="alamat" id="edit-alamat" type="text" class="form-control" required>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Telepon</label>
                        <input name="telp" id="edit-telp" type="text" class="form-control" required>
                    </div>
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                    <button type="submit" class="btn btn-primary w-20">Update</button>
                </div>
                <!-- END: Modal Footer -->
            </form>
        </div>
    </div>
</div>
<!-- END: Modal Edit Supplier -->
<!-- BEGIN: Modal Content -->
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">TAMBAH PELANGGAN</h2>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form action="<?= base_url('admin/pelanggan/simpan') ?>" method="post">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12">
                        <label class="form-label">Nama</label>
                        <input name="nama" id="modal-form-nama" type="text" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Alamat</label>
                        <input name="alamat" id="modal-form-alamat" type="text" class="form-control" placeholder="Alamat" required>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Telepon</label>
                        <input name="telp" id="modal-form-telp" type="text" class="form-control" placeholder="contoh masukan  +628967333318" required>
                    </div>
                </div>
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                    <button type="submit" class="btn btn-primary w-20">Simpan</button>
                </div>
                <!-- END: Modal Footer -->
            </form>
        </div>
    </div>
</div> <!-- END: Modal Content -->
<script>
    // Handle Klik Tombol Edit
	function edit(id_pelanggan, nama, alamat, telp) {
        document.getElementById('edit-id').value = id_pelanggan;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-alamat').value = alamat;
        document.getElementById('edit-telp').value = telp;
	};
    function hapusProduk(id) {
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
                window.location.href = "<?= base_url('admin/pelanggan/hapus/') ?>" + id;
            }
        });
    }
</script>
