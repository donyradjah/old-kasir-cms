<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

			<div class=" col-12 layout-spacing">

				<?php $this->load->view("layout/alert") ?>

				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4>Daftar User</h4>
							</div>
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4 class="text-right">
									<a href="<?= base_url("user/tambah") ?>" class="btn btn-outline-dark">
										<i data-feather="plus-square"></i> Tambah User Baru
									</a>
								</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
						<table id="zero-config" class="table table-hover" style="width:100%">
							<thead>
							<tr>

								<th class="">Nama</th>
								<th class="">Username</th>
								<th class="">Email</th>
								<th class="text-center">AKSI</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($user["total"] > 0):
								foreach ($user["data"] as $keyUser => $valueUser):
									?>
									<tr>

										<td>
											<p class="mb-0"><?= $valueUser["nama"] ?></p>
										</td>
										<td>
											<p class="mb-0"><?= $valueUser["username"] ?></p>
										</td>
										<td>
											<p class="mb-0"><?= $valueUser["email"] ?></p>
										</td>

										<td class="text-center">
											<ul class="table-controls">
												<li>
													<a href="<?= base_url("user/ubah/{$valueUser["idUser"]}") ?>"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Ubah User">
														<i class="text-success" data-feather="edit-2"></i>
													</a>
												</li>
												<li>
													<a href="javascript:hapus(<?= $valueUser["idUser"] ?>,'<?= $valueUser["nama"] ?>');"
													   data-toggle="tooltip"
													   data-placement="top"
													   title=""
													   data-original-title="Hapus User <?= $valueUser["nama"] ?>">
														<i class="text-danger" data-feather="trash-2"></i>
													</a>
												</li>
											</ul>
										</td>
									</tr>

								<?php
								endforeach;
							endif;
							?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

		</div>

	</div>

</div>
