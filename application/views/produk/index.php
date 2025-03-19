<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Produk</a>
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
                        <th class="text-center border-b-2 whitespace-no-wrap">NAMA PRODUK</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">STOK</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">HARGA</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($produk as $row) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-left border-b"><?= $row['nama']; ?></td>
                        <td class="text-center border-b"><?= $row['stok']; ?></td>
                        <td class="text-right border-b">Rp. <?= number_format($row['harga']); ?></td>
                        <td class="border-b">
							<div class="flex justify-center items-center">
								<a class="flex items-center mr-3 text-blue-500 edit-btn" href="javascript:;"
                                    data-tw-toggle="modal" 
									data-tw-target="#edit-modal"
                                    onclick="edit(
                                    '<?php echo $row['id_produk'] ?>',
                                    '<?php echo $row['nama'] ?>',
                                    '<?php echo $row['stok'] ?>',
                                    '<?php echo $row['harga'] ?>'
                                    )">
									<i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
								</a>
								<a class="flex items-center text-danger delete-btn" href="javascript:;" onclick="hapusProduk(<?= $row['id_produk']; ?>)">
									<i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
								</a>
                                <a class="flex items-center text-success ml-2" href="<?= base_url('admin/produk/log/' . $row['id_produk']); ?>">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-1"></i> Log
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
<!-- BEGIN: Modal Edit produk -->
<div id="edit-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">EDIT produk</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form action="<?= base_url('admin/produk/update') ?>" method="post">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input type="hidden" name="id_produk" id="edit-id"> <!-- Hidden ID -->
                    <div class="col-span-12">
                        <label class="form-label">Nama Produk</label>
                        <input name="nama" id="edit-nama" type="text" class="form-control" required>
                    </div>
                    <div class="col-span-12">
                        <label class="form-label">Stok </label>
                        <input name="stok" id="edit-stok" type="text" class="form-control" required>
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
<!-- END: Modal Edit produk -->
<!-- BEGIN: Modal Content -->
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
 	<div class="modal-dialog">
 		<div class="modal-content">
 			<!-- BEGIN: Modal Header -->
 			<div class="modal-header">
 				<h2 class="font-medium text-base mr-auto">TAMBAH PRODUK</h2>
 			</div> <!-- END: Modal Header -->
 			<!-- BEGIN: Modal Body -->
			<form action="<?= base_url('admin/produk/simpan') ?>" method="post">
 			<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
			 	<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Nama Produk</label>
 					<input name="nama" id="modal-form-1" type="text" class="form-control" placeholder="Nama produk" required>
				</div>
				<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Stok</label>
 					<input name="stok" min="0" id="modal-form-1" type="number" class="form-control" placeholder="Stok" required>
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
	function edit(id_produk, nama, stok, harga) {
        document.getElementById('edit-id').value = id_produk;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-stok').value = stok;
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
                window.location.href = "<?= base_url('admin/produk/hapus/') ?>" + id;
            }
        });
    }
</script>
