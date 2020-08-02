<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

			<div class=" col-12 layout-spacing">

				<?php $this->load->view("layout/alert") ?>

				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4>Daftar Perangkat</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
						<table id="zero-config" class="table table-hover" style="width:100%">
							<thead>
							<tr>

								<th style="width: 10%;" class="">Nomor Meja</th>
								<th style="width: 15%;" class="">Perangkat</th>
								<th class="text-center">AKSI</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($perangkat["total"] > 0):
								foreach ($perangkat["data"] as $keyPerangkat => $valuePerangkat):
									?>
									<tr>

										<td class="text-center">
											<p class="mb-0"><?= $valuePerangkat["nomorMeja"] ?></p>
										</td>
										<td>
											<p class="mb-0"><?= $valuePerangkat["namaPerangkat"] ?></p>
										</td>

										<td class="text-center">
											<ul class="table-controls">
												<li>
													<a href="<?= base_url("perangkat/ubah/{$valuePerangkat["idPerangkat"]}") ?>"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Ubah Perangkat">
														<i class="text-success" data-feather="edit-2"></i>
													</a>
												</li>
												<li>
													<a href="javascript:hapus(<?= $valuePerangkat["idPerangkat"] ?>,'<?= $valuePerangkat["nomorMeja"] . ",".$valuePerangkat["namaPerangkat"] ?>');"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Hapus Perangkat <?= $valuePerangkat["namaPerangkat"] ?>">
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
