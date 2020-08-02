<div id="content" class="main-content">
	<div class="layout-px-spacing">

		<div class="row layout-top-spacing">

			<div class=" col-12 layout-spacing">

				<?php $this->load->view("layout/alert") ?>

				<div class="statbox widget box box-shadow">
					<div class="widget-header">
						<div class="row">
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4>Daftar Produk</h4>
							</div>
							<div class="col-xl-6 col-md-6 col-sm-6 col-6">
								<h4 class="text-right">
									<a href="<?= base_url("produk/tambah") ?>" class="btn btn-outline-dark">
										<i data-feather="plus-square"></i> Tambah Produk Baru
									</a>
								</h4>
							</div>
						</div>
					</div>
					<div class="widget-content widget-content-area">
						<table id="zero-config" class="table table-hover" style="width:100%">
							<thead>
							<tr>
								<th class="" style="width: 5%;"></th>
								<th class="text-center" style="width: 12%;">Kode Produk</th>
								<th class="">Nama Produk</th>
								<th class="text-center" style="width: 12%;">Harga Produk</th>
								<th class="">Kategori</th>
								<th class="text-right">Status</th>
								<th class="text-center">AKSI</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($produk["total"] > 0):
								foreach ($produk["data"] as $keyProduk => $valueProduk):
									?>
									<tr>
										<td>
											<img style="width: 80%;margin: 0 auto;"
												 src="<?= base_url("upload/produk/" . $valueProduk["gambarProduk"]) ?>"
												 alt="">
										</td>
										<td class="text-center font-weight-bold" style="width: 12%;">
											<?= $valueProduk["kodeProduk"] ?>
										</td>
										<td>
											<p class="mb-0"><?= $valueProduk["namaProduk"] ?></p>
										</td>
										<td>
											<p class="mb-0 text-center font-weight-bold"><?= rupiah($valueProduk["harga"]) ?></p>
										</td>
										<td>
											<?php
											if ($valueProduk["kategori"]["total"] > 0):
												foreach ($valueProduk["kategori"]["data"] as $keyKategori => $valueKategori):
													?>
													<span
														class="badge badge-info"> <?= $valueKategori["kategori"] ?> </span>
												<?php
												endforeach;
											endif;
											?>
										</td>
										<td>
											<p class="text-right">
												<label class="switch s-success mr-2">
													<input  onchange="gantiStatus('<?= $valueProduk["idProduk"] ?>')" id="status-<?= $valueProduk["idProduk"] ?>" type="checkbox" <?= $valueProduk["status"] == "tersedia" ? " checked " : "" ?>>
													<span class="slider round"></span>
												</label>
											</p>
										</td>

										<td class="text-center">
											<ul class="table-controls">
												<li>
													<a href="<?= base_url("produk/ubah/{$valueProduk["idProduk"]}") ?>"
													   data-toggle="tooltip"
													   data-placement="top"
													   title="" data-original-title="Ubah Produk">
														<i class="text-success" data-feather="edit-2"></i>
													</a>
												</li>
												<li>
													<a href="javascript:hapus(<?= $valueProduk["idProduk"] ?>,'<?= $valueProduk["namaProduk"] ?>');"
													   data-toggle="tooltip"
													   data-placement="top"
													   title=""
													   data-original-title="Hapus Produk <?= $valueProduk["namaProduk"] ?>">
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
