<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Supplier</a>
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
                        <th class="text-center border-b-2 whitespace-no-wrap">NAMA</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">ALAMAT</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">TELP</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($supplier as $row) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-left border-b"><?= $row['nama']; ?></td>
                        <td class="text-left border-b"><?= $row['alamat']; ?></td>
                        <td class="text-center border-b"><?= $row['telp']; ?></td>
                        <td class="border-b">
							<div class="flex justify-center items-center">
								<a class="flex items-center mr-3 text-blue-500 edit-btn" href="javascript:;" 
									data-id="<?= $row['id_supplier']; ?>" 
									data-nama="<?= $row['nama']; ?>" 
									data-alamat="<?= $row['alamat']; ?>" 
									data-telp="<?= $row['telp']; ?>" 
									data-tw-toggle="modal" 
									data-tw-target="#edit-modal">
									<i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
								</a>
								<a class="flex items-center text-danger delete-btn" href="javascript:;" 
									data-id="<?= $row['id_supplier']; ?>">
									<i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
								</a>
                                <a class="flex items-center text-success ml-2" href="<?= base_url('admin/supplierbahan/transaksi/'.$row['id_supplier'])?>">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-1"></i> Transaksi
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
<?php require_once('_supplier.php') ?>
