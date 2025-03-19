<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Bahan</a>
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
                        <th class="text-center border-b-2 whitespace-no-wrap">BAHAN</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">STOK</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">HARGA</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($bahan as $row) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-left border-b"><?= $row['bahan']; ?></td>
                        <td class="text-center border-b"><?= $row['stok']; ?></td>
                        <td class="text-right border-b">Rp. <?= number_format($row['harga']); ?></td>
                        <td class="border-b">
							<div class="flex justify-center items-center">
								<a class="flex items-center mr-3 text-blue-500 edit-btn" href="javascript:;" data-tw-toggle="modal" 
									data-tw-target="#edit-modal"
                                    onclick="edit(
                                    '<?php echo $row['id_bahan'] ?>',
                                    '<?php echo $row['bahan'] ?>',
                                    '<?php echo $row['harga'] ?>'
                                    )">
									<i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
								</a>
								<a class="flex items-center text-danger delete-btn" href="javascript:;" 
                                    onclick="hapusProduk(<?= $row['id_bahan']; ?>)">
									<i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
								</a>
                                <a class="flex items-center text-success ml-2" href="<?= base_url('admin/bahan/log/' . $row['id_bahan']); ?>">
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
<?php require_once('_daftarBahan.php') ?>