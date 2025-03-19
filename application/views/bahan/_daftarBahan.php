<!-- BEGIN: Modal Edit Bahan -->
<div id="edit-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">EDIT BAHAN</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form action="<?= base_url('admin/bahan/update') ?>" method="post">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input type="hidden" name="id_bahan" id="edit-id"> <!-- Hidden ID -->
                    <div class="col-span-12">
                        <label class="form-label">Nama Bahan</label>
                        <input name="bahan" id="edit-bahan" type="text" class="form-control" required>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Harga Jual</label>
                        <input name="harga" id="edit-harga" type="number" min="0" class="form-control" required>
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
<!-- END: Modal Edit Bahan -->
<!-- BEGIN: Modal Content -->
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
 	<div class="modal-dialog">
 		<div class="modal-content">
 			<!-- BEGIN: Modal Header -->
 			<div class="modal-header">
 				<h2 class="font-medium text-base mr-auto">TAMBAH BAHAN</h2>
 			</div> <!-- END: Modal Header -->
 			<!-- BEGIN: Modal Body -->
			<form action="<?= base_url('admin/bahan/simpan') ?>" method="post">
 			<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
			 	<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Nama Bahan</label>
 					<input name="bahan" id="modal-form-1" type="text" class="form-control" placeholder="Nama bahan" required>
				</div>
				<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Harga Jual</label>
 					<input name="harga" min="0" id="modal-form-1" type="number" class="form-control" placeholder="Harga jual" required>
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
	function edit(id_produk, bahan, harga) {
        document.getElementById('edit-id').value = id_produk;
        document.getElementById('edit-bahan').value = bahan;
        document.getElementById('edit-harga').value = harga;
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
                window.location.href = "<?= base_url('admin/bahan/hapus/') ?>" + id;
            }
        });
    }
</script>
