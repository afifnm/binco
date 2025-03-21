 <!-- BEGIN: Datatable -->
 <div class="intro-y box mt-3">
    <div class="p-5">
        <div class="text-xl font-medium mt-1"><?= $bahan->bahan ?> (Stok : <?= $bahan->stok?>)</div>
        <div class="preview">
            <div class="overflow-x-auto">
                <!-- DataTables Table -->
                <table id="log" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="text-center border-b-2 whitespace-no-wrap">NO</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">TRANSAKSI</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">JUMLAH</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">HARGA</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">TANGGAL</th>
                        <th class="text-center border-b-2 whitespace-no-wrap">STOK</th>
                        <th class="text-center border-b-2 whitespace-no-wrap text-center">INVOICE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $stok=0; $no = 1; foreach ($logs as $row) {?>
                    <tr>
                        <td class="text-center border-b"><?= $no; ?></td>
                        <td class="text-center border-b"><?= $row['tipe']; ?></td>
                        <td class="text-center border-b"><?= $row['jumlah']; ?></td>
                        <td class="text-right border-b">Rp. <?= number_format($row['harga_satuan']); ?></td>
                        <td class="text-center border-b">
                            <?= date('d F Y H:i', strtotime($row['tanggal'])); ?>
                        </td>
                        <td class="text-center border-b">
                            <?php
                            if (strpos($row['invoice'], 'S') === 0) { 
                                // Jika invoice diawali "S" (Penjualan)
                                if ($row['tipe'] == 'pembatalan') {
                                    $stok += $row['jumlah']; // Jika dibatalkan, stok bertambah
                                } else {
                                    $stok -= $row['jumlah']; // Normalnya, stok berkurang
                                }
                            } elseif (strpos($row['invoice'], 'B') === 0) { 
                                // Jika invoice diawali "B" (Pembelian)
                                if ($row['tipe'] == 'pembatalan') {
                                    $stok -= $row['jumlah']; // Jika dibatalkan, stok berkurang
                                } else {
                                    $stok += $row['jumlah']; // Normalnya, stok bertambah
                                }
                            }
                            ?>
                            <?= $stok; ?>
                        </td>
                        <td class="border-b">
                            <div class="flex justify-center items-center">
                                <?php
                                $prefix = substr($row['invoice'], 0, 1);
                                $url = ($prefix === 'B') ? 'bahanmasuk' : (($prefix === 'S') ? 'bahankeluar' : '#');
                                ?>
                                <a class="flex items-center text-blue-500" href="<?= base_url('admin/'.$url.'/invoice/'.$row['invoice']) ?>">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-1"></i> Invoice #<?= $row['invoice'] ?>
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