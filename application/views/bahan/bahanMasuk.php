<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Pembelian</a>
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
                        <th class="text-center border-b-2 whitespace-no-wrap">INVOICE</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">SUPPLIER</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">TANGGAL</th>
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
								<a class="flex items-center mr-3 text-blue-500 edit-btn" href="javascript:;" 
									data-id="<?= $row['id_bahan']; ?>" 
									data-bahan="<?= $row['bahan']; ?>" 
									data-harga="<?= $row['harga']; ?>" 
									data-tw-toggle="modal" 
									data-tw-target="#edit-modal">
									<i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
								</a>
								<a class="flex items-center text-danger delete-btn" href="javascript:;" 
									data-id="<?= $row['id_bahan']; ?>">
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
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
 		<div class="modal-content">
 			<div class="modal-header">
 				<h2 class="font-medium text-base mr-auto">PILIH SUPPLIER</h2>
 			</div>

 			<div class="modal-body p-5">
             <table id="example2" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-center border-b-2 whitespace-no-wrap">NO</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">SUPPLIER</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">ALAMAT</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($supplier as $sup) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-left border-b"><?= $sup['nama']; ?></td>
                        <td class="text-left border-b"><?= $sup['alamat']; ?></td>
                        <td class="border-b">
							<div class="flex justify-center items-center">
								<a class="flex items-center text-blue-500" href="<?= base_url('admin/bahanmasuk/transaksi/'.$sup['id_supplier'])?> ">
									<i data-lucide="check" class="w-4 h-4 mr-1"></i> Pilih
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