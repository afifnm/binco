<div class="grid grid-cols-3 gap-6 mt-5">
    <div class="intro-y col-span-1">
        <!-- BEGIN: Keranjang -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Pilih produk terlebih dahulu
                </h2>
            </div>
            <div class="p-5">
                <form action="<?= base_url('admin/penjualanproduk/tambahKeranjang') ?>" method="post">
                    <div class="preview">
                        <div class="mt-1">
                            <label>Nama Pelanggan</label>
                            <input type="text" class="input w-full border bg-gray-100" value="<?= $this->Func_model->namapelanggan($id_pelanggan) ?>" disabled>
                        </div>
                        <div class="mt-2">
                            <label>Nama Produk</label>
                            <select class="select2 w-full border bg-gray-100" name="id_produk" id="produk" required>
                                <option value="">Pilih Produk</option>
                                <?php foreach($produk as $aa){ ?>
                                <option value="<?= $aa['id_produk'] ?>"
                                data-harga="<?= $aa['harga'] ?>"
                                data-stok="<?= $aa['stok'] ?>">
                                    <?= $aa['nama'] ?> (<?= $aa['stok'] ?>)
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label>Jumlah</label>
                            <input id="jumlah" type="number" class="input w-full border" placeholder="jumlah" min=1 required
                                name="jumlah">
                        </div>
                        <div class="mt-2">
                            <label>Harga Jual</label>
                            <input type="number" class="input w-full border" placeholder="harga jual" id="harga" readonly
                                name="harga">
                        </div>
                        <div class="mt-5">
                            <button
                                class="btn btn-primary mr-2 mb-2 flex items-center justify-center bg-theme-1 text-white w-full">
                                <i data-feather="plus" class="w-4 h-4 mr-2"></i> Tambah  </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END: Keranjang -->
    </div>
    <div class="intro-y col-span-2">
        <!-- BEGIN: Bayar -->
        <div class="intro-y box">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                <h2 class="font-medium text-base mr-auto">
                    Daftar produk yang dipilih
                </h2>
            </div>
            <div class="p-5">
                <div class="overflow-x-auto">
                    <?php if($keranjangproduk==NULL) { ?>
                    <div class="rounded-md px-5 py-4 mb-2 bg-gray-200 text-gray-600">Belum ada produk yang dipilih,
                        silahkan pilih produk ke keranjang terlebih dahulu.</div>
                    <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-b-2 whitespace-no-wrap">#</th>
                                <th class="border-b-2 whitespace-no-wrap">Nama Produk</th>
                                <th class="border-b-2 whitespace-no-wrap">Jumlah</th>
                                <th class="border-b-2 whitespace-no-wrap  text-right">Harga</th>
                                <th class="border-b-2 whitespace-no-wrap  text-right">Total</th>
                                <th class="border-b-2 whitespace-no-wrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total=0; $no=1; foreach($keranjangproduk as $row){ ?>
                            <tr>
                                <td class="border-b whitespace-no-wrap"><?= $no; ?></td>
                                <td>
                                    <?= $this->Func_model->namaproduk($row['id_produk']) ?>
                                </td>
                                <td class="border-b whitespace-no-wrap"><?= $row['jumlah'] ?></td>
                                <td class="border-b whitespace-no-wrap text-right">Rp.
                                    <?=  number_format($row['harga']) ?></td>
                                <td class="border-b whitespace-no-wrap text-right">Rp.
                                    <?=  number_format($row['jumlah']*$row['harga']) ?></td>
                                <td class="border-b whitespace-no-wrap">
                                    <div class="flex sm:justify-center items-center">
                                        <a href="#" class="delete-btn text-danger flex items-center" data-id="<?= $row['id_produk']; ?>">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php $total=$total+$row['jumlah']*$row['harga']; $no++; } ?>
                            <tr>
                                <td colspan=4 class="border-b whitespace-no-wrap">Total Harga</td>
                                <td class="border-b whitespace-no-wrap text-right">Rp. <?= number_format($total) ;?>
                                </td>
                                <td class="border-b whitespace-no-wrap">-</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-5">
                        <label>Sumber Penjualan</label>
                        <select class="select2 w-full border" name="sumber_penjualan" id="sumber_penjualan" required>
                            <option value="">Pilih Sumber Penjualan</option>
                            <?php 
                            foreach ($this->Func_model->sumber() as $sumber) {
                                echo "<option value='{$sumber['id_sumber']}'>{$sumber['sumber']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mt-5">
                        <button type="button" id="submit-btn"
                            class="btn btn-primary mr-2 mb-2 flex items-center justify-center bg-theme-1 text-white w-full">
                            <i data-feather="plus" class="w-4 h-4 mr-2"></i> Bayar
                        </button>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- END: Bayar -->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll(".delete-btn").forEach(btn => {
    btn.addEventListener("click", function() {
        let id = this.dataset.id;
        Swal.fire({
            text: "Yakin ingin menghapus?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya",
            cancelButtonText: "Batal"
        }).then(result => {
            if (result.isConfirmed) window.location.href = "<?= base_url('admin/penjualanproduk/hapus/') ?>" + id;
        });
    });
});
</script>
<script>
document.getElementById("submit-btn").addEventListener("click", function() {
    Swal.fire({
        title: "Konfirmasi Pembayaran",
        text: "Apakah Anda yakin ingin membayar?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Bayar",
        cancelButtonText: "Batal"
    }).then(result => {
        if (result.isConfirmed) {
            let sumberPenjualan = document.getElementById("sumber_penjualan").value; // Ambil nilai sumber_penjualan

            if (!sumberPenjualan) {
                Swal.fire({
                    title: "Peringatan",
                    text: "Silakan pilih sumber penjualan terlebih dahulu!",
                    icon: "warning",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK"
                });
                return;
            }

            let form = document.createElement("form");
            form.method = "POST";
            form.action = "<?= base_url('admin/penjualanproduk/checkout') ?>";

            let inputTotal = document.createElement("input");
            inputTotal.type = "hidden";
            inputTotal.name = "total";
            inputTotal.value = "<?= $total ?>";

            let inputSupplier = document.createElement("input");
            inputSupplier.type = "hidden";
            inputSupplier.name = "id_pelanggan";
            inputSupplier.value = "<?= $id_pelanggan ?>";

            let inputSumber = document.createElement("input");
            inputSumber.type = "hidden";
            inputSumber.name = "sumber_penjualan";
            inputSumber.value = sumberPenjualan; // Tambahkan sumber_penjualan

            form.appendChild(inputTotal);
            form.appendChild(inputSupplier);
            form.appendChild(inputSumber);
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>

<script>
    $(document).ready(function () {
        $('#produk').on('change', function () {
            var harga = $(this).find(':selected').data('harga');
            $('#harga').val(harga);
            $('#jumlah').val('');
        });

        $('#jumlah').on('input', function () {
            var stok = $('#produk').find(':selected').data('stok');
            var jumlah = $(this).val();

            if (jumlah > stok) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Tidak Cukup!',
                    text: 'Jumlah stok yang tersedia (' + stok + ').',
                    confirmButtonColor: '#3085d6'
                });
                $(this).val(stok); // Mengatur kembali ke stok maksimum
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#produk').select2({
            placeholder: "Pilih Produk",
            allowClear: true
        });
    });
</script>
