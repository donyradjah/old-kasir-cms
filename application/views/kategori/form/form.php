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
						<form action="<?= $action ?>" method="post">

							<input type="hidden"name="idKategori" id="idKategori"
								   value="<?= $kategori["idKategori"] ?? "" ?>">

							<div class="form-group invalid mb-4">
								<label for="kategori">Kategori</label>
								<input type="text" class="form-control" name="kategori" id="kategori"
									   value="<?= $kategori["kategori"] ?? "" ?>" placeholder="Masukan Kategori ...">

								<?php if (form_error('kategori') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('kategori'); ?>
									</div>
								<?php endif; ?>

							</div>

							<button class="btn btn-primary" type="submit">
								<i data-feather="save"></i>
								SIMPAN
							</button>

							<a href="<?= base_url("kategori") ?>" class="btn btn-danger">
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
