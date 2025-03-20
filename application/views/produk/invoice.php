<div class="w-full mt-5 text-right">
    <a href="<?= base_url('admin/penjualanproduk/nota/'.$row->invoice)?>"
     target="_blank" class="btn btn-primary shadow-md mr-2">Print</a>
    <?php if($row->status){ ?>
        <button id="cancelButton" class="btn btn-primary">Batalkan Transaksi</button>
        <script>
            document.getElementById('cancelButton').addEventListener('click', function() {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, batalkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('admin/penjualanproduk/cancel/'.$row->invoice)?>';
                    }
                })
            });
        </script>
    <?php } else { ?>
        <button class="btn btn-danger" disabled>Transaksi telah dibatalkan</button>
    <?php } ?>
</div>
<div class="max-w-4xl mx-auto py-5">
    <div class="bg-white p-5 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-3 ml-5">
            <div class="text-left">
                <h1 class="text-2xl font-bold">Invoice</h1>
                <p class="text-gray-600">Invoice #<?= $row->invoice?></p>
            </div>
            <div class="text-right ml-auto">
                <h2 class="text-xl font-semibold">PT Binco Ran Nusantara</h2>
                <p class="text-gray-600">Suruh RT 02 RW 01, Kayuapak, Polokarto</p>
                <p class="text-gray-600">Sukoharjo, 57555</p>
            </div>
        </div>
        <div class="mb-3 ml-5">
            <h3 class="text-lg font-semibold">Sumber Penjualan : <?= $row->sumber ?></h3>
            <p class="text-gray-600"><?= $row->nama ?></p>
            <p class="text-gray-600"><?= $row->alamat ?></p>
            <p class="text-gray-600"><?= $row->telp ?></p>
        </div>
        <div class="px-2">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">PRODUK</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">JUMLAH</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA</th>
                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($details as $detail): ?>
                        <tr>
                            <td class="border-b dark:border-darkmode-400"><?= $detail['nama'] ?></td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32"><?= $detail['jumlah'] ?></td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32">Rp. <?= number_format($detail['harga_jual']) ?></td>
                            <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">Rp. <?= number_format($detail['jumlah']*$detail['harga_jual']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="bg-gray-100 font-bold">
                            <td colspan=3 class="border-b dark:border-darkmode-400 whitespace-no-wrap">Total Harga</td>
                            <td class="border-b dark:border-darkmode-400 text-right whitespace-no-wrap">Rp. <?= number_format($row->total) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>