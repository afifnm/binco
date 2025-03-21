<div id="myalert" style="margin-top: 10px;">
	<?php echo $this->session->flashdata('notifikasi', true)?>
</div>
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
<a href="javascript:;" data-toggle="modal" data-target="#header-footer-modal-preview"
class="button mr-auto inline-block bg-theme-1 text-white">Tambah Produk </a>
<a href="javascript:;" data-toggle="modal" data-target="#header-suara"
		class="button mr-auto inline-block bg-theme-1 text-white">Tambah Suara </a>
		<a href="javascript:;" onclick="showMutasiProduk()" class="button bg-theme-1 text-white" data-toggle="modal" data-target="#mutasi-produk-modal">Lihat Mutasi Produk</a>
	<button onclick="createAllBarcodesPDF()" class="button bg-theme-1 text-white ml-3">
		Barcode Semua Produk
	</button>

	<!-- <div class="w-full sm:w-auto flex mt-4 ml-5 sm:mt-0">
		<a href="javascript:;" data-toggle="modal" data-target="#import"
			class="button mr-1 inline-block bg-theme-1 text-white">Import </a>
	</div> -->
</div>
<div class="modal" id="import">
	<div class="modal__content modal__content--lg">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">IMPORT DATA </h2>
		</div>
		<form action="<?php echo site_url('produk/import_excel');?>" method="POST" enctype="multipart/form-data">
			<div class="intro-y box p-5">
				<div class="mt-3">
					<label>Pilih File</label>
					<div class="relative mt-2">
						<input
							accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
							type="file" name="file" id="file" class="input w-full border col-span-4" required>
					</div>
					<br>
					<a href="<?= base_url('assets/format.xlsx') ?>">Download format import</a>
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
			</div>
		</form>
	</div>
</div>
<!-- BEGIN: Datatable -->
<div class="intro-y datatable-wrapper box p-5 mt-5">
    <table class="table table-report table-report--bordered display datatable w-full">
        <thead>
            <tr>
                <th class="border-b-2 whitespace-no-wrap">NO </th>
                <th class="border-b-2 whitespace-no-wrap">NAMA </th>
                <th class="border-b-2 whitespace-no-wrap">BARCODE </th>
                <th class="border-b-2 whitespace-no-wrap">TOKO </th>
                <th class="border-b-2 whitespace-no-wrap">GUDANG</th>
                <th class="border-b-2 whitespace-no-wrap text-right">HARGA </th>
                <th class="border-b-2 text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php  $no = 1; foreach ($user as $row) {?>
            <tr>
                <td class="text-left border-b"><?= $no; ?></td>
                <td class="text-left border-b"><?= $row['nama']; ?></td>
                <td class="text-left border-b"><?= $row['kode_produk']; ?></td>
                <td class="text-left border-b"><?= $row['stok']; ?></td>
                <td class="text-left border-b"><?= $row['stok_gudang']; ?></td>
                <td class="text-right border-b"><?= number_format($row['harga']); ?></td>
                <td class="border-b w-5">
                    <div class="flex sm:justify-center items-center">
						<a href="javascript:;" onclick="createBarcodePDF('<?= $row['kode_produk'] ?>','<?= $row['nama'] ?>')" class="flex items-center text-theme-6 mr-2">
							<i data-feather="file" class="w-4 h-4"></i> Barcode
						</a>
                        <a href="javascript:;" onclick="mutasi(
                            <?= $row['id_produk'] ?>,
                            '<?= $row['nama'] ?>',
                            <?= $row['stok'] ?>,
                            <?= $row['stok_gudang'] ?>
                            )" class="flex items-center text-theme-3 ml-1 mr-1" data-toggle="modal" data-target="#mutasi-modal">
                            <i data-feather="repeat" class="w-4 h-4 mr-1"></i> Mutasi
                        </a>
                        <a href="javascript:;" onclick="edit(
                            <?= $row['id_produk'] ?>,
                            '<?= $row['nama'] ?>',
                            '<?= $row['kode_produk'] ?>',
                            '<?= $row['stok'] ?>',
                            '<?= $row['harga'] ?>',
                            '<?= $row['id_kategori'] ?>'
                            )" class="flex items-center mr-3 ml-3" data-toggle="modal" data-target="#edit-data">
                            <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit
                        </a>
                        <a href="javascript:;" onclick="hapus(<?= $row['id_produk'] ?>)" class="flex items-center text-theme-6" data-toggle="modal" data-target="#hapus-data">
                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                        </a>
                    </div>
                </td>
            </tr>
            <?php $no++; } ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
function createBarcodePDF(kode_produk,$nama) {
    // Create a canvas element to render the barcode
    const canvas = document.createElement('canvas');
    JsBarcode(canvas, kode_produk, {
        format: "CODE128",
        displayValue: true,
        height: 50
    });
    const barcodeDataUrl = canvas.toDataURL("image/png");
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.setFontSize(16);
    doc.text($nama, 105, 20, null, null, 'center');
    doc.addImage(barcodeDataUrl, 'PNG', 55, 40, 100, 30);
    doc.save(`barcode_${kode_produk}.pdf`);
}
</script>

<div class="modal" id="header-footer-modal-preview">
	<div class="modal__content">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">TAMBAH PRODUK </h2>
		</div>
		<form action="<?php echo site_url('admin/produk/simpan');?>" method="POST" enctype='multipart/form-data'>
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<div class="col-span-12 sm:col-span-12">
					<label>Nama </label>
					<input type="text" name="nama" class="input w-full border mt-2 flex-1." required>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Barcode</label>
					<input type="text" name="kode_produk" class="input w-full border mt-2 flex-1" required>
				</div>
				<div class="col-span-12 sm:col-span-12"><label>Kategori Produk</label>
					<select name="id_kategori" class="input w-full border mt-2 flex-1">
						<?php foreach ($kategori as $row) { ?>
							<option value="<?= $row['id_kategori'] ?>"><?= $row['kategori'] ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Stok Awal</label>
					<input type="number" name="stok" class="input w-full border mt-2 flex-1" required min="0" value="0">
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Harga</label>
					<input type="number" name="harga" class="input w-full border mt-2 flex-1" required min="0">
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
			</div>
		</form>
	</div>
</div>
<!-- BEGIN: EDIT Confirmation Modal -->
<div class="modal" id="edit-data">
	<div class="modal__content">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">PERBARUI PRODUK </h2>
		</div>
		<form action="<?php echo site_url('admin/produk/update');?>" method="POST" enctype='multipart/form-data'>
			<input type="hidden" name="id_produk" id="id" class="input w-full border mt-2">
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<div class="col-span-12 sm:col-span-12">
					<label>Nama </label>
					<input type="text" name="nama" id="nama" class="input w-full border mt-2 flex-1.">
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Barcode</label>
					<input type="text" name="kode_produk" class="input w-full border mt-2 flex-1" id="kode_produk">
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Kategori Produk</label>
					<select name="id_kategori" id="id_kategori" class="input w-full border mt-2 flex-1">
						<?php foreach ($kategori as $row) { ?>
							<option value="<?= $row['id_kategori'] ?>"><?= $row['kategori'] ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Stok</label>
					<input type="number" name="stok" class="input w-full border mt-2 flex-1" id="stok">
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Harga</label>
					<input type="number" name="harga" class="input w-full border mt-2 flex-1" id="harga" min="0">
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
			</div>
		</form>
	</div>
</div>
<!-- END: EDIT Confirmation Modal -->
<!-- BEGIN: Delete Confirmation Modal -->
<div class="modal" id="hapus-data">
	<div class="modal__content">
		<div class="p-5 text-center">
			<i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
			<div class="text-3xl mt-5">Apakah kamu yakin?</div>
			<div class="text-gray-600 mt-2">Apakah Anda benar-benar ingin menghapus data ini? Proses
				ini tidak bisa dibatalkan.</div>
		</div>
		<div class="px-5 pb-8 text-center">
			<button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">Batal</button>
			<a id="link_hapus" href="" class=" button w-24
				bg-theme-6 text-white">Hapus</a>
		</div>
	</div>
</div>
<!-- END: Delete Confirmation Modal -->

<!-- BEGIN: Mutasi Confirmation Modal -->
<div class="modal" id="mutasi-modal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">MUTASI PRODUK</h2>
        </div>
        <form action="<?php echo site_url('admin/produk/mutasi'); ?>" method="POST" onsubmit="return validateMutasi()">
            <input type="hidden" name="id_produk" id="mutasi-id" class="input w-full border mt-2">
            <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                <div class="col-span-12 sm:col-span-12">
                    <label>Nama Produk</label>
                    <input type="text" id="mutasi-nama" class="input w-full border mt-2 flex-1." readonly>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Stok Toko</label>
                    <input type="number" id="mutasi-stok" class="input w-full border mt-2 flex-1" readonly>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Stok Gudang</label>
                    <input type="number" id="mutasi-stok-gudang" class="input w-full border mt-2 flex-1" readonly>
                </div>
				<div class="col-span-12 sm:col-span-12">
                    <label>Jenis Mutasi</label>
                    <select id="mutasi-jenis" class="input w-full border mt-2 flex-1" name="jenis">
                        <option value="gudang_ke_toko">Gudang ke Toko</option>
						<option value="toko_ke_gudang">Toko ke Gudang</option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <label>Jumlah Mutasi</label>
                    <input type="number" name="jumlah" id="mutasi-jumlah" class="input w-full border mt-2 flex-1" required min="0">
                    <span id="mutasi-warning" style="color:red; display:none;">Jumlah mutasi melebihi stok gudang!</span>
                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200">
                <button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- END: Mutasi Confirmation Modal -->
 <!-- BEGIN: Mutasi Produk Modal -->
<div class="modal" id="mutasi-produk-modal">
    <div class="modal__content modal__content--xl">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">TABEL MUTASI PRODUK</h2>
        </div>
        <div class="p-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                    <tr>
                        <th class="border-b-2 whitespace-no-wrap">Nama Produk</th>
                        <th class="border-b-2 whitespace-no-wrap">Jumlah</th>
                        <th class="border-b-2 whitespace-no-wrap">Tanggal</th>
                        <th class="border-b-2 whitespace-no-wrap">Tanggal</th>
                    </tr>
                </thead>
                <tbody id="mutasi-produk-tbody">
                    <!-- Data will be populated here via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END: Mutasi Produk Modal -->
<div class="modal" id="return-modal">
	<div class="modal__content">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">RETURN PRODUCT</h2>
		</div>
		<form action="<?php echo site_url('admin/produk/return'); ?>" method="POST" onsubmit="return validateReturn()">
			<input type="hidden" name="id_produk" id="return-id" class="input w-full border mt-2">
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
				<div class="col-span-12 sm:col-span-12">
					<label>Product Name</label>
					<input type="text" id="return-nama" class="input w-full border mt-2 flex-1" readonly>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Category</label>
					<input type="text" id="return-kategori" class="input w-full border mt-2 flex-1" readonly>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Stock Store</label>
					<input type="number" id="return-stok" class="input w-full border mt-2 flex-1" readonly>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Stock Warehouse</label>
					<input type="number" id="return-stok-gudang" class="input w-full border mt-2 flex-1" readonly>
				</div>
				<div class="col-span-12 sm:col-span-12">
					<label>Quantity to Return</label>
					<input type="number" name="jumlah" id="return-jumlah" class="input w-full border mt-2 flex-1" required min="0">
					<span id="return-warning" style="color:red; display:none;">Quantity exceeds available stock!</span>
				</div>
			</div>
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Submit</button>
			</div>
		</form>
	</div>
</div>

<script>
    function edit(id, nama, kode_produk, stok, harga, id_kategori) {
        document.getElementById('id').value = id;
        document.getElementById('nama').value = nama;
        document.getElementById('kode_produk').value = kode_produk;
        document.getElementById('stok').value = stok;
        document.getElementById('harga').value = harga;
        document.getElementById('id_kategori').value = id_kategori; // Populate Kategori Produk
    }

    function hapus(id) {
        var link = document.getElementById('link_hapus');
        link.href = "<?php echo site_url('admin/produk/hapus/'); ?>" + id;
    }

	function mutasi(id, nama, stok, stok_gudang) {
    document.getElementById('mutasi-id').value = id;
    document.getElementById('mutasi-nama').value = nama;
    document.getElementById('mutasi-stok').value = stok;
    document.getElementById('mutasi-stok-gudang').value = stok_gudang;
}

document.getElementById('mutasi-jumlah').addEventListener('input', function() {
    validateMutasi();
});

document.getElementById('mutasi-jenis').addEventListener('change', function() {
    validateMutasi();
});

function validateMutasi() {
    var jumlahMutasi = parseInt(document.getElementById('mutasi-jumlah').value);
    var stokToko = parseInt(document.getElementById('mutasi-stok').value);
    var stokGudang = parseInt(document.getElementById('mutasi-stok-gudang').value);
    var jenisMutasi = document.getElementById('mutasi-jenis').value;

    var isValid = true;
    var warningText = '';

    if (jenisMutasi === 'toko_ke_gudang' && jumlahMutasi > stokToko) {
        isValid = false;
        warningText = 'Jumlah mutasi melebihi stok toko!';
    } else if (jenisMutasi === 'gudang_ke_toko' && jumlahMutasi > stokGudang) {
        isValid = false;
        warningText = 'Jumlah mutasi melebihi stok gudang!';
    }

    document.getElementById('mutasi-warning').style.display = isValid ? 'none' : 'block';
    document.getElementById('mutasi-warning').textContent = warningText;

    return isValid;
}
</script>
<script>
    function showMutasiProduk() {
        fetch("<?php echo site_url('admin/produk/get_mutasi_produk'); ?>")
            .then(response => response.json())
            .then(data => {
                var tbody = document.getElementById('mutasi-produk-tbody');
                tbody.innerHTML = ''; // Clear existing data
                data.forEach(function(mutasi) {
                    var tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="text-left border-b">${mutasi.nama}</td>
                        <td class="text-left border-b">${mutasi.jumlah}</td>
                        <td class="text-left border-b">${mutasi.tanggal}</td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));
    }
    document.getElementById('mutasi-produk-modal').addEventListener('show.bs.modal', showMutasiProduk);
</script>
<script>
var produk = <?php echo json_encode($user); ?>;
function createAllBarcodesPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.setFontSize(16);
    doc.text("Daftar Produk", 105, 10, null, null, 'center');
    let startY = 20;
    produk.forEach((item, index) => {
        const canvas = document.createElement('canvas');
        JsBarcode(canvas, item.kode_produk, {
            format: "CODE128",
            displayValue: true,
            height: 30,
            width: 1.5
        });
        const barcodeDataUrl = canvas.toDataURL("image/png");
        // Add the product name and kode_produk to the PDF
        doc.setFontSize(12);
        doc.text(`${index + 1}. Nama: ${item.nama}`, 20, startY);
        doc.text(`Kode Produk: ${item.kode_produk}`, 20, startY + 8);

        // Add the barcode image to the PDF
        doc.addImage(barcodeDataUrl, 'PNG', 150, startY - 5, 40, 20);
        // Move to the next line in the PDF
        startY += 20;
        // Check if we need to add a new page
        if (startY > 270) {
            doc.addPage();
            startY = 20;
        }
    });
    // Save the PDF
    doc.save('produk_barcodes.pdf');
}
</script>


<div class="modal" id="header-suara">
	<div class="modal__content">
		<div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
			<h2 class="font-medium text-base mr-auto">TAMBAH PRODUK </h2>
		</div>
		<form action="<?php echo site_url('admin/produk/simpansuara');?>" method="POST" enctype='multipart/form-data'>
			<div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12 sm:col-span-12">
					<label>Nama TPS</label>
					<input type="text" name="tps" class="input w-full border mt-2 flex-1." required>
				</div>
                <div class="col-span-12 sm:col-span-12">
					<label>Total Suara</label>
					<input type="number" name="total_suara" class="input w-full border mt-2 flex-1." required>
				</div>
                <div class="col-span-12 sm:col-span-12">
					<label>Total Suara Sah</label>
					<input type="number" name="total_suara_sah" class="input w-full border mt-2 flex-1." required>
				</div>
                <div class="col-span-12 sm:col-span-12">
					<label>Total Suara Tidak Sah</label>
					<input type="number" name="total_suara_tidak_sah" class="input w-full border mt-2 flex-1." required>
				</div>
                <div class="col-span-12 sm:col-span-12">
					<label>No 1</label>
					<input type="number" name="no1" class="input w-full border mt-2 flex-1." required>
				</div>
                <div class="col-span-12 sm:col-span-12">
					<label>No 2</label>
					<input type="number" name="no2" class="input w-full border mt-2 flex-1." required>
				</div>
                <div class="col-span-12 sm:col-span-12">
					<label>No 3</label>
					<input type="number" name="no3" class="input w-full border mt-2 flex-1." required>
				</div>
				
			<div class="px-5 py-3 text-right border-t border-gray-200">
				<button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
			</div>
		</form>
	</div>
</div>