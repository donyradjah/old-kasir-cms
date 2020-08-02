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

							<input type="hidden"name="idPerangkat" id="idPerangkat"
								   value="<?= $perangkat["idPerangkat"] ?? "" ?>">

							<div class="form-group invalid mb-4">
								<label for="perangkat">Nomor Meja</label>
								<input  type="text" class="form-control" name="nomorMeja" id="nomorMeja"
									   value="<?= $perangkat["nomorMeja"] ?? "" ?>" placeholder="Masukan Nomor Meja ...">

								<?php if (form_error('nomorMeja') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('nomorMeja'); ?>
									</div>
								<?php endif; ?>

							</div>

							<div class="form-group invalid mb-4">
								<label for="perangkat">Perangkat</label>
								<input readonly type="text" class="form-control" name="namaPerangkat" id="namaPerangkat"
									   value="<?= $perangkat["namaPerangkat"] ?? "" ?>" placeholder="Masukan Perangkat ...">

								<?php if (form_error('namaPerangkat') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('namaPerangkat'); ?>
									</div>
								<?php endif; ?>

							</div>

							<button class="btn btn-primary" type="submit">
								<i data-feather="save"></i>
								SIMPAN
							</button>

							<a href="<?= base_url("perangkat") ?>" class="btn btn-danger">
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
