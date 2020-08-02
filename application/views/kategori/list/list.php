<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

			<div class=" col-12 layout-spacing">

				<?php $this->load->view("layout/alert") ?>

				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4>Daftar Kategori</h4>
							</div>
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4 class="text-right">
									<a href="<?= base_url("kategori/tambah") ?>" class="btn btn-outline-dark">
										<i data-feather="plus-square"></i> Tambah Kategori Baru
									</a>
								</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
						<table id="zero-config" class="table table-hover" style="width:100%">
							<thead>
							<tr>

								<th class="">Kategori</th>
								<th class="text-center">AKSI</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($kategori["total"] > 0):
								foreach ($kategori["data"] as $keyKategori => $valueKategori):
									?>
									<tr>

										<td>
											<p class="mb-0"><?= $valueKategori["kategori"] ?></p>
										</td>

										<td class="text-center">
											<ul class="table-controls">
												<li>
													<a href="<?= base_url("kategori/ubah/{$valueKategori["idKategori"]}") ?>"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Ubah Kategori">
														<i class="text-success" data-feather="edit-2"></i>
													</a>
												</li>
												<li>
													<a href="javascript:hapus(<?= $valueKategori["idKategori"] ?>,'<?= $valueKategori["kategori"] ?>');"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Hapus Kategori <?= $valueKategori["kategori"] ?>">
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
