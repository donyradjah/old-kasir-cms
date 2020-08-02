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

							<input type="hidden" name="idUser" id="idUser"
								   value="<?= $user["idUser"] ?? "" ?>">

							<div class="form-group invalid mb-4">
								<label for="nama">Nama</label>
								<input type="text" class="form-control" name="nama" id="nama"
									   value="<?= $user["nama"] ?? "" ?>" placeholder="Masukan Nama ...">

								<?php if (form_error('nama') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('nama'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="username">Username</label>
								<input type="text" class="form-control" name="username" id="username"
									   value="<?= $user["username"] ?? "" ?>" placeholder="Masukan Username ...">

								<?php if (form_error('username') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('username'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" id="email"
									   value="<?= $user["email"] ?? "" ?>" placeholder="Masukan Email ...">

								<?php if (form_error('email') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('email'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="password">Password</label>
								<input type="password" class="form-control" name="password" id="password"
									   value="" placeholder="Masukan Password ...">

								<?php if (form_error('password') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('password'); ?>
									</div>
								<?php endif; ?>
							</div>

							<div class="form-group invalid mb-4">
								<label for="confirm_password">Konfirmasi Password</label>
								<input type="password" class="form-control" name="confirm_password"
									   id="confirm_password"
									   value="" placeholder="Masukan Konfirmasi Password ...">

								<?php if (form_error('confirm_password') != ""): ?>
									<div class="mt-2">
										<?php echo form_error('confirm_password'); ?>
									</div>
								<?php endif; ?>
							</div>

							<button class="btn btn-primary" type="submit">
								<i data-feather="save"></i>
								SIMPAN
							</button>

							<a href="<?= base_url("user") ?>" class="btn btn-danger">
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
