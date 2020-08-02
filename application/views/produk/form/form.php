<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

			<div class=" col-12 layout-spacing">

				<?php $this->load->view("layout/alert") ?>

				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-12 col-md-12 col-sm-12 col-12">
								<h4><?= $title ?></h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
						<form id="formProduk" action="<?= $action ?>" method="post" enctype="multipart/form-data">

							<input type="hidden" name="idProduk" id="idProduk"
								   value="<?= $produk["idProduk"] ?? "" ?>">
							<input type="hidden" name="kategoriId" id="kategoriId"
								   value="<?= $produk["kategoriId"] ?? "" ?>">

							<div class="form-group invalid mb-4">
								<label for="kodeProduk">Kode Produk</label>
								<input type="text" class="form-control" name="kodeProduk" id="kodeProduk"
									   value="<?= $produk["kodeProduk"] ?? "" ?>"
									   placeholder="Masukan Kode Produk ...">

								<?php if (form_error('kodeProduk') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('kodeProduk'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="namaProduk">Nama Produk</label>
								<input type="text" class="form-control" name="namaProduk" id="namaProduk"
									   value="<?= $produk["namaProduk"] ?? "" ?>"
									   placeholder="Masukan Nama Produk ...">

								<?php if (form_error('namaProduk') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('namaProduk'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="harga">Harga Produk</label>
								<input type="text" class="form-control" name="harga" id="harga"
									   value="<?= $produk["harga"] ?? "" ?>"
									   placeholder="Masukan Harga Produk ...">

								<?php if (form_error('harga') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('harga'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="kategori">Kategori</label>

								<?php
								$kategoriId = [];
								if (isset($produk)) {
									$kategoriId = explode(",", $produk["kategoriId"]);
								}
								?>

								<select class="form-control kategori" id="kategori" name="kategori"
										multiple="multiple">
									<?php
									if ($kategori["total"] > 0) {
										foreach ($kategori["data"] as $keyKategori => $valueKategori) {
											?>
											<option <?= in_array($valueKategori["idKategori"], $kategoriId) ? " SELECTED " : "" ?>
												value="<?= $valueKategori["idKategori"] ?>"><?= $valueKategori["kategori"] ?></option>
										<?php }
									} ?>
								</select>

								<?php if (form_error('kategoriId') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('kategoriId'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group mb-4 mt-3">
								<label for="gambarProduk">Gambar Produk</label>
								<br>
								<img
									src="<?= base_url("upload/produk/") ?><?= $produk["gambarProduk"] ?? "default.jpg" ?>"
									id="imgProduk" name="imgProduk"  height="400" class="mb-3">
								<input type="file" class="form-control-file" id="gambarProduk" name="gambarProduk">
							</div>

							<button class="btn btn-primary" type="submit">
								<i data-feather="save"></i>
								SIMPAN
							</button>

							<a href="<?= base_url("produk") ?>" class="btn btn-danger">
								<i data-feather="x-square"></i>
								CANCEL
							</a>
						</form>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>
