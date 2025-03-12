<!-- BEGIN: Modal Toggle -->
<div class="text-left mt-8">
	<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#header-footer-modal-preview"
 		class="btn btn-primary">Tambah Bahan</a>
</div>
<!-- END: Modal Toggle -->
<!-- BEGIN: Modal Content -->
<div id="header-footer-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
 	<div class="modal-dialog">
 		<div class="modal-content">
 			<!-- BEGIN: Modal Header -->
 			<div class="modal-header">
 				<h2 class="font-medium text-base mr-auto">TAMBAH BAHAN</h2>
 			</div> <!-- END: Modal Header -->
 			<!-- BEGIN: Modal Body -->
 			<div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
			 	<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Nama Bahan</label>
 					<input name="bahan" id="modal-form-1" type="text" class="form-control" placeholder="Nama bahan" required>
				</div>
				<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Stok Awal</label>
 					<input name="stok" id="modal-form-1" type="number" class="form-control" placeholder="Stok awal bahan" required>
				</div>
				<div class="col-span-12">
					<label for="modal-form-1" class="form-label">Harga Jual</label>
 					<input name="harga" id="modal-form-1" type="number" class="form-control" placeholder="Harga jual" required>
				</div>
 			</div>
			<!-- END: Modal Body -->
 			<!-- BEGIN: Modal Footer -->
 			<div class="modal-footer">
				<button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
				<button type="submit" class="btn btn-primary w-20">Simpan</button>
			</div>
			<!-- END: Modal Footer -->
 		</div>
 	</div>
 </div> <!-- END: Modal Content -->