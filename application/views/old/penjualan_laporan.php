<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Laporan Penjualan</title>
	<script>
        function printReport() {
            window.print();
        }
    </script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Date Range Filter Form -->
        <form method="get" action="<?= base_url('admin/penjualan/laporan'); ?>" class="p-4 bg-gray-200">
            <div class="flex flex-col md:flex-row md:space-x-4">
                <div class="flex-1">
                    <label for="tanggal1" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal1" id="tanggal1" value="<?= isset($tanggal1) ? $tanggal1 : ''; ?>" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1">
                    <label for="tanggal2" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="tanggal2" id="tanggal2" value="<?= isset($tanggal2) ? $tanggal2 : ''; ?>" 
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex items-end mt-4 md:mt-0">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
                    <button type="button" onclick="printReport()" class="inline-flex items-center px-4 py-2 ml-2 bg-green-600 text-white rounded-md hover:bg-green-700">Print</button>
                </div>
            </div>
        </form>

        <!-- Sales Report Table -->
        <table class="min-w-full divide-y divide-gray-200 mt-4">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Penjualan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php 
                $total_jumlah = 0;
                $total_harga = 0;
                foreach($laporan_penjualan as $row): 
                    // Accumulate totals
                    $total_jumlah += $row['jumlah'];
                    $total_harga += $row['total_harga'];
                ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['kode_penjualan']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= date('d F Y', strtotime($row['tanggal'])); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['nama']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right"><?= $row['jumlah']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right"><?= number_format($row['harga'], 2); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-right"><?= number_format($row['total_harga'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="px-6 py-4 font-bold text-right">Total:</td>
                    <td class="px-6 py-4 text-right font-bold"><?= $total_jumlah; ?> </td>
                    <td></td>
                    <td class="px-6 py-4 text-right font-bold">Rp.<?= number_format($total_harga, 2); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

</body>
</html>
