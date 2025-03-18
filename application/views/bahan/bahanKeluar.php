<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Penjualan</a>
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
                        <th class="text-center border-b-2 whitespace-no-wrap">STATUS</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">PELANGGAN</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">TANGGAL</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">TAGIHAN</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($bahan as $row) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-center border-b"><?= $row['invoice']; ?></td>
                        <td class="text-center border-b">
                            <?php if($row['status']==0){ ?>
                                <div class="flex items-center justify-center whitespace-nowrap text-danger"> <i data-lucide="x-square" class="w-4 h-4 mr-2"></i> Cancel </div>
                            <?php } else { ?>
                                <div class="flex items-center justify-center whitespace-nowrap text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Completed </div>
                            <?php } ?>
                        </td>
                        <td class="text-center border-b"><?= $row['nama']; ?></td>
                        <td class="text-center border-b"><?= date('d F Y H:i', strtotime($row['tanggal'])); ?></td>
                        <td class="text-right border-b">Rp. <?= number_format($row['total']); ?></td>
                        <td class="border-b">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center text-blue-500" href="<?= base_url('admin/bahankeluar/invoice/'.$row['invoice'])?>">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-1"></i> Invoice
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
 				<h2 class="font-medium text-base mr-auto">PILIH PELANGGAN</h2>
 			</div>

 			<div class="modal-body p-5">
             <table id="example2" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-center border-b-2 whitespace-no-wrap">NO</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">NAMA PELANGGAN</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">ALAMAT</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; foreach ($pelanggan as $sup) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-left border-b"><?= $sup['nama']; ?></td>
                        <td class="text-left border-b"><?= $sup['alamat']; ?></td>
                        <td class="border-b">
							<div class="flex justify-center items-center">
								<a class="flex items-center text-blue-500" href="<?= base_url('admin/bahankeluar/transaksi/'.$sup['id_pelanggan'])?> ">
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